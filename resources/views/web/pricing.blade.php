@extends('web.layouts.app')

@section('title', 'Paketler ve Fiyatlandırma')
@section('meta_description', 'Sigorta Yönetim Sistemi paket ve fiyatlandırma seçenekleri. İhtiyacınıza uygun paketi seçin.')

@section('content')

<!-- Hero Section -->
<section class="pricing-hero">
    <div class="pricing-hero-content">
        <h1>Şeffaf Fiyatlandırma</h1>
        <p>
            İhtiyacınıza uygun paketi seçin. Tüm paketlerde 14 gün ücretsiz deneme.
            Kredi kartı bilgisi gerektirmez, taahhüt yok.
        </p>

        <!-- Billing Toggle -->
        <div class="billing-toggle">
            <label class="billing-monthly active">Aylık</label>
            <div class="toggle-switch" onclick="toggleBilling()">
                <div class="toggle-slider"></div>
            </div>
            <label class="billing-yearly">
                Yıllık
                <span class="billing-discount">%20 İndirim</span>
            </label>
        </div>
    </div>
</section>

<!-- Pricing Cards -->
<section class="pricing-main-section">
    <div class="pricing-cards-wrapper">

        <!-- Temel Paket -->
        <div class="pricing-package-card animate-on-scroll">
            <div class="package-header">
                <div class="package-icon">
                    <i class="bi bi-star"></i>
                </div>
                <h3 class="package-name">Temel</h3>
                <p class="package-description">Küçük acenteler için ideal başlangıç paketi</p>

                <div class="package-price">
                    <span class="price-currency">₺</span>
                    <span class="price-amount monthly-price">729</span>
                    <span class="price-amount yearly-price" style="display: none;">6.999</span>
                    <span class="price-period monthly-period">/ay</span>
                    <span class="price-period yearly-period" style="display: none;">/yıl</span>
                </div>
                <p class="price-note monthly-note">+ KDV</p>
                <p class="price-note yearly-note" style="display: none;">+ KDV</p>
            </div>

            <div class="package-body">
                <h4 class="package-features-title">Paket İçeriği</h4>
                <ul class="package-features-list">
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>1 GB Disk Alanı</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>15 GB Aylık Trafik</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Müşteri & Poliçe Yönetimi</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Teklif & Yenileme Takip</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Ödeme & Taksit Yönetimi</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Temel Raporlar</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>5 GB Depolama Alanı</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>E-posta Destek (48 saat)</span>
                    </li>
                </ul>
            </div>

            <div class="package-footer">
                <a href="{{ route('demo.form') }}" class="package-cta-button">
                    14 Gün Ücretsiz Deneyin
                </a>
            </div>
        </div>

        <!-- Profesyonel Paket - Featured -->
        <div class="pricing-package-card featured animate-on-scroll">
            <span class="package-badge">ÖNERİLEN</span>

            <div class="package-header">
                <div class="package-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <h3 class="package-name">Profesyonel</h3>
                <p class="package-description">Büyüyen acenteler için en popüler paket</p>

                <div class="package-price">
                    <span class="price-currency">₺</span>
                    <span class="price-amount monthly-price">999</span>
                    <span class="price-amount yearly-price" style="display: none;">9.999</span>
                    <span class="price-period monthly-period">/ay</span>
                    <span class="price-period yearly-period" style="display: none;">/yıl</span>
                </div>
                <p class="price-note monthly-note">+ KDV</p>
                <p class="price-note yearly-note" style="display: none;">+ KDV </p>
            </div>

            <div class="package-body">
                <h4 class="package-features-title">Paket İçeriği</h4>
                <ul class="package-features-list">
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>5 GB Disk Alanı</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>100 GB Aylık Trafik</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span><strong>Tüm Modüller</strong> (8 Modül)</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Görev & Kampanya Yönetimi</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Detaylı Raporlama & Analiz</span>
                    </li

                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>20 GB Depolama Alanı</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>E-posta Destek (24 saat)</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Öncelikli Destek</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>API Erişimi</span>
                    </li>
                </ul>
            </div>

            <div class="package-footer">
                <a href="{{ route('demo.form') }}" class="package-cta-button">
                    14 Gün Ücretsiz Deneyin
                </a>
            </div>
        </div>

        <!-- Kurumsal Paket -->
        <div class="pricing-package-card enterprise animate-on-scroll">
            <div class="package-header">
                <div class="package-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h3 class="package-name">Kurumsal</h3>
                <p class="package-description">Büyük kuruluşlar için özel çözümler</p>

                <div class="package-price">
                    <span class="price-amount">Özel Fiyat</span>
                </div>
                <p class="price-note">İhtiyaçlarınıza göre özelleştirilir</p>
            </div>

            <div class="package-body">
                <h4 class="package-features-title">Paket İçeriği</h4>
                <ul class="package-features-list">
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span><strong>Sınırsız Kullanıcı</strong></span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span><strong>Sınırsız Müşteri</strong></span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Tüm Modüller + Özel Geliştirmeler</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Özel Entegrasyonlar</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>SMS Entegrasyonu</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>WhatsApp Business API</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Sınırsız Depolama Alanı</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>7/24 Telefon Destek</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Adanmış Hesap Yöneticisi</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>Özel Eğitim & Onboarding</span>
                    </li>
                    <li>
                        <span class="feature-icon"><i class="bi bi-check-lg"></i></span>
                        <span>SLA Garantisi</span>
                    </li>
                </ul>
            </div>

            <div class="package-footer">
                <a href="{{ route('contact') }}" class="package-cta-button">
                    Bize Ulaşın
                </a>
            </div>
        </div>

    </div>
</section>

<!-- Comparison Table -->
<section class="comparison-section">
    <div class="container">
        <h2 class="section-title">Paket Karşılaştırması</h2>
        <p class="section-subtitle">
            Paketler arasındaki farkları detaylı inceleyin
        </p>

        <div class="comparison-table-wrapper">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Özellikler</th>
                        <th>Temel</th>
                        <th>Profesyonel</th>
                        <th>Kurumsal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Disk Alanı</td>
                        <td>1 GB</td>
                        <td>5 GB</td>
                        <td>Sınırsız</td>
                    </tr>
                    <tr>
                        <td>Aylık Trafik</td>
                        <td>15 GB</td>
                        <td>100 GB</td>
                        <td>Sınırsız</td>
                    </tr>
                    <tr>
                        <td>Müşteri Yönetimi</td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Poliçe Yönetimi</td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Teklif Yönetimi</td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Yenileme Takip</td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Ödeme & Taksit</td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Görev Yönetimi</td>
                        <td><i class="bi bi-x-circle-fill comparison-cross"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Kampanya Yönetimi</td>
                        <td><i class="bi bi-x-circle-fill comparison-cross"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Raporlama</td>
                        <td>Temel</td>
                        <td>Detaylı</td>
                        <td>Gelişmiş</td>
                    </tr>
                    <tr>
                        <td>API Erişimi</td>
                        <td><i class="bi bi-x-circle-fill comparison-cross"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                    <tr>
                        <td>Depolama Alanı</td>
                        <td>5 GB</td>
                        <td>10 GB</td>
                        <td>Sınırsız</td>
                    </tr>
                    <tr>
                        <td>Destek</td>
                        <td>E-posta (48s)</td>
                        <td>E-posta (24s)</td>
                        <td>7/24 Telefon</td>
                    </tr>
                    <tr>
                        <td>Özel Eğitim</td>
                        <td><i class="bi bi-x-circle-fill comparison-cross"></i></td>
                        <td><i class="bi bi-x-circle-fill comparison-cross"></i></td>
                        <td><i class="bi bi-check-circle-fill comparison-check"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <h2 class="section-title">Sıkça Sorulan Sorular</h2>
        <p class="section-subtitle">
            Fiyatlandırma ile ilgili merak ettikleriniz
        </p>

        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>14 günlük deneme nasıl çalışır?</span>
                    <span class="faq-icon"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Demo kayıt formunu doldurduğunuzda hesabınız otomatik oluşturulur ve 14 gün boyunca
                        tüm özellikleri ücretsiz kullanabilirsiniz. Kredi kartı bilgisi gerektirmez.
                        14 gün sonunda ödeme yapmadıysanız hesabınız otomatik kapanır.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>Yıllık ödeme yapmak zorunda mıyım?</span>
                    <span class="faq-icon"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Hayır, aylık veya yıllık ödeme seçeneklerinden size uygun olanı seçebilirsiniz.
                        Yıllık ödemede %20 indirim kazanırsınız. İstediğiniz zaman paket değişikliği
                        veya iptal yapabilirsiniz.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>Paket yükseltme nasıl yapılır?</span>
                    <span class="faq-icon"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Hesap ayarlarından istediğiniz zaman paket yükseltme yapabilirsiniz.
                        Kalan süre için ödediğiniz tutar yeni pakete devredilir. Tüm verileriniz
                        korunur ve kesinti olmadan geçiş yapılır.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>Verilerim güvende mi?</span>
                    <span class="faq-icon"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Tüm verileriniz şifreli sunucularda saklanır ve günlük yedekleme yapılır.
                        KVKK uyumlu çalışıyoruz. Verilerinize sadece siz erişebilirsiniz ve
                        üçüncü şahıslarla paylaşılmaz.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>İptal etmek istersem ne olur?</span>
                    <span class="faq-icon"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        İstediğiniz zaman iptal edebilirsiniz. Hesabınızı iptal ettiğinizde
                        mevcut dönem sonuna kadar hizmet almaya devam edersiniz. Verilerinizi
                        export edip indirebilirsiniz. Hiçbir iptal ücreti yoktur.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>Fatura kesiliyor mu?</span>
                    <span class="faq-icon"><i class="bi bi-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Evet, her ödemeniz için e-fatura veya e-arşiv fatura kesilir.
                        Faturalarınıza hesap ayarlarından ulaşabilir ve indirebilirsiniz.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Hemen Başlayın</h2>
        <p>14 gün boyunca tüm özellikleri ücretsiz deneyin. Kredi kartı bilgisi gerektirmez.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-envelope me-2"></i>Sorularınızı Sorun
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Billing Toggle (Monthly/Yearly)
function toggleBilling() {
    const toggle = document.querySelector('.toggle-switch');
    const monthlyLabels = document.querySelectorAll('.billing-monthly, .monthly-price, .monthly-period, .monthly-note');
    const yearlyLabels = document.querySelectorAll('.billing-yearly, .yearly-price, .yearly-period, .yearly-note');

    toggle.classList.toggle('active');

    if (toggle.classList.contains('active')) {
        // Show yearly
        monthlyLabels.forEach(el => {
            el.style.display = 'none';
            el.classList.remove('active');
        });
        yearlyLabels.forEach(el => {
            el.style.display = el.classList.contains('billing-yearly') ? 'flex' : 'inline';
            el.classList.add('active');
        });
    } else {
        // Show monthly
        yearlyLabels.forEach(el => {
            el.style.display = 'none';
            el.classList.remove('active');
        });
        monthlyLabels.forEach(el => {
            el.style.display = el.classList.contains('billing-monthly') ? 'flex' : 'inline';
            el.classList.add('active');
        });
    }
}

// FAQ Toggle
function toggleFaq(button) {
    const faqItem = button.parentElement;
    const isActive = faqItem.classList.contains('active');

    // Close all FAQs
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });

    // Open clicked FAQ if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}
</script>
@endpush
