<?php

namespace App\Console\Commands;

use App\Models\Installment;
use App\Models\PaymentReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    protected $signature = 'payments:send-reminders {--type=all}';
    protected $description = 'Otomatik ödeme hatırlatıcıları gönder';

    public function handle()
    {
        $type = $this->option('type');

        $this->info('Ödeme hatırlatıcıları gönderiliyor...');

        $sentCount = 0;

        // Gecikmiş ödemeler
        if ($type === 'all' || $type === 'overdue') {
            $sentCount += $this->sendOverdueReminders();
        }

        // Bugün vadesi dolanlar
        if ($type === 'all' || $type === 'due_today') {
            $sentCount += $this->sendDueTodayReminders();
        }

        // 3 gün içinde vadesi dolanlar
        if ($type === 'all' || $type === 'upcoming') {
            $sentCount += $this->sendUpcomingReminders();
        }

        $this->info("{$sentCount} adet hatırlatıcı gönderildi.");

        return 0;
    }

    private function sendOverdueReminders()
    {
        $installments = Installment::overdue()
            ->with(['paymentPlan.customer', 'paymentPlan.policy'])
            ->get();

        $count = 0;

        foreach ($installments as $installment) {
            // Son 7 günde hatırlatıcı gönderilmiş mi kontrol et
            $recentReminder = $installment->reminders()
                ->where('created_at', '>=', now()->subDays(7))
                ->exists();

            if ($recentReminder) {
                continue;
            }

            $this->sendReminder($installment, 'overdue');
            $count++;
        }

        return $count;
    }

    private function sendDueTodayReminders()
    {
        $installments = Installment::dueToday()
            ->with(['paymentPlan.customer', 'paymentPlan.policy'])
            ->get();

        $count = 0;

        foreach ($installments as $installment) {
            // Bugün hatırlatıcı gönderilmiş mi kontrol et
            $todayReminder = $installment->reminders()
                ->whereDate('created_at', now())
                ->exists();

            if ($todayReminder) {
                continue;
            }

            $this->sendReminder($installment, 'due_today');
            $count++;
        }

        return $count;
    }

    private function sendUpcomingReminders()
    {
        $installments = Installment::whereBetween('due_date', [now()->addDays(1), now()->addDays(3)])
            ->where('status', 'pending')
            ->with(['paymentPlan.customer', 'paymentPlan.policy'])
            ->get();

        $count = 0;

        foreach ($installments as $installment) {
            // Son 3 günde hatırlatıcı gönderilmiş mi kontrol et
            $recentReminder = $installment->reminders()
                ->where('created_at', '>=', now()->subDays(3))
                ->exists();

            if ($recentReminder) {
                continue;
            }

            $this->sendReminder($installment, 'upcoming');
            $count++;
        }

        return $count;
    }

    private function sendReminder($installment, $type)
    {
        DB::beginTransaction();
        try {
            $customer = $installment->paymentPlan->customer;
            $policy = $installment->paymentPlan->policy;

            $message = $this->generateMessage($installment, $type);

            // Gerçek SMS/Email gönderimi burada yapılacak

            PaymentReminder::create([
                'customer_id' => $customer->id,
                'installment_id' => $installment->id,
                'reminder_date' => now(),
                'channel' => 'sms',
                'message_content' => $message,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            DB::commit();

            $this->line("✓ Hatırlatıcı gönderildi: {$customer->name} - {$policy->policy_number}");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("✗ Hata: {$e->getMessage()}");
        }
    }

    private function generateMessage($installment, $type)
    {
        $customer = $installment->paymentPlan->customer;
        $policy = $installment->paymentPlan->policy;
        $amount = number_format($installment->amount, 2);
        $dueDate = $installment->due_date->format('d.m.Y');

        switch ($type) {
            case 'overdue':
                $daysOverdue = now()->diffInDays($installment->due_date);
                return "Sayın {$customer->name}, {$policy->policy_number} poliçenizin {$installment->installment_number}. taksit ödemesi ({$amount} TL) {$daysOverdue} gün gecikmiştir. Lütfen en kısa sürede ödeme yapınız.";

            case 'due_today':
                return "Sayın {$customer->name}, {$policy->policy_number} poliçenizin {$installment->installment_number}. taksit ödemesinin ({$amount} TL) son ödeme günü bugündür. Lütfen ödemenizi gerçekleştiriniz.";

            case 'upcoming':
                return "Sayın {$customer->name}, {$policy->policy_number} poliçenizin {$installment->installment_number}. taksit ödemesi ({$amount} TL) {$dueDate} tarihinde ödenmelidir.";

            default:
                return "Ödeme hatırlatması: {$amount} TL - Vade: {$dueDate}";
        }
    }
}
