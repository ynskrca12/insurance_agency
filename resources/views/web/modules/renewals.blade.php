@extends('web.layouts.app')

@section('title', 'Yenileme Takip Modülü')
@section('meta_description', 'Poliçe yenilemelerini otomatik takip edin. Hiçbir yenileme kaçmaz, gelir kaybı yaşamazsınız.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Yenileme Takip</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Yenileme Takip</h1>
            <p>
                Poliçe bitiş tarihlerine göre otomatik yenileme kayıtları oluşturun.
                Önceliklendirme ile verimliliğinizi artırın, hiçbir müşteri kaçmasın.
            </p>
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
        </div>
        <div class="module-detail-hero-image">
            <img src="https://via.placeholder.com/600x400/ffc107/ffffff?text=Yenileme+Takip"
                 alt="Yenileme Takip">
        </div>
    </div>
</section>

<!-- Features Detail -->
<section class="module-features-detail-section">
    <div class="container">
        <h2 class="section-title">Özellikler</h2>
        <p class="section-subtitle">
            Yenileme sürecinizi optimize eden özellikler
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h3>Otomatik Oluşturma</h3>
                <p>
                    Poliçe bitiş tarihine göre sistem otomatik yenileme kaydı oluşturur. Manuel işlem gerekmez.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-sort-down"></i>
                </div>
                <h3>Önceliklendirme</h3>
                <p>
                    Vade tarihine göre kritik, yüksek, normal, düşük öncelik seviyeleri otomatik atanır.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-bell"></i>
                </div>
                <h3>Otomatik Hatırlatma</h3>
                <p>
                    Müşterilere SMS ve e-posta ile otomatik yenileme hatırlatmaları gönderin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-kanban"></i>
                </div>
                <h3>Durum Takibi</h3>
                <p>
                    Bekliyor, İletişimde, Yenilendi, Kaybedildi gibi durumlara göre süreci yönetin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-calendar3"></i>
                </div>
                <h3>Takvim Görünümü</h3>
                <p>
                    Yenilemeleri takvim üzerinde görüntüleyin. Haftalık ve aylık planlama yapın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3>Başarı Analizi</h3>
                <p>
                    Yenileme başarı oranınızı görün. Kaybedilen müşterileri analiz edin ve iyileştirin.
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
            Otomatik yenileme süreci
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Otomatik Kayıt Oluşturma</h3>
                    <p>
                        Sistem poliçe bitiş tarihini kontrol eder. Bitiş tarihine 90 gün kala
                        otomatik yenileme kaydı oluşturur.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Öncelik Atama</h3>
                    <p>
                        Vade tarihine göre öncelik seviyesi belirlenir. Kritik olanlar listenin en üstünde görünür.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Müşteri İle İletişim</h3>
                    <p>
                        Yenileme listesinden müşteriyi arayın. Durumu "İletişimde" olarak işaretleyin ve
                        notlarınızı kaydedin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Yenileme veya Kayıp</h3>
                    <p>
                        Müşteri yenileme yaptıysa "Yenilendi" olarak işaretleyin. Yeni poliçe oluşturun.
                        Kaybettiyseniz nedeni belirtin.
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
            Yenileme takip ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.policies') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Yönetimi</h3>
                <p>Yenilenecek poliçeleri görün</p>
            </a>

            <a href="{{ route('modules.quotations') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3>Teklif Yönetimi</h3>
                <p>Yenileme için teklif hazırlayın</p>
            </a>

            <a href="{{ route('modules.campaigns') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <h3>Kampanyalar</h3>
                <p>Toplu yenileme hatırlatması gönderin</p>
            </a>

            <a href="{{ route('modules.tasks') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-check2-square"></i>
                </div>
                <h3>Görev Yönetimi</h3>
                <p>Yenileme için görev oluşturun</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Yenileme Takibini Deneyin</h2>
        <p>Hiçbir yenileme kaçmasın, gelir kaybı yaşamayın.</p>
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
