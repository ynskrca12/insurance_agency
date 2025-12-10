<?php

namespace Database\Seeders;

use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;

class InsuranceCompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Anadolu Sigorta',
                'code' => 'ANA',
                'phone' => '0850 724 0 724',
                'email' => 'info@anadolusigorta.com.tr',
                'website' => 'https://www.anadolusigorta.com.tr',
                'default_commission_kasko' => 15.00,
                'default_commission_trafik' => 20.00,
                'default_commission_konut' => 18.00,
                'default_commission_dask' => 25.00,
                'default_commission_saglik' => 12.00,
                'default_commission_hayat' => 10.00,
                'default_commission_tss' => 15.00,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Allianz Sigorta',
                'code' => 'ALC',
                'phone' => '0850 222 00 00',
                'email' => 'info@allianz.com.tr',
                'website' => 'https://www.allianz.com.tr',
                'default_commission_kasko' => 16.00,
                'default_commission_trafik' => 22.00,
                'default_commission_konut' => 19.00,
                'default_commission_dask' => 26.00,
                'default_commission_saglik' => 13.00,
                'default_commission_hayat' => 11.00,
                'default_commission_tss' => 16.00,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Aksigorta',
                'code' => 'AXA',
                'phone' => '0850 210 00 10',
                'email' => 'info@aksigorta.com.tr',
                'website' => 'https://www.aksigorta.com.tr',
                'default_commission_kasko' => 14.50,
                'default_commission_trafik' => 21.00,
                'default_commission_konut' => 17.50,
                'default_commission_dask' => 24.00,
                'default_commission_saglik' => 11.50,
                'default_commission_hayat' => 9.50,
                'default_commission_tss' => 14.50,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'HDI Sigorta',
                'code' => 'HDI',
                'phone' => '0850 220 00 44',
                'email' => 'info@hdi.com.tr',
                'website' => 'https://www.hdi.com.tr',
                'default_commission_kasko' => 15.50,
                'default_commission_trafik' => 20.50,
                'default_commission_konut' => 18.50,
                'default_commission_dask' => 25.50,
                'default_commission_saglik' => 12.50,
                'default_commission_hayat' => 10.50,
                'default_commission_tss' => 15.50,
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'name' => 'Sompo Sigorta',
                'code' => 'SMP',
                'phone' => '0850 724 00 00',
                'email' => 'info@somposigorta.com',
                'website' => 'https://www.somposigorta.com',
                'default_commission_kasko' => 14.00,
                'default_commission_trafik' => 19.00,
                'default_commission_konut' => 17.00,
                'default_commission_dask' => 23.00,
                'default_commission_saglik' => 11.00,
                'default_commission_hayat' => 9.00,
                'default_commission_tss' => 14.00,
                'is_active' => true,
                'display_order' => 5,
            ],
        ];

        foreach ($companies as $company) {
            InsuranceCompany::create($company);
        }
    }
}
