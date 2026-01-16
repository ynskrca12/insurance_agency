<?php
namespace App\Console\Commands;

use App\Models\Policy;
use App\Models\PolicyRenewal;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CreateRenewalRecords extends Command
{
    protected $signature = 'renewals:create';
    protected $description = 'Yaklaşan ve süresi dolmuş poliçeler için otomatik yenileme kayıtları oluştur';

    public function handle()
    {
        $this->info('Yenileme kayıtları oluşturuluyor...');

        // 90 gün içinde bitecek + süresi dolmuş aktif poliçeleri bul
        $policies = Policy::where('status', 'active')
            ->where('end_date', '>=', now()->subDays(90)) // Son 90 gün içinde dolmuş
            ->where('end_date', '<=', now()->addDays(90)) // Veya 90 gün içinde dolacak
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

        $this->updatePriorities();

        return 0;
    }

    private function calculatePriority($endDate)
    {
        $daysLeft = now()->diffInDays($endDate, false);

        if ($daysLeft < 0) {
            $daysOverdue = abs($daysLeft);
            if ($daysOverdue <= 7) return 'critical'; // Yeni dolmuş
            if ($daysOverdue <= 15) return 'high'; // 2 hafta içinde dolmuş
            return 'normal'; // Daha eski
        }

        // Pozitif değerler = poliçe henüz dolmamış
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
