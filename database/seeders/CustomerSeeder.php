<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id;

        $customers = [
            [
                'name' => 'Ahmet Yılmaz',
                'phone' => '05321234567',
                'phone_secondary' => '05421234567',
                'email' => 'ahmet@example.com',
                'id_number' => '12345678901',
                'birth_date' => '1985-05-15',
                'address' => 'Atatürk Caddesi No:123',
                'city' => 'İstanbul',
                'district' => 'Kadıköy',
                'postal_code' => '34710',
                'occupation' => 'Yazılım Geliştirici',
                'workplace' => 'ABC Teknoloji',
                'status' => 'active',
                'segments' => ['VIP'],
                'total_policies' => 3,
                'total_premium' => 15000.00,
                'lifetime_value' => 2250.00,
                'risk_score' => 25,
                'created_by' => $userId,
            ],
            [
                'name' => 'Ayşe Demir',
                'phone' => '05331234567',
                'email' => 'ayse@example.com',
                'id_number' => '23456789012',
                'birth_date' => '1990-08-22',
                'address' => 'İstiklal Sokak No:45',
                'city' => 'İstanbul',
                'district' => 'Beşiktaş',
                'occupation' => 'Doktor',
                'workplace' => 'Memorial Hastanesi',
                'status' => 'active',
                'segments' => ['VIP'],
                'total_policies' => 2,
                'total_premium' => 10000.00,
                'lifetime_value' => 1500.00,
                'risk_score' => 15,
                'created_by' => $userId,
            ],
            [
                'name' => 'Mehmet Kaya',
                'phone' => '05341234567',
                'email' => 'mehmet@example.com',
                'birth_date' => '1988-12-10',
                'city' => 'Ankara',
                'district' => 'Çankaya',
                'occupation' => 'Mühendis',
                'status' => 'active',
                'total_policies' => 1,
                'total_premium' => 5000.00,
                'lifetime_value' => 750.00,
                'risk_score' => 30,
                'created_by' => $userId,
            ],
            [
                'name' => 'Fatma Şahin',
                'phone' => '05351234567',
                'email' => 'fatma@example.com',
                'birth_date' => '1992-03-18',
                'city' => 'İzmir',
                'district' => 'Karşıyaka',
                'status' => 'potential',
                'total_policies' => 0,
                'risk_score' => 50,
                'created_by' => $userId,
            ],
            [
                'name' => 'Ali Öztürk',
                'phone' => '05361234567',
                'email' => 'ali@example.com',
                'birth_date' => '1987-07-25',
                'city' => 'İstanbul',
                'district' => 'Üsküdar',
                'occupation' => 'Avukat',
                'status' => 'active',
                'total_policies' => 2,
                'total_premium' => 8000.00,
                'lifetime_value' => 1200.00,
                'risk_score' => 20,
                'created_by' => $userId,
            ],
            [
                'name' => 'Zeynep Arslan',
                'phone' => '05371234567',
                'city' => 'Ankara',
                'status' => 'potential',
                'total_policies' => 0,
                'risk_score' => 45,
                'created_by' => $userId,
            ],
            [
                'name' => 'Can Aydın',
                'phone' => '05381234567',
                'email' => 'can@example.com',
                'city' => 'Antalya',
                'district' => 'Muratpaşa',
                'status' => 'active',
                'total_policies' => 1,
                'total_premium' => 6000.00,
                'lifetime_value' => 900.00,
                'risk_score' => 35,
                'created_by' => $userId,
            ],
            [
                'name' => 'Elif Yıldız',
                'phone' => '05391234567',
                'city' => 'Bursa',
                'status' => 'passive',
                'total_policies' => 0,
                'risk_score' => 60,
                'created_by' => $userId,
            ],
            [
                'name' => 'Burak Çelik',
                'phone' => '05401234567',
                'email' => 'burak@example.com',
                'birth_date' => '1991-11-30',
                'city' => 'İstanbul',
                'district' => 'Şişli',
                'occupation' => 'Eczacı',
                'status' => 'active',
                'segments' => ['Potential'],
                'total_policies' => 1,
                'total_premium' => 4500.00,
                'lifetime_value' => 675.00,
                'risk_score' => 28,
                'created_by' => $userId,
            ],
            [
                'name' => 'Selin Korkmaz',
                'phone' => '05411234567',
                'city' => 'İzmir',
                'district' => 'Bornova',
                'status' => 'potential',
                'total_policies' => 0,
                'risk_score' => 55,
                'created_by' => $userId,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
