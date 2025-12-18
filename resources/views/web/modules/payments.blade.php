@extends('web.layouts.app')

@section('title', 'Ödeme & Taksit Yönetimi Modülü')
@section('meta_description', 'Taksit planları oluşturun ve tahsilatları takip edin. Gecikmiş ödemeler için otomatik hatırlatmalar.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Ödeme & Taksit</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Ödeme & Taksit Yönetimi</h1>
            <p>
                Otomatik taksit planları oluşturun, vade tarihlerini takip edin ve tahsilatları yönetin.
                Gecikmiş ödemeler için SMS hatırlatmaları gönderin.
            </p>
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
        </div>
        <div class="module-detail-hero-image">
            <img src="https://via.placeholder.com/600x400/198754/ffffff?text=Odeme+Yonetimi"
                 alt="Ödeme Yönetimi">
        </div>
    </div>
</section>

<!-- Features Detail -->
<section class="module-features-detail-section">
    <div class="container">
        <h2 class="section-title">Özellikler</h2>
        <p class="section-subtitle">
            Tahsilat sürecinizi kolaylaştıran özellikler
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-calculator"></i>
                </div>
                <h3>Otomatik Taksit Planı</h3>
                <p>
                    Poliçe oluştururken taksit sayısını girin. Sistem otomatik aylık taksit planı oluşturur.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h3>Vade Takibi</h3>
                <p>
                    Bugün vadesi dolan, yaklaşan ve gecikmiş taksitleri ayrı listelerde görüntüleyin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <h3>Ödeme Kayıt</h3>
                <p>
                    Nakit, kredi kartı, havale/EFT, çek ve POS ile yapılan ödemeleri kaydedin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-bell"></i>
                </div>
                <h3>Otomatik Hatırlatma</h3>
                <p>
                    Vade tarihinden önce ve gecikmiş ödemeler için müşterilere SMS gönderin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-bar-chart-line"></i>
                </div>
                <h3>Tahsilat Raporları</h3>
                <p>
                    Günlük, haftalık, aylık tahsilat raporlarınızı görüntüleyin. Excel'e aktarın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-receipt"></i>
                </div>
                <h3>Makbuz Oluşturma</h3>
                <p>
                    Her ödeme için profesyonel makbuz oluşturun. Logo ve firma bilgisi ekleyin.
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
            Basit tahsilat süreci
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Taksit Planı Oluşturulur</h3>
                    <p>
                        Poliçe oluştururken "Taksitli" seçilir ve taksit sayısı girilir.
                        Sistem otomatik aylık plan oluşturur.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Vade Takibi</h3>
                    <p>
                        Dashboard'da yaklaşan ve gecikmiş taksitler gösterilir.
                        Taksit listesinde filtreleme yapabilirsiniz.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Ödeme Kaydet</h3>
                    <p>
                        Müşteri ödeme yaptığında "Ödeme Kaydet" butonuna tıklayın.
                        Tutar, tarih ve yöntemi girin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Raporlama</h3>
                    <p>
                        Ödemeler otomatik raporlanır. Günlük tahsilat, ödeme yöntemleri ve
                        gecikme analizlerini görüntüleyin.
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
            Ödeme yönetimi ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.policies') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Yönetimi</h3>
                <p>Poliçe ödemelerini yönetin</p>
            </a>

            <a href="{{ route('modules.customers') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Müşteri ödeme geçmişini görün</p>
            </a>

            <a href="{{ route('modules.campaigns') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <h3>Kampanyalar</h3>
                <p>Ödeme hatırlatmaları gönderin</p>
            </a>

            <a href="{{ route('modules.reports') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3>Raporlama</h3>
                <p>Tahsilat raporlarını görüntüleyin</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Ödeme Yönetimini Deneyin</h2>
        <p>Tahsilatınızı kolaylaştırın, nakit akışınızı iyileştirin.</p>
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
