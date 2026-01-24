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
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\DemoController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DemoUserController;
use App\Http\Controllers\Web\BlogController as WebBlogController;
use App\Http\Controllers\CariHesapController;
use App\Http\Controllers\TahsilatController;
use App\Http\Controllers\SirketOdemeController;

// Admin Auth Routes (Guest only)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Panel Routes (Admin only)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Blog Routes
    Route::resource('blogs', BlogController::class);
    Route::delete('/blogs/{blog}/delete-image', [BlogController::class, 'deleteImage'])->name('blogs.delete-image');

    // Demo Users Routes
    Route::resource('demo-users', DemoUserController::class)->only(['index', 'show', 'destroy']);
    Route::put('/demo-users/{demoUser}/update-trial', [DemoUserController::class, 'updateTrial'])->name('demo-users.update-trial');
    Route::post('/demo-users/{demoUser}/deactivate', [DemoUserController::class, 'deactivate'])->name('demo-users.deactivate');
    Route::post('/demo-users/{demoUser}/activate', [DemoUserController::class, 'activate'])->name('demo-users.activate');

    // Contact Messages routes (henüz oluşturulmadı)
    Route::get('/contact-messages', function() { return 'Contact Messages'; })->name('contact-messages.index');

    // Settings routes (henüz oluşturulmadı)
    Route::get('/settings', function() { return 'Settings'; })->name('settings');
    Route::get('/activity-log', function() { return 'Activity Log'; })->name('activity-log');
});

// Route::get('/mail-config', function () {
//     return [
//         'MAIL_MAILER' => config('mail.default'),
//         'MAIL_HOST' => config('mail.mailers.smtp.host'),
//         'MAIL_PORT' => config('mail.mailers.smtp.port'),
//         'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
//         'MAIL_FROM' => config('mail.from'),
//     ];
// });

Route::get('/optimize', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return 'Tüm cache temizlendi!';
});


Route::get('/test-mail-verbose', function () {
    try {
        // 1. Config göster
        echo "=== CONFIG ===<br>";
        echo "Driver: " . config('mail.default') . "<br>";
        echo "Host: " . config('mail.mailers.smtp.host') . "<br>";
        echo "Port: " . config('mail.mailers.smtp.port') . "<br>";
        echo "Username: " . config('mail.mailers.smtp.username') . "<br>";
        echo "Encryption: " . config('mail.mailers.smtp.encryption') . "<br><br>";

        // 2. Mail gönder
        echo "=== MAIL GÖNDERİLİYOR ===<br>";

        Mail::raw('TEST MAIL - ' . now(), function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Mail ' . now()->format('H:i:s'));
        });

        echo "Mail gönderildi!<br><br>";

        // 3. Log'a yaz
        Log::info('Test mail gönderildi', ['time' => now()]);
        echo "Log'a yazıldı!<br><br>";

        echo "=== MAILTRAP KONTROL ===<br>";
        echo "https://mailtrap.io/inboxes adresini kontrol et!";

    } catch (\Exception $e) {
        echo "HATA: " . $e->getMessage() . "<br>";
        echo "Dosya: " . $e->getFile() . "<br>";
        echo "Satır: " . $e->getLine();
    }
});

/*
|--------------------------------------------------------------------------
| PUBLIC WEB SİTESİ ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hakkimizda', [PageController::class, 'about'])->name('about');
Route::get('/moduller', [PageController::class, 'modules'])->name('modules');
Route::get('/paketler', [PageController::class, 'pricing'])->name('pricing');
Route::get('/crm-nedir', [PageController::class, 'whatIsCrm'])->name('what-is-crm');
Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [PageController::class, 'sendContact'])->name('contact.send');

// Modül Detay Sayfaları
Route::prefix('moduller')->name('modules.')->group(function () {
    Route::get('/musteriler', [PageController::class, 'moduleCustomers'])->name('customers');
    Route::get('/policeler', [PageController::class, 'modulePolicies'])->name('policies');
    Route::get('/teklifler', [PageController::class, 'moduleQuotations'])->name('quotations');
    Route::get('/yenilemeler', [PageController::class, 'moduleRenewals'])->name('renewals');
    Route::get('/odemeler', [PageController::class, 'modulePayments'])->name('payments');
    Route::get('/gorevler', [PageController::class, 'moduleTasks'])->name('tasks');
    Route::get('/kampanyalar', [PageController::class, 'moduleCampaigns'])->name('campaigns');
    Route::get('/raporlar', [PageController::class, 'moduleReports'])->name('reports');
});

// Demo Kayıt
Route::get('/demo', [DemoController::class, 'showForm'])->name('demo.form');
Route::post('/demo', [DemoController::class, 'register'])->name('demo.register');
Route::get('/demo/expired', [DemoController::class, 'expired'])
    ->middleware('auth')
    ->name('demo.expired');

    Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [WebBlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [WebBlogController::class, 'show'])->name('show');
});
/*
|--------------------------------------------------------------------------
| Panel Auth Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::prefix('panel')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');

        Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::post('/logout', [LogoutController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware('auth', 'check.demo.expiry')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('customers', CustomerController::class);
        Route::post('/{customer}/notes', [CustomerController::class, 'addNote'])->name('customers.addNote');

        Route::post('customers/{customer}/documents', [CustomerController::class, 'storeDocument'])->name('customers.documents.store');
        Route::delete('customers/{customer}/documents/{document}', [CustomerController::class, 'destroyDocument'])->name('customers.documents.destroy');

        Route::resource('policies', PolicyController::class);

        // Quotations (Teklifler)
        Route::resource('quotations', QuotationController::class);
        Route::post('quotations/{quotation}/send', [QuotationController::class, 'send'])->name('quotations.send');
        Route::post('quotations/{quotation}/convert', [QuotationController::class, 'convert'])->name('quotations.convert');

        // Renewals (Yenilemeler)
        Route::get('renewals', [RenewalController::class, 'index'])->name('renewals.index');
        Route::get('calendar', [RenewalController::class, 'calendar'])->name('calendar.index');
        Route::get('renewals/{renewal}', [RenewalController::class, 'show'])->name('renewals.show');
        Route::post('renewals/{renewal}/contact', [RenewalController::class, 'contact'])->name('renewals.contact');
        Route::post('renewals/{renewal}/mark-renewed', [RenewalController::class, 'markAsRenewed'])->name('renewals.markAsRenewed');
        Route::post('renewals/{renewal}/mark-lost', [RenewalController::class, 'markAsLost'])->name('renewals.markAsLost');
        Route::post('renewals/{renewal}/send-reminder', [RenewalController::class, 'sendReminder'])->name('renewals.sendReminder');
        Route::post('renewals/bulk-send-reminders', [RenewalController::class, 'bulkSendReminders'])->name('renewals.bulkSendReminders');

        // Manuel Tetikleme
        Route::get('/generate', [RenewalController::class, 'generateRenewalRecords'])
            ->name('renewals.generate');

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

            // Cari Hesaplar
        Route::prefix('cari-hesaplar')->name('cari-hesaplar.')->group(function () {
            Route::get('/', [CariHesapController::class, 'index'])->name('index');
            Route::get('/create', [CariHesapController::class, 'create'])->name('create');
            Route::post('/', [CariHesapController::class, 'store'])->name('store');
            Route::get('/{cariHesap}', [CariHesapController::class, 'show'])->name('show');
            Route::post('/{cariHesap}/hareket', [CariHesapController::class, 'addHareket'])->name('add-hareket');
            Route::post('/{cariHesap}/recalculate', [CariHesapController::class, 'recalculateBalance'])->name('recalculate');

            // Raporlar
            Route::get('/raporlar/yasilandirma', [CariHesapController::class, 'yasilandirma'])->name('yasilandirma');
            Route::get('/raporlar/kasa-banka', [CariHesapController::class, 'kasaBanka'])->name('kasa-banka');
        });

        // Tahsilatlar
        Route::prefix('tahsilatlar')->name('tahsilatlar.')->group(function () {
            Route::get('/', [TahsilatController::class, 'index'])->name('index');
            Route::get('/create', [TahsilatController::class, 'create'])->name('create');
            Route::post('/', [TahsilatController::class, 'store'])->name('store');
            Route::get('/{tahsilat}', [TahsilatController::class, 'show'])->name('show');
            Route::get('/{tahsilat}/edit', [TahsilatController::class, 'edit'])->name('edit');
            Route::put('/{tahsilat}', [TahsilatController::class, 'update'])->name('update');
            Route::delete('/{tahsilat}', [TahsilatController::class, 'destroy'])->name('destroy');

            // AJAX
            Route::get('/customer/{customerId}/details', [TahsilatController::class, 'customerDetails'])->name('customer-details');
        });

        // Şirket Ödemeleri
        Route::prefix('sirket-odemeleri')->name('sirket-odemeleri.')->group(function () {
            Route::get('/', [SirketOdemeController::class, 'index'])->name('index');
            Route::get('/create', [SirketOdemeController::class, 'create'])->name('create');
            Route::post('/', [SirketOdemeController::class, 'store'])->name('store');
            Route::get('/{sirketOdeme}', [SirketOdemeController::class, 'show'])->name('show');
            Route::get('/{sirketOdeme}/edit', [SirketOdemeController::class, 'edit'])->name('edit');
            Route::put('/{sirketOdeme}', [SirketOdemeController::class, 'update'])->name('update');
            Route::delete('/{sirketOdeme}', [SirketOdemeController::class, 'destroy'])->name('destroy');

            // AJAX
            Route::get('/company/{companyId}/details', [SirketOdemeController::class, 'companyDetails'])->name('company-details');
        });

    });
});

Route::get('/quotation/view/{token}', [QuotationController::class, 'view'])->name('quotations.view');

Route::get('/make-mailable', function () {
    Artisan::call('make:mail', ['name' => 'ContactFormMail', '--markdown' => 'emails.contact']);
    return 'Mailable created successfully!';
});

Route::get('/insurance-companies/count', [InsuranceCompanyController::class, 'count'])->name('insurance-companies.count');
// Route::get('/test-mail', function () {
//     try {
//         $testData = [
//             'full_name' => 'Test Kullanıcı',
//             'email' => 'yunuskirca34@gmail.com',
//             'phone' => '0555 555 55 55',
//             'subject' => 'Test Mesajı',
//             'message' => 'Bu bir test mesajıdır.',
//             'ip_address' => '127.0.0.1',
//         ];

//         Mail::to('sigortaacenteyonetimsistemi@gmail.com')
//             ->send(new \App\Mail\ContactFormMail($testData));

//         return 'Test maili gönderildi!';
//     } catch (\Exception $e) {
//         return 'Hata: ' . $e->getMessage();
//     }
// });
Route::get('/tahsilatlar/customer-policies/{customer}', [TahsilatController::class, 'getCustomerPolicies'])
    ->name('tahsilatlar.customer-policies');

    // Raporlar grubu içine ekle (mevcut report route'ların yanına)
Route::get('/reports/cari', [ReportController::class, 'cari'])->name('reports.cari');
