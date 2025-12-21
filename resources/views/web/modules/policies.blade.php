@extends('web.layouts.app')

@section('title', 'Poliçe Yönetimi Modülü')
@section('meta_description', '7 farklı poliçe türünü yönetin. Otomatik komisyon hesaplama, vade takibi ve detaylı raporlama.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero py-5 px-4">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Poliçe Yönetimi</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Poliçe Yönetimi</h1>
            <p>
                Kasko, Trafik, Konut, DASK, Sağlık, Hayat ve TSS olmak üzere 7 farklı poliçe türünü
                tek platformda yönetin. Otomatik komisyon hesaplama ve vade takibi ile işlerinizi kolaylaştırın.
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
            Poliçe yönetimini profesyonelleştiren özellikler
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>7 Poliçe Türü</h3>
                <p>
                    Kasko, Trafik, Konut, DASK, Sağlık, Hayat ve TSS poliçelerini yönetin.
                    Her türe özel alanlar ve raporlar.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-calculator"></i>
                </div>
                <h3>Otomatik Komisyon</h3>
                <p>
                    Sigorta şirketi bazında komisyon oranları tanımlayın. Sistem otomatik hesaplama yapar.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h3>Vade Takibi</h3>
                <p>
                    Poliçe bitiş tarihlerini otomatik takip edin. Yaklaşan ve gecikmiş poliçeler için uyarılar.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h3>Ödeme Planları</h3>
                <p>
                    Peşin veya taksitli ödeme planları oluşturun. Taksit takibi ve tahsilat yönetimi.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <h3>Belge Yönetimi</h3>
                <p>
                    Poliçe PDF'leri, ruhsat fotokopileri ve diğer belgeleri dijital ortamda saklayın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h3>Otomatik Yenileme</h3>
                <p>
                    Poliçe bitiş tarihine göre otomatik yenileme kayıtları oluşturun. Hiçbir poliçe kaçmaz.
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
            4 adımda poliçe yönetimi
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Poliçe Türünü Seçin</h3>
                    <p>
                        Yeni poliçe eklerken türü seçin (Kasko, Trafik, Konut vb.).
                        Sistem ilgili formu otomatik açar.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Bilgileri Girin</h3>
                    <p>
                        Müşteri seçin, sigorta şirketi belirleyin, poliçe numarası ve tutarını girin.
                        Araç plakası, bina adresi gibi türe özel bilgileri ekleyin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Ödeme Planı Oluşturun</h3>
                    <p>
                        Peşin mi taksitli mi ödeme yapılacağını belirleyin. Taksitli ise
                        taksit sayısını girin, sistem otomatik plan oluşturur.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Takip Edin</h3>
                    <p>
                        Poliçe listesinde tüm bilgileri görüntüleyin. Durum, vade tarihi ve
                        komisyon bilgilerine anında erişin.
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
            Poliçe yönetimi ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.customers') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Poliçe sahibi müşterileri yönetin</p>
            </a>

            <a href="{{ route('modules.renewals') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-arrow-clockwise"></i>
                </div>
                <h3>Yenileme Takip</h3>
                <p>Poliçe yenilemelerini takip edin</p>
            </a>

            <a href="{{ route('modules.payments') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h3>Ödeme Yönetimi</h3>
                <p>Taksit ve tahsilatları yönetin</p>
            </a>

            <a href="{{ route('modules.reports') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3>Raporlama</h3>
                <p>Poliçe raporlarını görüntüleyin</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Poliçe Yönetimini Deneyin</h2>
        <p>14 gün boyunca tüm poliçe türlerini ücretsiz yönetin.</p>
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
