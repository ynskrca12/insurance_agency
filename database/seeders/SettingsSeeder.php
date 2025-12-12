<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Şirket Bilgileri
            ['key' => 'company_name', 'value' => 'Sigorta Acentesi', 'type' => 'string'],
            ['key' => 'company_phone', 'value' => '0555 123 45 67', 'type' => 'string'],
            ['key' => 'company_email', 'value' => 'info@example.com', 'type' => 'string'],
            ['key' => 'company_address', 'value' => 'İstanbul, Türkiye', 'type' => 'string'],
            ['key' => 'company_tax_office', 'value' => 'Kadıköy', 'type' => 'string'],
            ['key' => 'company_tax_number', 'value' => '1234567890', 'type' => 'string'],

            // Sistem Ayarları
            ['key' => 'timezone', 'value' => 'Europe/Istanbul', 'type' => 'string'],
            ['key' => 'date_format', 'value' => 'd.m.Y', 'type' => 'string'],
            ['key' => 'currency', 'value' => 'TRY', 'type' => 'string'],

            // Güvenlik Ayarları
            ['key' => 'session_timeout', 'value' => '120', 'type' => 'integer'],
            ['key' => 'password_expiry_days', 'value' => '90', 'type' => 'integer'],
            ['key' => 'max_login_attempts', 'value' => '5', 'type' => 'integer'],
            ['key' => 'two_factor_enabled', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'force_password_change', 'value' => '0', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
