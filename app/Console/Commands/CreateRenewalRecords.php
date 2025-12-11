<?php

namespace App\Console\Commands;

use App\Models\Policy;
use App\Models\PolicyRenewal;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CreateRenewalRecords extends Command
{
    protected $signature = 'renewals:create';
    protected $description = 'Yaklaşan poliçeler için otomatik yenileme kayıtları oluştur';

    public function handle()
    {
        $this->info('Yenileme kayıtları oluşturuluyor...');

        // 90 gün içinde bitecek aktif poliçeleri bul
        $policies = Policy::where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(90)])
            ->whereDoesntHave('renewal')
            ->get();

        $created = 0;

        foreach ($policies as $policy) {
            PolicyRenewal::create([
                'policy_id' => $policy->id,
                'customer_id' => $policy->customer_id,
                'renewal_date' => $policy->end_date,
                'status' => 'pending',
                'priority' => $this->calculatePriority($policy->end_date),
            ]);

            $created++;
        }

        $this->info("{$created} adet yenileme kaydı oluşturuldu.");

        // Mevcut kayıtların önceliklerini güncelle
        $this->updatePriorities();

        return 0;
    }

    private function calculatePriority($endDate)
    {
        $daysLeft = now()->diffInDays($endDate, false);

        if ($daysLeft < 0) return 'critical';
        if ($daysLeft <= 7) return 'critical';
        if ($daysLeft <= 30) return 'high';
        if ($daysLeft <= 60) return 'normal';
        return 'low';
    }

    private function updatePriorities()
    {
        $renewals = PolicyRenewal::whereIn('status', ['pending', 'contacted'])->get();

        foreach ($renewals as $renewal) {
            $renewal->updatePriority();
        }

        $this->info('Öncelikler güncellendi.');
    }
}
