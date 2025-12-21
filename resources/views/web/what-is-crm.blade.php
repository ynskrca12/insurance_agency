@extends('web.layouts.app')

@section('title', 'CRM Nedir?')
@section('meta_description', 'CRM (Müşteri İlişkileri Yönetimi) nedir? Sigorta acenteleri için CRM\'in önemi ve faydaları.')

@section('content')

<!-- Hero Section -->
<section class="crm-hero py-5 px-4">
    <div class="crm-hero-content">
        <div class="crm-hero-text">
            <h1>CRM Nedir?</h1>
            <p>
                Müşterilerinizi daha iyi tanıyın, ilişkilerinizi güçlendirin ve satışlarınızı artırın.
                CRM sistemi, modern işletmelerin vazgeçilmez aracıdır.
            </p>
        </div>
        <div class="crm-hero-visual">
            <div class="crm-definition-card">
                <h3>Kısaca CRM</h3>
                <p>
                    CRM (Customer Relationship Management), müşteri ilişkilerini yönetmek,
                    müşteri verilerini organize etmek ve satış süreçlerini optimize etmek için
                    kullanılan bir yazılım sistemidir.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CRM Acronym Explanation -->
<section class="crm-explanation-section">
    <div class="crm-explanation-content">
        <div class="crm-acronym">
            <h2 class="section-title">CRM Ne Demek?</h2>
            <p class="section-subtitle">Customer Relationship Management - Müşteri İlişkileri Yönetimi</p>

            <div class="acronym-grid">
                <div class="acronym-card animate-on-scroll">
                    <div class="acronym-letter">C</div>
                    <div class="acronym-word">Customer</div>
                    <p class="acronym-meaning">
                        Müşteri - İşletmenizin en değerli varlığı. CRM, tüm müşteri bilgilerini
                        merkezi bir platformda toplar.
                    </p>
                </div>

                <div class="acronym-card animate-on-scroll">
                    <div class="acronym-letter">R</div>
                    <div class="acronym-word">Relationship</div>
                    <p class="acronym-meaning">
                        İlişki - Müşterilerinizle kurduğunuz bağ. CRM, bu ilişkileri
                        güçlendirmenize yardımcı olur.
                    </p>
                </div>

                <div class="acronym-card animate-on-scroll">
                    <div class="acronym-letter">M</div>
                    <div class="acronym-word">Management</div>
                    <p class="acronym-meaning">
                        Yönetim - Süreçlerin organize edilmesi. CRM, iş akışlarınızı
                        düzenler ve otomatikleştirir.
                    </p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <p style="font-size: 1.125rem; color: var(--gray-600); line-height: 1.8; max-width: 800px; margin: 0 auto;">
                CRM, sadece bir yazılım değil, müşteri odaklı iş yapma felsefesidir.
                Müşteri memnuniyetini artırmak, satış verimliliğini yükseltmek ve
                uzun vadeli müşteri sadakati oluşturmak için kullanılır.
            </p>
        </div>
    </div>
</section>

<!-- Insurance Specific CRM -->
<section class="insurance-crm-section">
    <div class="container">
        <h2 class="section-title">Sigorta Acenteleri İçin CRM</h2>
        <p class="section-subtitle">
            Sigorta sektörüne özel CRM çözümleri
        </p>

        <div class="insurance-crm-content">
            <div class="insurance-crm-grid">
                <div class="insurance-crm-text animate-on-scroll">
                    <h3>Neden Sigorta Acentelerine Özel CRM?</h3>
                    <p>
                        Genel CRM sistemleri her sektöre hitap eder, ancak sigorta sektörünün
                        kendine özgü ihtiyaçları vardır. Poliçe yönetimi, yenileme takibi,
                        taksit planları ve komisyon hesaplamaları gibi özellikler genel CRM'lerde yoktur.
                    </p>
                    <p>
                        Sigorta acentelerine özel CRM, bu ihtiyaçları karşılamak için tasarlanmıştır.
                        Müşteri yönetiminin yanı sıra poliçe, teklif, yenileme ve ödeme süreçlerini
                        de yönetir.
                    </p>
                </div>
                <div class="insurance-crm-image animate-on-scroll">
                    <img src="{{ asset('web/images/insurance2.jpg') }}"
                         alt="Sigorta CRM">
                </div>
            </div>

            <div class="insurance-crm-grid" style="margin-top: 3rem;">
                <div class="insurance-crm-image animate-on-scroll" style="order: 2;">
                    <img src="{{ asset('web/images/insurance_agency.jpg') }}"
                         alt="Geleneksel vs Dijital">
                </div>
                <div class="insurance-crm-text animate-on-scroll" style="order: 1;">
                    <h3>Geleneksel Yöntemlerden CRM'e Geçiş</h3>
                    <p>
                        Birçok sigorta acentesi hala Excel tabloları, kağıt dosyalar ve not defterleri
                        ile çalışmaktadır. Bu yöntemler zaman kaybına, veri kaybına ve insan hatasına
                        açıktır.
                    </p>
                    <p>
                        CRM sistemi, tüm bu manuel süreçleri dijitalleştirir. Verileriniz güvende,
                        her yerden erişilebilir ve otomatik yedeklenir. Arama, filtreleme ve
                        raporlama dakikalar içinde yapılır.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
    <div class="container">
        <h2 class="section-title">CRM Kullanmanın Faydaları</h2>
        <p class="section-subtitle">
            İşletmenize sağlayacağı somut faydalar
        </p>

        <div class="benefits-grid">
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h3>Satışları Artırır</h3>
                <p>
                    Müşteri ihtiyaçlarını daha iyi anlayarak doğru zamanda doğru teklifi sunarsınız.
                    Satış dönüşüm oranınız %30-40 artar.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h3>Zaman Tasarrufu</h3>
                <p>
                    Manuel işlemler otomatikleşir. Poliçe yenileme hatırlatmaları, taksit takibi
                    ve raporlama otomatik yapılır. Günde 2-3 saat kazanırsınız.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Memnuniyeti</h3>
                <p>
                    Müşterilerinize daha hızlı ve kaliteli hizmet sunarsınız. Müşteri şikayetleri
                    %50 azalır, sadakat artar.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Veri Güvenliği</h3>
                <p>
                    Müşteri bilgileri şifreli sunucularda saklanır. Kağıt kayıpları, yangın veya
                    sel gibi risklere karşı korunursunuz.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <h3>Veri Odaklı Kararlar</h3>
                <p>
                    Detaylı raporlar ve analizler ile işinizi daha iyi yönetirsiniz. Hangi ürünler
                    karlı, hangi müşteriler aktif, trendler nedir - hepsini görürsünüz.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h3>Yenileme Oranını Artırır</h3>
                <p>
                    Poliçe bitiş tarihlerini otomatik takip eder, müşterilere hatırlatma gönderir.
                    Hiçbir yenileme kaçmaz, gelir kaybı yaşamazsınız.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h3>Tahsilat Kolaylaşır</h3>
                <p>
                    Taksit vadelerini takip eder, gecikmiş ödemeler için SMS gönderir.
                    Tahsilat başarı oranınız %60 artar.
                </p>
            </div>

            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon">
                    <i class="bi bi-globe"></i>
                </div>
                <h3>Her Yerden Erişim</h3>
                <p>
                    Bilgisayar, tablet veya telefondan her yerden erişebilirsiniz.
                    Ofiste, evde veya yolda - verileriniz her zaman yanınızda.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Who Should Use -->
<section class="who-should-use-section">
    <div class="container">
        <h2 class="section-title">Kimler CRM Kullanmalı?</h2>
        <p class="section-subtitle">
            Hangi sigorta acenteleri CRM'den faydalanır?
        </p>

        <div class="who-cards">
            <div class="who-card animate-on-scroll">
                <div class="who-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h3>Küçük Acenteler</h3>
                <p>
                    50-500 müşterisi olan küçük acenteler için ideal. Excel karmaşasından
                    kurtulun, profesyonel görünün.
                </p>
            </div>

            <div class="who-card animate-on-scroll">
                <div class="who-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <h3>Orta Ölçekli Acenteler</h3>
                <p>
                    500-2000 müşterisi olan ve birden fazla çalışanı olan acenteler.
                    Ekip koordinasyonu ve süreç yönetimi kritiktir.
                </p>
            </div>

            <div class="who-card animate-on-scroll">
                <div class="who-icon">
                    <i class="bi bi-building-gear"></i>
                </div>
                <h3>Büyük Kuruluşlar</h3>
                <p>
                    2000+ müşterisi olan ve şubesi olan büyük acenteler.
                    Merkezi yönetim, raporlama ve entegrasyonlar gereklidir.
                </p>
            </div>

            <div class="who-card animate-on-scroll">
                <div class="who-icon">
                    <i class="bi bi-rocket-takeoff"></i>
                </div>
                <h3>Büyümeyi Hedefleyenler</h3>
                <p>
                    İşini büyütmek isteyen, yeni müşteriler kazanmak ve
                    mevcut müşterileri elde tutmak isteyen acenteler.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Comparison: With vs Without CRM -->
<section class="comparison-crm-section">
    <div class="container">
        <h2 class="section-title">CRM ile CRM Olmadan</h2>
        <p class="section-subtitle">
            Farkı görün, karar verin
        </p>

        <div class="comparison-container">
            <div class="comparison-cards">
                <!-- Without CRM -->
                <div class="comparison-card without-crm animate-on-scroll">
                    <div class="comparison-header">
                        <div class="comparison-icon">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <h3>CRM Olmadan</h3>
                    </div>
                    <div class="comparison-body">
                        <ul class="comparison-list">
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Excel tabloları ve kağıt dosyalar karmaşası</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Müşteri bilgilerine erişim zor ve yavaş</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Poliçe yenilemelerini manuel takip etme</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Unutulan taksitler ve geciken tahsilatlar</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Veri kaybı riski yüksek</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Raporlama manuel ve zaman alıcı</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Ekip koordinasyonu zayıf</span>
                            </li>
                            <li>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Müşteri hizmetleri yavaş</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- With CRM -->
                <div class="comparison-card with-crm animate-on-scroll">
                    <div class="comparison-header">
                        <div class="comparison-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h3>CRM ile</h3>
                    </div>
                    <div class="comparison-body">
                        <ul class="comparison-list">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Tüm veriler merkezi platformda, düzenli</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Müşteri bilgilerine anında erişim</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Otomatik yenileme hatırlatmaları</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Taksit takibi ve SMS hatırlatmaları</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Veriler güvende, otomatik yedekleme</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Anlık raporlar ve analizler</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Güçlü ekip koordinasyonu</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Hızlı ve profesyonel hizmet</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="crm-stats-section">
    <div class="stats-grid">
        <div class="stat-item">
            <h3>%91</h3>
            <p>CRM kullananlarda müşteri memnuniyeti artışı</p>
        </div>
        <div class="stat-item">
            <h3>%30</h3>
            <p>Satış verimliliğinde artış</p>
        </div>
        <div class="stat-item">
            <h3>%40</h3>
            <p>Poliçe yenileme oranında artış</p>
        </div>
        <div class="stat-item">
            <h3>2-3 Saat</h3>
            <p>Günlük zaman tasarrufu</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>CRM'in Gücünü Keşfedin</h2>
        <p>14 gün boyunca ücretsiz deneyin. Farkı kendiniz görün.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
            <a href="{{ route('modules') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-grid me-2"></i>Modülleri İnceleyin
            </a>
        </div>
    </div>
</section>

@endsection
