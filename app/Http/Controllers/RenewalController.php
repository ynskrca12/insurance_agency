<?php

namespace App\Http\Controllers;

use App\Models\PolicyRenewal;
use App\Models\Policy;
use App\Models\RenewalReminder;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RenewalController extends Controller
{
    /**
     * Yenileme listesi
     */
    public function index(Request $request)
    {
        $query = PolicyRenewal::whereHas('policy.customer')->with([
            'newPolicy',
            'policy.customer',
            'policy.insuranceCompany',
            'policy'
        ]);


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('policy', function($q) use ($search) {
                    $q->where('policy_number', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                      });
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'critical': // 7 gün içinde
                    $query->whereBetween('renewal_date', [now(), now()->addDays(7)])
                          ->whereIn('status', ['pending', 'contacted']);
                    break;
                case 'upcoming': // 30 gün içinde
                    $query->whereBetween('renewal_date', [now(), now()->addDays(30)])
                          ->whereIn('status', ['pending', 'contacted']);
                    break;
                case 'overdue': // Gecikmiş
                    $query->where('renewal_date', '<', now())
                          ->whereIn('status', ['pending', 'contacted']);
                    break;
            }
        }

        $query->orderBy('renewal_date', 'asc');
        $renewals = $query->get();

        $stats = [
            'total' => PolicyRenewal::whereHas('policy')->count(),
            'pending' => PolicyRenewal::whereHas('policy')->pending()->count(),
            'contacted' => PolicyRenewal::whereHas('policy')->contacted()->count(),
            'renewed' => PolicyRenewal::whereHas('policy')->renewed()->count(),
            'critical' => PolicyRenewal::whereHas('policy')->critical()->count(),
            'lost' => PolicyRenewal::whereHas('policy')->lost()->count(),

        ];

        return view('renewals.index', compact('renewals', 'stats'));
    }

    /**
     * Yenileme detay
     */
    public function show(PolicyRenewal $renewal)
    {
        $renewal->load([
            'policy.customer',
            'policy.insuranceCompany',
            'newPolicy',
            'reminders',
            'createdBy',
        ]);

        return view('renewals.show', compact('renewal'));
    }

    /**
     * İletişim kaydet
     */
    public function contact(Request $request, PolicyRenewal $renewal)
    {
        $validated = $request->validate([
            'contact_method' => 'required|in:phone,email,sms,whatsapp',
            'contact_notes' => 'required|string|max:1000',
            'next_contact_date' => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            $renewal->update([
                'status' => 'contacted',
                'contacted_at' => now(),
                'contact_notes' => $validated['contact_notes'],
                'next_contact_date' => $validated['next_contact_date'] ?? null,
            ]);

            $renewal->policy->activityLogs()->create([
                'user_id' => auth()->id(),
                'activity_type' => 'renewal_contact',
                'description' => "Yenileme için müşteri ile iletişime geçildi ({$validated['contact_method']})",
                'metadata' => [
                    'contact_method' => $validated['contact_method'],
                    'notes' => $validated['contact_notes'],
                ],
            ]);

            DB::commit();

            return back()->with('success', 'İletişim kaydı eklendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'İletişim kaydı eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Yenileme tamamlandı olarak işaretle
     */
    public function markAsRenewed(Request $request, PolicyRenewal $renewal)
    {
        $validated = $request->validate([
            'new_policy_id' => 'required|exists:policies,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $renewal->update([
                'status' => 'renewed',
                'new_policy_id' => $validated['new_policy_id'],
                'renewed_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            $renewal->policy->update([
                'status' => 'renewed',
            ]);

            Policy::find($validated['new_policy_id'])->update([
                'status' => 'active',
            ]);

            $renewal->policy->activityLogs()->create([
                'user_id' => auth()->id(),
                'activity_type' => 'renewal_completed',
                'description' => 'Poliçe başarıyla yenilendi',
                'metadata' => [
                    'old_policy_id' => $renewal->policy_id,
                    'new_policy_id' => $validated['new_policy_id'],
                ],
            ]);

            DB::commit();

            return redirect()->route('policies.show', $validated['new_policy_id'])
                ->with('success', 'Poliçe başarıyla yenilendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Yenileme işlemi sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kaybedildi olarak işaretle
     */
    public function markAsLost(Request $request, PolicyRenewal $renewal)
    {
        $validated = $request->validate([
            'lost_reason' => 'required|in:price,service,competitor,customer_decision,other',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $renewal->update([
                'status' => 'lost',
                'lost_reason' => $validated['lost_reason'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $renewal->policy->update([
                'status' => 'expired',
            ]);

            // Müşteriyi pasif olarak işaretle (opsiyonel)
            // $renewal->policy->customer->update(['status' => 'passive']);

            $renewal->policy->activityLogs()->create([
                'user_id' => auth()->id(),
                'activity_type' => 'renewal_lost',
                'description' => 'Poliçe yenilemesi kaybedildi',
                'metadata' => [
                    'lost_reason' => $validated['lost_reason'],
                    'notes' => $validated['notes'],
                ],
            ]);

            DB::commit();

            return back()->with('success', 'Yenileme kaybedildi olarak işaretlendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Takvim görünümü
     */
    public function calendar(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $renewals = PolicyRenewal::with(['policy.customer', 'policy.insuranceCompany'])
            ->whereBetween('renewal_date', [$startDate, $endDate])
            ->whereIn('status', ['pending', 'contacted'])
            ->get()
            ->groupBy(function($renewal) {
                return $renewal->renewal_date->format('Y-m-d');
            });

        return view('renewals.calendar', compact('renewals', 'month', 'year', 'startDate', 'endDate'));
    }

    /**
     * Hatırlatıcı gönder
     */
    public function sendReminder(PolicyRenewal $renewal)
    {
        DB::beginTransaction();
        try {
            $messageContent = $this->generateReminderMessage($renewal);

            $daysUntil = $renewal->days_until_renewal;
            $reminderType = $this->determineReminderType($daysUntil);

            // AYNI TÜR HATIRLATICI DAHA ÖNCE GÖNDERİLMİŞ Mİ KONTROL ET
            $existingReminder = RenewalReminder::where('policy_id', $renewal->policy_id)
                ->where('reminder_type', $reminderType)
                ->first();

            if ($existingReminder) {
                // Eğer gönderilmişse uyarı ver
                if ($existingReminder->status === 'sent') {
                    return back()->with('warning', 'Bu poliçe için aynı tür hatırlatıcı daha önce gönderilmiş. Tekrar göndermek için önceki hatırlatıcıyı silin.');
                }

                // Eğer pending veya failed ise güncelle ve tekrar gönder
                $existingReminder->update([
                    'reminder_date' => now(),
                    'status' => 'sent',
                    'sent_at' => now(),
                    'message_content' => $messageContent,
                    'retry_count' => $existingReminder->retry_count + 1,
                ]);

                $reminder = $existingReminder;
            } else {

                $reminder = $renewal->reminders()->create([
                    'policy_id' => $renewal->policy_id,
                    'customer_id' => $renewal->policy->customer_id,
                    'policy_renewal_id' => $renewal->id,
                    'reminder_type' => $reminderType,
                    'reminder_date' => now(),
                    'channel' => 'sms',
                    'status' => 'pending',
                    'message_content' => $messageContent,
                ]);

                // Gerçek SMS/Email gönderimi burada yapılacak

                // Şimdilik hatırlatıcıyı gönderildi olarak işaretle
                $reminder->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            }

            if ($renewal->status === 'pending') {
                $renewal->update(['status' => 'contacted']);
            }

            DB::commit();

            return back()->with('success', 'Hatırlatıcı gönderildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hatırlatıcı gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Hatırlatıcı mesajı oluştur
     */
    private function generateReminderMessage(PolicyRenewal $renewal): string
    {
        $customer = $renewal->policy->customer;
        $policy = $renewal->policy;
        $daysLeft = $renewal->days_until_renewal;

        if ($daysLeft < 0) {
            $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı {$policy->policy_type_label} poliçenizin süresi dolmuştur. ";
            $message .= "Yenileme için lütfen bizimle iletişime geçiniz.";
        } elseif ($daysLeft === 0) {
            $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı {$policy->policy_type_label} poliçenizin süresi bugün doluyor. ";
            $message .= "Acil yenileme gereklidir.";
        } else {
            $message = "Sayın {$customer->name}, {$policy->policy_number} poliçe numaralı {$policy->policy_type_label} poliçenizin ";
            $message .= "süresinin dolmasına {$daysLeft} gün kaldı. Yenileme için bizimle iletişime geçebilirsiniz.";
        }

        return $message;
    }

    /**
     * Hatırlatıcı türünü belirle
     */
    private function determineReminderType(int $daysUntil): string
    {
        if ($daysUntil <= 1) {
            return '1_day';
        } elseif ($daysUntil <= 7) {
            return '7_days';
        } elseif ($daysUntil <= 15) {
            return '15_days';
        } else {
            return '30_days';
        }
    }

    /**
     * Toplu hatırlatıcı gönder
     */
    public function bulkSendReminders(Request $request)
    {
        $validated = $request->validate([
            'filter' => 'required|in:critical,upcoming,all',
        ]);

        $query = PolicyRenewal::whereIn('status', ['pending', 'contacted']);

        switch ($validated['filter']) {
            case 'critical':
                $query->whereBetween('renewal_date', [now(), now()->addDays(7)]);
                break;
            case 'upcoming':
                $query->whereBetween('renewal_date', [now(), now()->addDays(30)]);
                break;
        }

        $renewals = $query->get();
        $sentCount = 0;
        $skippedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($renewals as $renewal) {
                // Mesaj içeriği oluştur
                $messageContent = $this->generateReminderMessage($renewal);
                $reminderType = $this->determineReminderType($renewal->days_until_renewal);

                // AYNI TÜR HATIRLATICI DAHA ÖNCE GÖNDERİLMİŞ Mİ KONTROL ET
                $existingReminder = RenewalReminder::where('policy_id', $renewal->policy_id)
                    ->where('reminder_type', $reminderType)
                    ->first();

                if ($existingReminder) {
                    // Eğer gönderilmişse atla
                    if ($existingReminder->status === 'sent') {
                        $skippedCount++;
                        continue;
                    }

                    // Eğer pending veya failed ise güncelle ve tekrar gönder
                    $existingReminder->update([
                        'reminder_date' => now(),
                        'status' => 'sent',
                        'sent_at' => now(),
                        'message_content' => $messageContent,
                        'retry_count' => $existingReminder->retry_count + 1,
                    ]);

                    $sentCount++;
                } else {

                    $reminder = $renewal->reminders()->create([
                        'policy_id' => $renewal->policy_id,
                        'customer_id' => $renewal->policy->customer_id,
                        'policy_renewal_id' => $renewal->id,
                        'reminder_type' => $reminderType,
                        'reminder_date' => now(),
                        'channel' => 'sms',
                        'status' => 'sent',
                        'sent_at' => now(),
                        'message_content' => $messageContent,
                    ]);

                    $sentCount++;
                }

                if ($renewal->status === 'pending') {
                    $renewal->update(['status' => 'contacted']);
                }
            }

            DB::commit();

            $message = "{$sentCount} adet hatırlatıcı gönderildi.";
            if ($skippedCount > 0) {
                $message .= " {$skippedCount} adet zaten gönderilmiş hatırlatıcı atlandı.";
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hatırlatıcılar gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard widget verileri
     */
    public function getDashboardData()
    {
        return [
            'critical_renewals' => PolicyRenewal::critical()->count(),
            'upcoming_renewals' => PolicyRenewal::upcoming()->count(),
            'todays_renewals' => PolicyRenewal::today()->count(),
            'success_rate' => $this->calculateSuccessRate(),
        ];
    }

    /**
     * Başarı oranını hesapla
     */
    private function calculateSuccessRate()
    {
        $total = PolicyRenewal::whereIn('status', ['renewed', 'lost'])->count();
        $renewed = PolicyRenewal::renewed()->count();

        return $total > 0 ? round(($renewed / $total) * 100, 1) : 0;
    }
}
