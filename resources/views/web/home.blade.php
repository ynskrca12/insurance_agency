@extends('web.layouts.app')

@section('title', 'Anasayfa')
@section('meta_description', 'Sigorta acentenizi dijitalleştirin. Modern, güçlü ve kolay kullanımlı sigorta yönetim sistemi ile işlerinizi kolaylaştırın.')

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="hero-text">
            <div class="hero-badge">
                <span>Türkiye'nin En Gelişmiş Sigorta Yazılımı</span>
            </div>
            <h1>Sigorta Acentenizi <span class="gradient-text">Dijitalleştirin</span></h1>
            <p>
                Modern, güçlü ve kolay kullanımlı sigorta yönetim sistemi ile müşterilerinizi yönetin,
                poliçelerinizi takip edin, tahsilatınızı kolaylaştırın.
            </p>
            <div class="hero-stats-mini">
                <div class="stat-mini">
                    <strong></strong>
                    <span></span>
                </div>
                <div class="stat-mini">
                    <strong></strong>
                    <span></span>
                </div>
                <div class="stat-mini">
                    <strong></strong>
                    <span></span>
                </div>
            </div>
            <div class="hero-buttons">
                <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                    <span>14 Gün Ücretsiz Deneyin</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="{{ route('pricing') }}" class="btn btn-outline-white btn-lg">
                    <i class="bi bi-tag"></i>
                    <span class="ms-2">Paketleri İnceleyin</span>
                </a>
            </div>
        </div>
        <div class="hero-image">
            <div class="image-wrapper">
                <div class="floating-card card-1">
                    <i class="bi bi-graph-up-arrow"></i>
                    <div>
                        <strong>%45</strong>
                        <span>Verimlilik Artışı</span>
                    </div>
                </div>
                <div class="floating-card card-2">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <strong>7/24</strong>
                        <span>Güvenli Erişim</span>
                    </div>
                </div>
                <div class="floating-card card-3">
                    <i class="bi bi-clock-history"></i>
                    <div>
                        <strong>5 Saat</strong>
                        <span>Zaman Tasarrufu</span>
                    </div>
                </div>
                <img src="{{ asset('web/images/dashboard_view.png') }}"
                     alt="Dashboard Önizleme"
                     onerror="this.src='https://via.placeholder.com/800x500/2563eb/ffffff?text=Dashboard+Preview'">
                <div class="image-glow"></div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="mouse">
            <div class="wheel"></div>
        </div>
        <span>Aşağı Kaydırın</span>
    </div>
</section>

<!-- Features Section -->
<section class="features-section section">
    <div class="container">
        <h2 class="section-title">Neden Bizi Seçmelisiniz?</h2>
        <p class="section-subtitle">
            Sigorta acenteleri için özel olarak tasarlanmış, güçlü özelliklere sahip bir yönetim sistemi
        </p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <h3>Kolay Kullanım</h3>
                <p>
                    Sezgisel arayüz ile dakikalar içinde adapte olun. Eğitim gerektirmez,
                    hemen kullanmaya başlayın.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3>Güçlü Raporlama</h3>
                <p>
                    Detaylı raporlar ve analizler ile işinizi daha iyi yönetin.
                    Veri odaklı kararlar alın.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <h3>7/24 Destek</h3>
                <p>
                    Her zaman yanınızdayız. Teknik destek ekibimiz size yardımcı olmak için hazır.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Modules Section -->
<section class="modules-section section">
    <div class="container">
        <h2 class="section-title">Güçlü Modüller</h2>
        <p class="section-subtitle">
            İhtiyacınız olan her şey bir arada
        </p>

        <div class="modules-grid">
            <a href="{{ route('modules.customers') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-people text-primary"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Müşterilerinizi merkezi platformda yönetin</p>
            </a>

            <a href="{{ route('modules.policies') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-shield-check text-success"></i>
                </div>
                <h3>Poliçe Yönetimi</h3>
                <p>7 farklı poliçe türünü kolayca takip edin</p>
            </a>

            <a href="{{ route('modules.quotations') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-file-earmark-text text-info"></i>
                </div>
                <h3>Teklif Yönetimi</h3>
                <p>Hızlı teklif hazırlayın ve paylaşın</p>
            </a>

            <a href="{{ route('modules.renewals') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-arrow-clockwise text-warning"></i>
                </div>
                <h3>Yenileme Takip</h3>
                <p>Poliçe yenilemelerini otomatik takip edin</p>
            </a>

            <a href="{{ route('modules.payments') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-credit-card text-success"></i>
                </div>
                <h3>Ödeme & Taksit</h3>
                <p>Taksit planları ve tahsilat takibi</p>
            </a>

            <a href="{{ route('modules.tasks') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-check2-square text-primary"></i>
                </div>
                <h3>Görev Yönetimi</h3>
                <p>Ekip içi görev atama ve takip</p>
            </a>

            <a href="{{ route('modules.campaigns') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-megaphone text-danger"></i>
                </div>
                <h3>Kampanyalar</h3>
                <p>SMS, E-posta ve WhatsApp kampanyaları</p>
            </a>

            <a href="{{ route('modules.reports') }}" class="module-card">
                <div class="module-icon">
                    <i class="bi bi-bar-chart text-secondary"></i>
                </div>
                <h3>Raporlama</h3>
                <p>Detaylı raporlar ve analizler</p>
            </a>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('modules') }}" class="btn btn-primary btn-lg">
                Tüm Modülleri İncele <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-item">
            <h3>{{ number_format($stats['users']) }}+</h3>
            <p>Aktif Kullanıcı</p>
        </div>
        <div class="stat-item">
            <h3>{{ number_format($stats['policies']) }}+</h3>
            <p>Yönetilen Poliçe</p>
        </div>
        <div class="stat-item">
            <h3>%{{ $stats['uptime'] }}</h3>
            <p>Uptime Garantisi</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['support'] }}/7</h3>
            <p>Destek Hizmeti</p>
        </div>
    </div>
</section>

<!-- Pricing Preview Section -->
<section class="pricing-preview-section section">
    <div class="container">
        <h2 class="section-title">Paketlerimiz</h2>
        <p class="section-subtitle">
            İhtiyacınıza uygun paketi seçin
        </p>

        <div class="pricing-cards">
            <!-- Temel Paket -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>Temel</h3>
                    <p>Küçük acenteler için ideal</p>
                </div>
                <div class="pricing-price">
                    <span class="price">6.999₺</span>
                    <span class="period">/yıl</span>
                </div>
                <ul class="pricing-features">
                    <li><i class="bi bi-check-circle-fill"></i> 1 GB Disk Alanı</li>
                    <li><i class="bi bi-check-circle-fill"></i> 15 GB Aylık Trafik</li>
                    <li><i class="bi bi-check-circle-fill"></i> Temel Modüller</li>
                    <li><i class="bi bi-check-circle-fill"></i> E-posta Destek</li>
                </ul>
                <a href="{{ route('demo.form') }}" class="btn btn-outline-primary" style="width: 100%;">
                    Ücretsiz Deneyin
                </a>
            </div>

            <!-- Profesyonel Paket -->
            <div class="pricing-card featured">
                <div class="pricing-header">
                    <h3>Profesyonel</h3>
                    <p>Büyüyen işletmeler için</p>
                </div>
                <div class="pricing-price">
                    <span class="price">9.999₺</span>
                    <span class="period">/yıl</span>
                </div>
                <ul class="pricing-features">
                    <li><i class="bi bi-check-circle-fill"></i> 5 GB Disk Alanı</li>
                    <li><i class="bi bi-check-circle-fill"></i> 100 GB Aylık Trafik</li>
                    <li><i class="bi bi-check-circle-fill"></i> Tüm Modüller</li>
                    <li><i class="bi bi-check-circle-fill"></i> E-posta Destek</li>
                    <li><i class="bi bi-check-circle-fill"></i> Öncelikli Destek</li>
                </ul>
                <a href="{{ route('demo.form') }}" class="btn btn-primary" style="width: 100%;">
                    Ücretsiz Deneyin
                </a>
            </div>

            <!-- Kurumsal Paket -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3>Kurumsal</h3>
                    <p>Büyük kuruluşlar için</p>
                </div>
                <div class="pricing-price">
                    <span class="price" style="font-size: 2rem;">İletişime Geçin</span>
                </div>
                <ul class="pricing-features">
                    <li><i class="bi bi-check-circle-fill"></i> Limitsiz Disk Alanı</li>
                    <li><i class="bi bi-check-circle-fill"></i> Limitsiz Aylık Trafik</li>
                    <li><i class="bi bi-check-circle-fill"></i> Tüm Modüller</li>
                    <li><i class="bi bi-check-circle-fill"></i> 7/24 Destek</li>
                    <li><i class="bi bi-check-circle-fill"></i> SMS Entegrasyonu</li>
                    <li><i class="bi bi-check-circle-fill"></i> Özel Entegrasyonlar</li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary" style="width: 100%;">
                    Bize Ulaşın
                </a>
            </div>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('pricing') }}" class="btn btn-primary btn-lg">
                Tüm Paketleri Görüntüle <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>14 Gün Ücretsiz Deneyin</h2>
        <p>Kredi kartı bilgisi gerektirmez. İptal için herhangi bir taahhüt yok.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Hemen Başlayın
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-envelope me-2"></i>Bize Ulaşın
            </a>
        </div>
    </div>
</section>

@endsection
