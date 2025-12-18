@extends('web.layouts.app')

@section('title', 'Kampanya Yönetimi Modülü')
@section('meta_description', 'SMS, E-posta ve WhatsApp kampanyaları oluşturun. Hedef kitle belirleme ve otomatik gönderim.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Kampanyalar</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Kampanya Yönetimi</h1>
            <p>
                SMS, E-posta ve WhatsApp ile toplu kampanyalar gönderin. Hedef kitle belirleme,
                mesaj şablonları ve gönderim istatistikleri ile pazarlamanızı güçlendirin.
            </p>
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
        </div>
        <div class="module-detail-hero-image">
            <img src="https://via.placeholder.com/600x400/dc3545/ffffff?text=Kampanya+Yonetimi"
                 alt="Kampanya Yönetimi">
        </div>
    </div>
</section>

<!-- Features Detail -->
<section class="module-features-detail-section">
    <div class="container">
        <h2 class="section-title">Özellikler</h2>
        <p class="section-subtitle">
            Etkili pazarlama için güçlü araçlar
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h3>3 Kanal Desteği</h3>
                <p>
                    SMS, E-posta ve WhatsApp üzerinden kampanya gönderin. Çoklu kanal stratejisi uygulayın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Hedef Kitle Belirleme</h3>
                <p>
                    Tüm müşteriler, şehir bazlı, poliçe türüne göre veya özel filtrelerle hedef kitle seçin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-file-text"></i>
                </div>
                <h3>Mesaj Şablonları</h3>
                <p>
                    Hazır şablonlar kullanın veya kendi şablonlarınızı oluşturun. Değişkenlerle kişiselleştirin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <h3>Zamanlama</h3>
                <p>
                    Kampanyayı hemen gönderin veya gelecek tarih için zamanlayın. Otomatik gönderim.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3>İstatistikler</h3>
                <p>
                    Gönderim sayısı, başarı oranı, açılma oranı gibi detaylı istatistikler görüntüleyin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>KVKK Uyumlu</h3>
                <p>
                    Müşteri izin yönetimi ile KVKK uyumlu kampanyalar gönderin. Opt-out seçeneği.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works-section">
    <div class="container">
        <h2 class="section-title">Nasıl Çalışır?</h2>
        <p class="section-subtitle">
            4 adımda kampanya oluşturma
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Kampanya Tipi Seçin</h3>
                    <p>
                        SMS, E-posta veya WhatsApp seçin. Kampanyaya isim verin ve konu belirleyin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Hedef Kitle Belirleyin</h3>
                    <p>
                        Tüm müşteriler, belirli şehir, poliçe türü veya özel filtreler ile
                        hedef kitlenizi seçin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Mesajı Hazırlayın</h3>
                    <p>
                        Şablon seçin veya yeni mesaj yazın. {name}, {policy_number} gibi
                        değişkenlerle kişiselleştirin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Gönderin veya Zamanlayın</h3>
                    <p>
                        Hemen gönder butonuna tıklayın veya gelecek tarih için zamanlama yapın.
                        İstatistikleri takip edin.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Modules -->
<section class="related-modules-section">
    <div class="container">
        <h2 class="section-title">İlgili Modüller</h2>
        <p class="section-subtitle">
            Kampanya yönetimi ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.customers') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Hedef kitle müşterilerini yönetin</p>
            </a>

            <a href="{{ route('modules.renewals') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-arrow-clockwise"></i>
                </div>
                <h3>Yenileme Takip</h3>
                <p>Yenileme hatırlatmaları gönderin</p>
            </a>

            <a href="{{ route('modules.payments') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h3>Ödeme Yönetimi</h3>
                <p>Ödeme hatırlatmaları gönderin</p>
            </a>

            <a href="{{ route('modules.reports') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3>Raporlama</h3>
                <p>Kampanya performansını analiz edin</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Kampanya Yönetimini Deneyin</h2>
        <p>Müşterilerinizle düzenli iletişim kurun, satışlarınızı artırın.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
            <a href="{{ route('modules') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-grid me-2"></i>Tüm Modüller
            </a>
        </div>
    </div>
</section>

@endsection
