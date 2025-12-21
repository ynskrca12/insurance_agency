@extends('web.layouts.app')

@section('title', 'Görev Yönetimi Modülü')
@section('meta_description', 'Ekip içi görev atama ve takip sistemi. Kanban görünümü, önceliklendirme ve hatırlatmalar.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero py-5 px-4">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Görev Yönetimi</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Görev Yönetimi</h1>
            <p>
                Ekip içi görevleri organize edin. Müşteri bazlı görev atama, önceliklendirme,
                vade takibi ve Kanban görünümü ile verimliliği artırın.
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
            Ekip koordinasyonunu güçlendiren özellikler
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3>Görev Atama</h3>
                <p>
                    Ekip üyelerine görev atayın. Müşteri, poliçe veya genel görevler oluşturun.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-kanban"></i>
                </div>
                <h3>Kanban Görünümü</h3>
                <p>
                    Görevleri sürükle-bırak ile yönetin. Bekliyor, Devam Ediyor, Tamamlandı sütunları.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-flag"></i>
                </div>
                <h3>Önceliklendirme</h3>
                <p>
                    Düşük, Normal, Yüksek, Acil öncelik seviyeleri ile görevleri sıralayın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <h3>Kategori Sistemi</h3>
                <p>
                    Arama, Toplantı, Takip, Evrak, Yenileme, Ödeme, Teklif ve Diğer kategorileri.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h3>Vade Takibi</h3>
                <p>
                    Görev vade tarihlerini takip edin. Gecikmiş görevler kırmızı işaretlenir.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h3>Yorum Sistemi</h3>
                <p>
                    Görevlere yorum ekleyin. Ekip içi iletişimi güçlendirin.
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
            Etkili görev yönetimi süreci
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Görev Oluşturun</h3>
                    <p>
                        Görev başlığı, açıklama, kategori, öncelik ve vade tarihi belirleyin.
                        Müşteri veya poliçe ile ilişkilendirin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Ekip Üyesine Atayın</h3>
                    <p>
                        Görevi sorumlu ekip üyesine atayın. Atanan kişiye bildirim gönderilir.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>İlerlemeyi Takip Edin</h3>
                    <p>
                        Görev durumunu güncelleyin: Bekliyor → Devam Ediyor → Tamamlandı.
                        Kanban'da sürükle-bırak ile yönetin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Raporlayın</h3>
                    <p>
                        Tamamlanan görevleri, gecikmiş görevleri ve ekip performansını raporlayın.
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
            Görev yönetimi ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.customers') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Müşteri için görev oluşturun</p>
            </a>

            <a href="{{ route('modules.renewals') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-arrow-clockwise"></i>
                </div>
                <h3>Yenileme Takip</h3>
                <p>Yenileme için görev atayın</p>
            </a>

            <a href="{{ route('modules.quotations') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3>Teklif Yönetimi</h3>
                <p>Teklif takibi için görev oluşturun</p>
            </a>

            <a href="{{ route('modules.reports') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3>Raporlama</h3>
                <p>Ekip performansını raporlayın</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Görev Yönetimini Deneyin</h2>
        <p>Ekip koordinasyonunu güçlendirin, verimlilik artırın.</p>
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
