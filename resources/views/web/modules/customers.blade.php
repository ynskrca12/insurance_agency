@extends('web.layouts.app')

@section('title', 'Müşteri Yönetimi Modülü')
@section('meta_description', 'Müşterilerinizi merkezi bir platformda yönetin. Detaylı profiller, notlar ve istatistikler.')

@section('content')

<!-- Hero Section -->
<section class="module-detail-hero">
    <!-- Breadcrumb -->
    <div class="module-detail-breadcrumb">
        <a href="{{ route('home') }}">Anasayfa</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('modules') }}">Modüller</a>
        <i class="bi bi-chevron-right"></i>
        <span>Müşteri Yönetimi</span>
    </div>

    <div class="module-detail-hero-content">
        <div class="module-detail-hero-text">
            <h1>Müşteri Yönetimi</h1>
            <p>
                Tüm müşteri bilgilerinizi merkezi bir platformda toplayın. Detaylı profiller,
                geçmiş kayıtları ve istatistikler ile müşterilerinizi daha iyi tanıyın.
            </p>
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
        </div>
        <div class="module-detail-hero-image">
            <img src="https://via.placeholder.com/600x400/667eea/ffffff?text=Musteri+Yonetimi"
                 alt="Müşteri Yönetimi">
        </div>
    </div>
</section>

<!-- Features Detail -->
<section class="module-features-detail-section">
    <div class="container">
        <h2 class="section-title">Özellikler</h2>
        <p class="section-subtitle">
            Müşteri yönetimini kolaylaştıran güçlü özellikler
        </p>

        <div class="features-detail-grid">
            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3>Hızlı Kayıt</h3>
                <p>
                    Müşterilerinizi dakikalar içinde sisteme kaydedin. Basit ve kullanıcı dostu form yapısı.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-file-person"></i>
                </div>
                <h3>Detaylı Profiller</h3>
                <p>
                    TC kimlik, adres, telefon, e-posta ve notlar ile eksiksiz müşteri profilleri oluşturun.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3>İstatistikler</h3>
                <p>
                    Müşteri bazlı poliçe sayısı, toplam prim, ödeme geçmişi gibi detaylı istatistikler.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <h3>Etiketleme</h3>
                <p>
                    Müşterilerinizi kategorilere ayırın. VIP, potansiyel, aktif gibi etiketler ekleyin.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <h3>Notlar & Hatırlatmalar</h3>
                <p>
                    Her müşteri için özel notlar ve hatırlatmalar oluşturun. Hiçbir detay kaçmasın.
                </p>
            </div>

            <div class="feature-detail-card animate-on-scroll">
                <div class="feature-detail-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h3>Gelişmiş Arama</h3>
                <p>
                    İsim, telefon, TC kimlik ile hızlı arama yapın. Filtreleme ve sıralama seçenekleri.
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
            4 basit adımda müşteri yönetimi
        </p>

        <div class="how-it-works-timeline">
            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Müşteri Kaydı Oluşturun</h3>
                    <p>
                        Yeni müşteri ekle butonuna tıklayın. Ad, soyad, telefon ve e-posta gibi
                        temel bilgileri girin. İsteğe bağlı olarak adres ve notlar ekleyin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Profil Bilgilerini Tamamlayın</h3>
                    <p>
                        TC kimlik numarası, doğum tarihi, meslek gibi detaylı bilgileri ekleyin.
                        Müşteri kategorisi (bireysel/kurumsal) belirleyin.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Poliçe ve İşlemler Ekleyin</h3>
                    <p>
                        Müşteri profili üzerinden poliçe, teklif ve ödeme kayıtları ekleyin.
                        Tüm bilgiler otomatik olarak müşteri ile ilişkilendirilir.
                    </p>
                </div>
            </div>

            <div class="timeline-step animate-on-scroll">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>İzleyin ve Yönetin</h3>
                    <p>
                        Müşteri detay sayfasından tüm bilgileri görüntüleyin. İstatistikler,
                        geçmiş kayıtlar ve yaklaşan işlemler tek ekranda.
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
            Müşteri yönetimi ile birlikte kullanabileceğiniz diğer modüller
        </p>

        <div class="related-modules-grid">
            <a href="{{ route('modules.policies') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Yönetimi</h3>
                <p>Müşteri poliçelerini yönetin</p>
            </a>

            <a href="{{ route('modules.quotations') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3>Teklif Yönetimi</h3>
                <p>Müşteriye teklif hazırlayın</p>
            </a>

            <a href="{{ route('modules.tasks') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-check2-square"></i>
                </div>
                <h3>Görev Yönetimi</h3>
                <p>Müşteri için görev oluşturun</p>
            </a>

            <a href="{{ route('modules.campaigns') }}" class="related-module-card animate-on-scroll">
                <div class="related-module-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <h3>Kampanyalar</h3>
                <p>Müşterilere kampanya gönderin</p>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Müşteri Yönetimini Deneyin</h2>
        <p>14 gün boyunca tüm özellikleri ücretsiz kullanın.</p>
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
