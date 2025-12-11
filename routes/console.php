<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// YENILEME KAYITLARI OLUŞTUR
Schedule::command('renewals:create')
    ->dailyAt('08:00')
    ->appendOutputTo(storage_path('logs/renewals.log'));

// ÖDEME HATIRLATICILARI GÖNDER
Schedule::command('payments:send-reminders --type=all')
    ->dailyAt('09:00')
    ->appendOutputTo(storage_path('logs/payment-reminders.log'));

// ÖDEME DURUMLARINI GÜNCELLE (Gecikmiş ödemeleri işaretle)
Schedule::call(function () {
    \App\Models\Installment::where('due_date', '<', now())
        ->where('status', 'pending')
        ->update(['status' => 'overdue']);
})->daily();







