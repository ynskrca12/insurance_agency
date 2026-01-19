<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CariHesap;
use App\Models\User;

class CariHesapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tüm tenant'lar için (veya sadece belirli bir tenant için çalıştırılabilir)
        // $tenants = User::whereHas('tenant')->get();
        $tenantId= 1;

        // foreach ($tenants as $tenant) {
            // Varsayılan Kasa Hesabı
            CariHesap::firstOrCreate(
                [
                    'tenant_id' => $tenantId,
                    'tip' => 'kasa',
                    'kod' => 'KAS-0001',
                ],
                [
                    'ad' => 'Ana Kasa',
                    'aciklama' => 'Nakit tahsilatlar için ana kasa hesabı',
                    'bakiye' => 0,
                    'aktif' => true,
                ]
            );

            // Varsayılan Banka Hesabı
            CariHesap::firstOrCreate(
                [
                    'tenant_id' => $tenantId,
                    'tip' => 'banka',
                    'kod' => 'BNK-0001',
                ],
                [
                    'ad' => 'Ana Banka Hesabı',
                    'aciklama' => 'Banka havalesi ve kredi kartı tahsilatları için',
                    'bakiye' => 0,
                    'aktif' => true,
                ]
            );

            // İkinci Banka Hesabı (opsiyonel)
            CariHesap::firstOrCreate(
                [
                    'tenant_id' => $tenantId,
                    'tip' => 'banka',
                    'kod' => 'BNK-0002',
                ],
                [
                    'ad' => 'Şirket Ödemeleri Hesabı',
                    'aciklama' => 'Sigorta şirketlerine ödemeler için',
                    'bakiye' => 0,
                    'aktif' => true,
                ]
            );

            // POS Hesabı
            CariHesap::firstOrCreate(
                [
                    'tenant_id' => $tenantId,
                    'tip' => 'banka',
                    'kod' => 'BNK-0003',
                ],
                [
                    'ad' => 'Sanal POS Hesabı',
                    'aciklama' => 'Online kredi kartı tahsilatları',
                    'bakiye' => 0,
                    'aktif' => true,
                ]
            );
        // }

        $this->command->info('Kasa ve Banka hesapları oluşturuldu!');
    }
}
