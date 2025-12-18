@extends('web.layouts.app')

@section('title', 'Teklif Yönetimi Modülü')
@section('meta_description', 'Hızlı teklif hazırlayın ve müşteri ile online paylaşın. Çoklu sigorta şirketi karşılaştırması.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero">
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Teklif Yönetimi</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Teklif Yönetimi</h1>
            <p>
                Farklı sigorta şirketlerinden gelen teklifleri tek ekranda karşılaştırın.
                Müşteri ile özel link paylaşın ve teklifi online onaylattırın.
            </p>
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
        </div>
        <div class="module-detail-hero-image">
            <img src="https://via.placeholder.com/600x400/0dcaf0/ffffff?text=Teklif+Yonetimi"
                 alt="Teklif Yönetimi">
        </div>
    </div>
</section>

<!-- Features Detail -->
<section class="module-features-detail-section">
    <div class="container">
        <h2 class="section-title">Özellikler</h2>
        <p class="section-subtitle">
            Teklif sürecinizi hızlandıran özellikler
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-layers"></i>
                </div>
                <h3>Çoklu Teklif</h3>
                <p>
                    Tek teklif içinde birden fazla sigorta şirketi teklifini ekleyin ve karşılaştırın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-share"></i>
                </div>
                <h3>Online Paylaşım</h3>
                <p>
                    Özel link ile müşteri teklifleri online görüntüleyebilir. Görüntülenme takibi yapılır.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3>Otomatik Karşılaştırma</h3>
                <p>
                    Sistem en düşük fiyatlı teklifi otomatik gösterir. Teminat karşılaştırması yapabilirsiniz.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-arrow-right-circle"></i>
                </div>
                <h3>Poliçeye Dönüşüm</h3>
                <p>
                    Onaylanan teklifi tek tıkla poliçeye dönüştürün. Tüm bilgiler otomatik aktarılır.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h3>Geçerlilik Takibi</h3>
                <p>
                    Teklif geçerlilik süreleri otomatik takip edilir. Süresi dolan teklifler işaretlenir.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-file-pdf"></i>
                </div>
                <h3>PDF Oluşturma</h3>
                <p>
                    Teklifleri profesyonel PDF formatında indirin. Logo ve şirket bilgileri ile özelleştirin.
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
            4 adımda teklif süreci
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Teklif Oluşturun</h3>
                    <p>
                        Müşteri seçin, teklif türünü belirleyin (Kasko, Konut vb.) ve geçerlilik tarihini girin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Sigorta Şirketi Tekliflerini Ekleyin</h3>
                    <p>
                        Her sigorta şirketinden gelen teklifi sisteme girin. Prim tutarı, teminatlar ve notları ekleyin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Müşteri İle Paylaşın</h3>
                    <p>
                        Özel link oluşturun ve müşteriyle SMS veya e-posta ile paylaşın.
                        Müşteri teklifleri online görüntüler.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Onay ve Dönüşüm</h3>
                    <p>
                        Müşteri teklifi onayladığında poliçeye dönüştürün. Tüm bilgiler otomatik aktarılır.
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
            Teklif yönetimi ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.customers') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Yönetimi</h3>
                <p>Teklif istenen müşterileri yönetin</p>
            </a>

            <a href="{{ route('modules.policies') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Yönetimi</h3>
                <p>Teklifi poliçeye dönüştürün</p>
            </a>

            <a href="{{ route('modules.campaigns') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <h3>Kampanyalar</h3>
                <p>Teklif linklerini SMS ile gönderin</p>
            </a>

            <a href="{{ route('modules.reports') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3>Raporlama</h3>
                <p>Teklif dönüşüm oranlarını görün</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Teklif Yönetimini Deneyin</h2>
        <p>14 gün boyunca teklif hazırlayın ve müşterilerinizle paylaşın.</p>
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
