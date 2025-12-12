<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InsuranceCompanyController;
use App\Http\Controllers\SettingsController;
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

        // Payments
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/installments', [PaymentController::class, 'installments'])->name('payments.installments');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::post('payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
        Route::post('payments/installments/{installment}/send-reminder', [PaymentController::class, 'sendReminder'])->name('payments.sendReminder');
        Route::post('payments/bulk-send-reminders', [PaymentController::class, 'bulkSendReminders'])->name('payments.bulkSendReminders');

        // Tasks (Görevler)
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
        Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
        Route::post('tasks/{task}/add-comment', [TaskController::class, 'addComment'])->name('tasks.addComment');

        // Customer Policies (AJAX için)
        Route::get('customers/{customer}/policies', function($customerId) {
            $policies = \App\Models\Policy::where('customer_id', $customerId)
                ->where('status', 'active')
                ->get(['id', 'policy_number']);
            return response()->json($policies);
        })->name('customers.policies');

            // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/commission', [ReportController::class, 'commission'])->name('reports.commission');
        Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
        Route::get('reports/renewals', [ReportController::class, 'renewals'])->name('reports.renewals');
        Route::get('reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
        Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');

        // Campaigns
        Route::get('campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
        Route::get('campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
        Route::post('campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
        Route::get('campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
        Route::delete('campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
        Route::post('campaigns/{campaign}/send', [CampaignController::class, 'send'])->name('campaigns.send');
        Route::post('campaigns/{campaign}/test', [CampaignController::class, 'test'])->name('campaigns.test');
        Route::post('campaigns/preview-recipients', [CampaignController::class, 'previewRecipients'])->name('campaigns.previewRecipients');

        // Message Templates
        Route::get('campaigns/templates/list', [CampaignController::class, 'templates'])->name('campaigns.templates');
        Route::post('campaigns/templates', [CampaignController::class, 'storeTemplate'])->name('campaigns.storeTemplate');
        Route::delete('campaigns/templates/{template}', [CampaignController::class, 'destroyTemplate'])->name('campaigns.destroyTemplate');


        // Insurance Companies (Sigorta Şirketleri)
        Route::resource('insurance-companies', InsuranceCompanyController::class);
        Route::post('insurance-companies/{insuranceCompany}/toggle-status', [InsuranceCompanyController::class, 'toggleStatus'])->name('insurance-companies.toggleStatus');

        // Settings (Ayarlar)
        Route::prefix('settings')->group(function () {
            // Genel Ayarlar
            Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
            Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('settings.updateGeneral');

            // Kullanıcı Yönetimi
            Route::get('/users', [SettingsController::class, 'users'])->name('settings.users');
            Route::post('/users', [SettingsController::class, 'storeUser'])->name('settings.storeUser');
            Route::put('/users/{user}', [SettingsController::class, 'updateUser'])->name('settings.updateUser');
            Route::delete('/users/{user}', [SettingsController::class, 'destroyUser'])->name('settings.destroyUser');

            // Profil Ayarları
            Route::get('/profile', [SettingsController::class, 'profile'])->name('settings.profile');
            Route::post('/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
            Route::post('/profile/password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');

            // Güvenlik
            Route::get('/security', [SettingsController::class, 'security'])->name('settings.security');
            Route::post('/security', [SettingsController::class, 'updateSecurity'])->name('settings.updateSecurity');

            // Hızlı İşlemler
            Route::post('/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clearCache');
            Route::post('/backup', [SettingsController::class, 'backup'])->name('settings.backup');
        });

    });
});

Route::get('/quotation/view/{token}', [QuotationController::class, 'view'])->name('quotations.view');
