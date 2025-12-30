<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentPlan;
use App\Models\Installment;
use App\Models\Policy;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    /**
     * Ödeme listesi
     */
    public function index(Request $request)
    {
        $query = Payment::with([
            'customer',
            'policy',
            'installment.paymentPlan',
            'createdBy'
        ]);

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_reference', 'like', "%{$search}%")
                ->orWhereHas('customer', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })
                ->orWhereHas('policy', function($q) use ($search) {
                    $q->where('policy_number', 'like', "%{$search}%");
                });
            });
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ödeme yöntemi filtresi
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Tarih filtresi
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $sortBy = $request->get('sort_by', 'payment_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $payments = $query->get();

        $stats = [
            'total' => Payment::sum('amount'),
            'completed' => Payment::where('status', 'completed')->sum('amount'),
            'pending' => Payment::where('status', 'pending')->sum('amount'),
            'failed' => Payment::where('status', 'failed')->sum('amount'),
            'count' => Payment::count(),
        ];

        return view('payments.index', compact('payments', 'stats'));
    }

    /**
     * Taksit planları listesi
     */
    public function installments(Request $request)
    {
        $query = Installment::with([
            'paymentPlan.policy.customer',
            'paymentPlan.policy',
            'payment'
        ]);

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('paymentPlan.policy', function($q) use ($search) {
                $q->where('policy_number', 'like', "%{$search}%")
                ->orWhereHas('customer', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            });
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tarih filtresi
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'due_today':
                    $query->whereDate('due_date', now());
                    break;
                case 'overdue':
                    $query->where('due_date', '<', now())
                        ->where('status', 'pending');
                    break;
                case 'upcoming_7':
                    $query->whereBetween('due_date', [now(), now()->addDays(7)])
                        ->where('status', 'pending');
                    break;
                case 'upcoming_30':
                    $query->whereBetween('due_date', [now(), now()->addDays(30)])
                        ->where('status', 'pending');
                    break;
            }
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'due_date');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $installments = $query->get();

        $stats = [
            'total_pending' => Installment::pending()->sum('amount'),
            'overdue_count' => Installment::overdue()->count(),
            'overdue_amount' => Installment::overdue()->sum('amount'),
            'due_today_count' => Installment::whereDate('due_date', now())->pending()->count(),
            'upcoming_7_count' => Installment::whereBetween('due_date', [now(), now()->addDays(7)])->pending()->count(),
        ];

        return view('payments.installments', compact('installments', 'stats'));
    }

    /**
     * Ödeme detay
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'customer',
            'policy',
            'installment.paymentPlan',
            'createdBy',
        ]);

        return view('payments.show', compact('payment'));
    }

    /**
     * Ödeme kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'installment_id' => 'required|exists:installments,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,credit_card,bank_transfer,check,pos',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $installment = Installment::findOrFail($validated['installment_id']);
            $paymentPlan = $installment->paymentPlan;

            $payment = Payment::create([
                'customer_id' => $paymentPlan->customer_id,
                'policy_id' => $paymentPlan->policy_id,
                'payment_plan_id' => $paymentPlan->id,
                'installment_id' => $installment->id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'payment_reference' => $validated['payment_reference'] ?? null,
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $installment->markAsPaid($payment->id, $validated['payment_date'], $validated['payment_method']);

            $paymentPlan->updatePaymentStatus();

            DB::commit();

            return redirect()->route('payments.installments')
                ->with('success', 'Ödeme başarıyla kaydedildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment store error', [
                'installment_id' => $validated['installment_id'] ?? null,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            return back()->withInput()
                ->with('error', 'Ödeme kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Ödeme iptal et
     */
    public function cancel(Payment $payment)
    {
        if ($payment->status !== 'completed') {
            return back()->with('error', 'Sadece tamamlanmış ödemeler iptal edilebilir.');
        }

        DB::beginTransaction();
        try {

            $payment->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => auth()->id(),
            ]);

            if ($payment->installment) {
                $payment->installment->update([
                    'status' => 'pending',
                    'paid_date' => null,
                    'payment_id' => null,
                    'payment_method' => null,
                ]);
            }

            if ($payment->paymentPlan) {
                $payment->paymentPlan->updatePaymentStatus();
            }

            DB::commit();

            return back()->with('success', 'Ödeme iptal edildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment cancellation error', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            return back()->with('error', 'Ödeme iptal edilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Ödeme hatırlatıcısı gönder
     */
    public function sendReminder(Installment $installment)
    {
        if ($installment->status !== 'pending') {
            return back()->with('error', 'Sadece bekleyen taksitler için hatırlatıcı gönderilebilir.');
        }

        DB::beginTransaction();
        try {

            $customer = $installment->paymentPlan->customer;
            $policy = $installment->paymentPlan->policy;
            $daysOverdue = now()->diffInDays($installment->due_date, false);

            if ($daysOverdue < 0) {
                $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı poliçenizin ";
                $message .= "{$installment->installment_number}. taksit ödemesi {$installment->due_date->format('d.m.Y')} tarihinde yapılmalıydı. ";
                $message .= "Ödeme tutarı: " . number_format($installment->amount, 2) . " TL. Lütfen en kısa sürede ödeme yapınız.";
            } else {
                $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı poliçenizin ";
                $message .= "{$installment->installment_number}. taksit ödemesinin son günü {$installment->due_date->format('d.m.Y')}. ";
                $message .= "Ödeme tutarı: " . number_format($installment->amount, 2) . " TL.";
            }

            // SMS/Email gönderimi burada yapılacak

            $installment->reminders()->create([
                'customer_id' => $customer->id,
                'reminder_date' => now(),
                'channel' => 'sms',
                'message_content' => $message,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Ödeme hatırlatıcısı gönderildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hatırlatıcı gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Toplu ödeme hatırlatıcısı
     */
    public function bulkSendReminders(Request $request)
    {
        $validated = $request->validate([
            'filter' => 'required|in:overdue,due_today,upcoming_7',
        ]);

        $query = Installment::pending();

        switch ($validated['filter']) {
            case 'overdue':
                $query->where('due_date', '<', now());
                break;
            case 'due_today':
                $query->whereDate('due_date', now());
                break;
            case 'upcoming_7':
                $query->whereBetween('due_date', [now(), now()->addDays(7)]);
                break;
        }

        $installments = $query->get();
        $sentCount = 0;

        DB::beginTransaction();
        try {
            foreach ($installments as $installment) {
                $customer = $installment->paymentPlan->customer;
                $policy = $installment->paymentPlan->policy;
                $daysOverdue = now()->diffInDays($installment->due_date, false);

                if ($daysOverdue < 0) {
                    $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı poliçenizin ";
                    $message .= "{$installment->installment_number}. taksit ödemesi gecikmiştir. ";
                    $message .= "Ödeme tutarı: " . number_format($installment->amount, 2) . " TL. Lütfen en kısa sürede ödeme yapınız.";
                } else {
                    $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı poliçenizin ";
                    $message .= "{$installment->installment_number}. taksit ödemesinin son günü {$installment->due_date->format('d.m.Y')}. ";
                    $message .= "Ödeme tutarı: " . number_format($installment->amount, 2) . " TL.";
                }

                $installment->reminders()->create([
                    'customer_id' => $customer->id,
                    'reminder_date' => now(),
                    'channel' => 'sms',
                    'message_content' => $message,
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);

                $sentCount++;
            }

            DB::commit();

            return back()->with('success', "{$sentCount} adet ödeme hatırlatıcısı gönderildi.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hatırlatıcılar gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }
}
