<?php

namespace Database\Seeders;

use App\Models\Policy;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\User;
use App\Models\PolicyRenewal;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id;
        $customers = Customer::all();
        $companies = InsuranceCompany::all();

        $policies = [
            // Ahmet Yılmaz - 3 Poliçe
            [
                'customer_id' => 1,
                'insurance_company_id' => 1,
                'policy_number' => 'KSK-2024-001',
                'policy_type' => 'kasko',
                'vehicle_plate' => '34 ABC 123',
                'vehicle_brand' => 'Toyota',
                'vehicle_model' => 'Corolla',
                'vehicle_year' => 2023,
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(9),
                'premium_amount' => 8000.00,
                'commission_rate' => 15.00,
                'commission_amount' => 1200.00,
                'payment_type' => 'installment',
                'installment_count' => 6,
                'status' => 'active',
                'created_by' => $userId,
            ],
            [
                'customer_id' => 1,
                'insurance_company_id' => 2,
                'policy_number' => 'KNT-2024-001',
                'policy_type' => 'konut',
                'property_address' => 'Atatürk Caddesi No:123, Kadıköy, İstanbul',
                'property_area' => 120,
                'property_floor' => 5,
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(10),
                'premium_amount' => 5000.00,
                'commission_rate' => 18.00,
                'commission_amount' => 900.00,
                'payment_type' => 'cash',
                'installment_count' => 1,
                'status' => 'active',
                'created_by' => $userId,
            ],
            [
                'customer_id' => 1,
                'insurance_company_id' => 3,
                'policy_number' => 'TRF-2024-001',
                'policy_type' => 'trafik',
                'vehicle_plate' => '34 ABC 123',
                'vehicle_brand' => 'Toyota',
                'vehicle_model' => 'Corolla',
                'vehicle_year' => 2023,
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(9),
                'premium_amount' => 2000.00,
                'commission_rate' => 20.00,
                'commission_amount' => 400.00,
                'payment_type' => 'cash',
                'installment_count' => 1,
                'status' => 'active',
                'created_by' => $userId,
            ],

            // Ayşe Demir - 2 Poliçe
            [
                'customer_id' => 2,
                'insurance_company_id' => 2,
                'policy_number' => 'KSK-2024-002',
                'policy_type' => 'kasko',
                'vehicle_plate' => '34 DEF 456',
                'vehicle_brand' => 'BMW',
                'vehicle_model' => '320i',
                'vehicle_year' => 2024,
                'start_date' => Carbon::now()->subMonths(1),
                'end_date' => Carbon::now()->addMonths(11),
                'premium_amount' => 12000.00,
                'commission_rate' => 16.00,
                'commission_amount' => 1920.00,
                'payment_type' => 'installment',
                'installment_count' => 12,
                'status' => 'active',
                'created_by' => $userId,
            ],
            [
                'customer_id' => 2,
                'insurance_company_id' => 1,
                'policy_number' => 'SGL-2024-001',
                'policy_type' => 'saglik',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->addMonths(6),
                'premium_amount' => 6000.00,
                'commission_rate' => 12.00,
                'commission_amount' => 720.00,
                'payment_type' => 'installment',
                'installment_count' => 12,
                'status' => 'active',
                'created_by' => $userId,
            ],

            // Mehmet Kaya - 1 Poliçe (Yakında bitecek)
            [
                'customer_id' => 3,
                'insurance_company_id' => 3,
                'policy_number' => 'KSK-2024-003',
                'policy_type' => 'kasko',
                'vehicle_plate' => '06 GHI 789',
                'vehicle_brand' => 'Renault',
                'vehicle_model' => 'Megane',
                'vehicle_year' => 2022,
                'start_date' => Carbon::now()->subMonths(11),
                'end_date' => Carbon::now()->addDays(20), // 20 gün sonra bitecek
                'premium_amount' => 5000.00,
                'commission_rate' => 14.50,
                'commission_amount' => 725.00,
                'payment_type' => 'installment',
                'installment_count' => 6,
                'status' => 'expiring_soon',
                'created_by' => $userId,
            ],

            // Ali Öztürk - 2 Poliçe
            [
                'customer_id' => 5,
                'insurance_company_id' => 4,
                'policy_number' => 'KNT-2024-002',
                'policy_type' => 'konut',
                'property_address' => 'Bağdat Caddesi No:250, Üsküdar, İstanbul',
                'property_area' => 150,
                'property_floor' => 3,
                'start_date' => Carbon::now()->subMonths(4),
                'end_date' => Carbon::now()->addMonths(8),
                'premium_amount' => 6000.00,
                'commission_rate' => 18.50,
                'commission_amount' => 1110.00,
                'payment_type' => 'cash',
                'installment_count' => 1,
                'status' => 'active',
                'created_by' => $userId,
            ],
            [
                'customer_id' => 5,
                'insurance_company_id' => 5,
                'policy_number' => 'DASK-2024-001',
                'policy_type' => 'dask',
                'property_address' => 'Bağdat Caddesi No:250, Üsküdar, İstanbul',
                'property_area' => 150,
                'property_floor' => 3,
                'start_date' => Carbon::now()->subMonths(4),
                'end_date' => Carbon::now()->addMonths(8),
                'premium_amount' => 2000.00,
                'commission_rate' => 23.00,
                'commission_amount' => 460.00,
                'payment_type' => 'cash',
                'installment_count' => 1,
                'status' => 'active',
                'created_by' => $userId,
            ],

            // Can Aydın - 1 Poliçe (Kritik - 5 gün kaldı)
            [
                'customer_id' => 7,
                'insurance_company_id' => 1,
                'policy_number' => 'TRF-2024-002',
                'policy_type' => 'trafik',
                'vehicle_plate' => '07 JKL 012',
                'vehicle_brand' => 'Volkswagen',
                'vehicle_model' => 'Passat',
                'vehicle_year' => 2021,
                'start_date' => Carbon::now()->subMonths(12),
                'end_date' => Carbon::now()->addDays(5), // 5 gün sonra bitecek
                'premium_amount' => 1800.00,
                'commission_rate' => 20.00,
                'commission_amount' => 360.00,
                'payment_type' => 'cash',
                'installment_count' => 1,
                'status' => 'critical',
                'created_by' => $userId,
            ],

            // Burak Çelik - 1 Poliçe
            [
                'customer_id' => 9,
                'insurance_company_id' => 2,
                'policy_number' => 'KSK-2024-004',
                'policy_type' => 'kasko',
                'vehicle_plate' => '34 MNO 345',
                'vehicle_brand' => 'Honda',
                'vehicle_model' => 'Civic',
                'vehicle_year' => 2023,
                'start_date' => Carbon::now()->subMonths(5),
                'end_date' => Carbon::now()->addMonths(7),
                'premium_amount' => 4500.00,
                'commission_rate' => 15.00,
                'commission_amount' => 675.00,
                'payment_type' => 'installment',
                'installment_count' => 6,
                'status' => 'active',
                'created_by' => $userId,
            ],
        ];

        foreach ($policies as $policy) {
            Policy::create($policy);
        }

        foreach (Policy::all() as $policy) {
            // Sadece aktif ve süresi yaklaşan poliçeler için
            if ($policy->status === 'active' || $policy->status === 'expiring_soon' || $policy->status === 'critical') {
                PolicyRenewal::create([
                    'policy_id' => $policy->id,
                    'customer_id' => $policy->customer_id,
                    'renewal_date' => $policy->end_date,
                    'status' => 'pending',
                    'priority' => $policy->days_until_expiry <= 7 ? 'critical' : ($policy->days_until_expiry <= 30 ? 'high' : 'normal'),
                    'created_by' => $userId,
                ]);
            }
        }
    }
}
