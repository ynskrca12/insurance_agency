<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RenewalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Web Sitesi - Gelecekte eklenecek)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome'); // Geçici welcome sayfası
});

/*
|--------------------------------------------------------------------------
| Panel Auth Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::prefix('panel')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);

        Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::post('/logout', [LogoutController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('customers', CustomerController::class);

        Route::resource('policies', PolicyController::class);

            // Quotations (Teklifler)
        Route::resource('quotations', QuotationController::class);
        Route::post('quotations/{quotation}/send', [QuotationController::class, 'send'])->name('quotations.send');
        Route::post('quotations/{quotation}/convert', [QuotationController::class, 'convert'])->name('quotations.convert');

        Route::get('renewals', [RenewalController::class, 'index'])->name('renewals.index');
        Route::get('renewals/calendar', [RenewalController::class, 'calendar'])->name('renewals.calendar');
        Route::get('renewals/{renewal}', [RenewalController::class, 'show'])->name('renewals.show');
        Route::post('renewals/{renewal}/contact', [RenewalController::class, 'contact'])->name('renewals.contact');
        Route::post('renewals/{renewal}/mark-renewed', [RenewalController::class, 'markAsRenewed'])->name('renewals.markAsRenewed');
        Route::post('renewals/{renewal}/mark-lost', [RenewalController::class, 'markAsLost'])->name('renewals.markAsLost');
        Route::post('renewals/{renewal}/send-reminder', [RenewalController::class, 'sendReminder'])->name('renewals.sendReminder');
        Route::post('renewals/bulk-send-reminders', [RenewalController::class, 'bulkSendReminders'])->name('renewals.bulkSendReminders');


    });
});

Route::get('/quotation/view/{token}', [QuotationController::class, 'view'])->name('quotations.view');
