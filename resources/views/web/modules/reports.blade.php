@extends('web.layouts.app')

@section('title', 'Raporlama Modülü')
@section('meta_description', 'Detaylı raporlar ve analizler. Gelir-gider, komisyon, müşteri ve performans raporları.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero py-5 px-4">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Raporlama</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Raporlama & Analiz</h1>
            <p>
                İşinizi veri odaklı yönetin. Gelir-gider, komisyon, müşteri ve performans raporları ile
                detaylı analizler yapın. Grafikler ve tablolar ile görselleştirin.
            </p>
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
        </div>
    </div>
</section>

<!-- Features Detail -->
<section class="module-features-detail-section">
    <div class="container">
        <h2 class="section-title">Özellikler</h2>
        <p class="section-subtitle">
            Veri odaklı karar almanızı sağlayan raporlar
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h3>Gelir-Gider Raporu</h3>
                <p>
                    Toplam gelir, komisyon geliri, giderler ve net kâr hesaplamaları.
                    Tarih aralığına göre filtreleme.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-percent"></i>
                </div>
                <h3>Komisyon Raporu</h3>
                <p>
                    Sigorta şirketi bazlı komisyon dağılımı. Poliçe türüne göre komisyon analizi.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Analizi</h3>
                <p>
                    Yeni müşteriler, aktif müşteriler, şehir bazlı dağılım. Müşteri segmentasyonu.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Raporları</h3>
                <p>
                    Poliçe türü dağılımı, aktif-pasif durumu, yenileme oranları. Detaylı poliçe analizleri.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3>Performans Metrikleri</h3>
                <p>
                    Kullanıcı bazlı performans, teklif dönüşüm oranları, tahsilat başarısı.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-file-earmark-excel"></i>
                </div>
                <h3>Excel/PDF Export</h3>
                <p>
                    Tüm raporları Excel veya PDF formatında indirin. Profesyonel sunum hazırlayın.
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
            Raporlama süreci
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Rapor Türünü Seçin</h3>
                    <p>
                        Gelir-gider, komisyon, müşteri, poliçe veya performans raporlarından
                        ihtiyacınız olanı seçin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Filtreleyin</h3>
                    <p>
                        Tarih aralığı, kullanıcı, sigorta şirketi, poliçe türü gibi
                        filtreler uygulayın.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Analiz Edin</h3>
                    <p>
                        Grafikler ve tablolar ile verileri görselleştirin. Trendleri ve
                        performansı analiz edin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Export Edin</h3>
                    <p>
                        İhtiyaç duyduğunuzda raporları Excel veya PDF olarak indirin.
                        Sunum ve arşivleme için kullanın.
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
            Raporlama modülü tüm diğer modüllerle entegre çalışır
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.policies') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Yönetimi</h3>
                <p>Poliçe raporlarını görüntüleyin</p>
            </a>

            <a href="{{ route('modules.payments') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h3>Ödeme Yönetimi</h3>
                <p>Tahsilat raporlarını analiz edin</p>
            </a>

            <a href="{{ route('modules.customers') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Müşteri analizlerini görün</p>
            </a>

            <a href="{{ route('modules.campaigns') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <h3>Kampanyalar</h3>
                <p>Kampanya performansını raporlayın</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Raporlama Modülünü Deneyin</h2>
        <p>Veri odaklı kararlar alın, işinizi büyütün.</p>
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
