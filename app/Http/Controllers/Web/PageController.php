<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Hakkımızda Sayfası
     */
    public function about()
    {
        return view('web.about');
    }

    /**
     * Modüller Ana Sayfası
     */
    public function modules()
    {
        $modules = [
            [
                'slug' => 'customers',
                'name' => 'Müşteri Yönetimi',
                'icon' => 'people',
                'description' => 'Müşterilerinizi merkezi bir platformda yönetin.',
                'color' => 'primary',
            ],
            [
                'slug' => 'policies',
                'name' => 'Poliçe Yönetimi',
                'icon' => 'shield-check',
                'description' => '7 farklı poliçe türünü kolayca yönetin.',
                'color' => 'success',
            ],
            [
                'slug' => 'quotations',
                'name' => 'Teklif Yönetimi',
                'icon' => 'file-earmark-text',
                'description' => 'Hızlı teklif hazırlayın ve müşteri ile paylaşın.',
                'color' => 'info',
            ],
            [
                'slug' => 'renewals',
                'name' => 'Yenileme Takip',
                'icon' => 'arrow-clockwise',
                'description' => 'Poliçe yenilemelerini otomatik takip edin.',
                'color' => 'warning',
            ],
            [
                'slug' => 'payments',
                'name' => 'Ödeme & Taksit',
                'icon' => 'credit-card',
                'description' => 'Taksit planları ve tahsilat takibi.',
                'color' => 'success',
            ],
            [
                'slug' => 'tasks',
                'name' => 'Görev Yönetimi',
                'icon' => 'check2-square',
                'description' => 'Ekip içi görev atama ve takip sistemi.',
                'color' => 'primary',
            ],
            [
                'slug' => 'campaigns',
                'name' => 'Kampanyalar',
                'icon' => 'megaphone',
                'description' => 'SMS, E-posta ve WhatsApp kampanyaları.',
                'color' => 'danger',
            ],
            [
                'slug' => 'reports',
                'name' => 'Raporlama',
                'icon' => 'bar-chart',
                'description' => 'Detaylı raporlar ve analizler.',
                'color' => 'secondary',
            ],
        ];

        return view('web.modules.index', compact('modules'));
    }

    /**
     * Modül Detay Sayfaları
     */
    public function moduleCustomers()
    {
        return view('web.modules.customers');
    }

    public function modulePolicies()
    {
        return view('web.modules.policies');
    }

    public function moduleQuotations()
    {
        return view('web.modules.quotations');
    }

    public function moduleRenewals()
    {
        return view('web.modules.renewals');
    }

    public function modulePayments()
    {
        return view('web.modules.payments');
    }

    public function moduleTasks()
    {
        return view('web.modules.tasks');
    }

    public function moduleCampaigns()
    {
        return view('web.modules.campaigns');
    }

    public function moduleReports()
    {
        return view('web.modules.reports');
    }

    /**
     * Paketler Sayfası
     */
    public function pricing()
    {
        $packages = [
            [
                'name' => 'Temel',
                'price' => 999,
                'period' => 'ay',
                'description' => 'Küçük acenteler için ideal',
                'features' => [
                    '1 Kullanıcı',
                    '500 Müşteri',
                    'Temel Modüller',
                    '5 GB Depolama',
                    'E-posta Destek',
                    'Aylık Raporlar',
                ],
                'color' => 'primary',
                'recommended' => false,
            ],
            [
                'name' => 'Profesyonel',
                'price' => 1999,
                'period' => 'ay',
                'description' => 'Büyüyen işletmeler için',
                'features' => [
                    '5 Kullanıcı',
                    '2.000 Müşteri',
                    'Tüm Modüller',
                    '20 GB Depolama',
                    'Öncelikli Destek',
                    'Günlük Raporlar',
                    'SMS Entegrasyonu',
                    'API Erişimi',
                ],
                'color' => 'success',
                'recommended' => true,
            ],
            [
                'name' => 'Kurumsal',
                'price' => null,
                'period' => 'özel',
                'description' => 'Büyük kuruluşlar için',
                'features' => [
                    'Sınırsız Kullanıcı',
                    'Sınırsız Müşteri',
                    'Tüm Modüller',
                    'Sınırsız Depolama',
                    '7/24 Telefon Destek',
                    'Özel Entegrasyonlar',
                    'Özel Eğitim',
                    'Adanmış Hesap Yöneticisi',
                ],
                'color' => 'dark',
                'recommended' => false,
            ],
        ];

        return view('web.pricing', compact('packages'));
    }

    /**
     * CRM Nedir Sayfası
     */
    public function whatIsCrm()
    {
        return view('web.what-is-crm');
    }

    /**
     * İletişim Sayfası
     */
    public function contact()
    {
        return view('web.contact');
    }

    /**
     * İletişim Formu Gönder
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Genel Bilgi Talebi',
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}
