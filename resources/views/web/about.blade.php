@extends('web.layouts.app')

@section('title', 'Hakkımızda')
@section('meta_description', 'Sigorta Yönetim Sistemi hakkında bilgi edinin. Misyonumuz, vizyonumuz ve değerlerimiz.')

@section('content')

<!-- Hero Section -->
<section class="about-hero">
    <div class="about-hero-wrapper">
        <div class="about-hero-content">
            <div class="hero-badge">
                <i class="bi bi-building"></i>
                <span>2020'den Beri Sizinle</span>
            </div>
            <h1>Hakkımızda</h1>
            <p>
                Sigorta acentelerini dijital çağa taşımak ve işlerini kolaylaştırmak için
                modern teknolojiler ve kullanıcı odaklı tasarım anlayışıyla çalışıyoruz.
            </p>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="about-story-section">
    <div class="story-container">
        <div class="story-content">
            <div class="story-text">
                <div class="section-tag">Hikayemiz</div>
                <h2>Dijital Dönüşümün Öncüsü</h2>
                <p class="lead-text">
                    2020 yılında, sigorta acentelerinin günlük operasyonlarındaki zorlukları
                    gözlemleyerek yola çıktık.
                </p>
                <p>
                    Excel tabloları, kağıt dosyalar ve dağınık sistemler yerine, merkezi ve
                    modern bir çözüm sunmak istedik. Bugün, binlerce sigorta acentesine hizmet
                    veren, sürekli gelişen ve kullanıcı geri bildirimlerini önemseyen bir platform
                    haline geldik.
                </p>
                <p>
                    Amacımız sadece bir yazılım sunmak değil, acentelerin iş yapış şekillerini
                    dönüştürmek ve onlara rekabet avantajı sağlamak.
                </p>
                <div class="story-stats">
                    <div class="stat-box">
                        <h3></h3>
                        <p> </p>
                    </div>
                    <div class="stat-box">
                        <h3></h3>
                        <p> </p>
                    </div>
                    <div class="stat-box">
                        <h3></h3>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="story-image">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop"
                         alt="Ekibimiz"
                         onerror="this.src='https://via.placeholder.com/800x600/0c4a6e/ffffff?text=Our+Team'">
                    <div class="floating-badge">
                        <i class="bi bi-award"></i>
                        <div>
                            <strong>4+ Yıl</strong>
                            <span>Tecrübe</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="about-mission-vision-section">
    <div class="mv-container">
        <div class="section-header">
            <div class="section-tag">Misyon & Vizyon</div>
            <h2>Hedeflerimiz</h2>
            <p>Geleceği birlikte inşa ediyoruz</p>
        </div>

        <div class="mv-grid">
            <div class="mv-card mission-card">
                <div class="mv-icon-wrapper">
                    <div class="mv-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                </div>
                <h3>Misyonumuz</h3>
                <p>
                    Sigorta acentelerinin dijital dönüşümünü hızlandırarak, işlerini daha verimli,
                    daha karlı ve daha sürdürülebilir hale getirmek. Modern teknolojileri erişilebilir
                    kılarak, her ölçekteki acenteye güçlü araçlar sunmak.
                </p>
                <p>
                    Müşteri odaklı yaklaşımımızla, sürekli gelişen ve kullanıcı ihtiyaçlarına
                    cevap veren bir platform olmayı hedefliyoruz.
                </p>
            </div>

            <div class="mv-card vision-card">
                <div class="mv-icon-wrapper">
                    <div class="mv-icon">
                        <i class="bi bi-binoculars"></i>
                    </div>
                </div>
                <h3>Vizyonumuz</h3>
                <p>
                    Türkiye'nin en çok tercih edilen sigorta yönetim platformu olmak ve
                    sigorta sektöründe dijitalleşmenin öncüsü olmak. Yapay zeka ve
                    makine öğrenimi ile acentelere öngörü ve otomasyon sağlamak.
                </p>
                <p>
                    Gelecekte, sadece bir yazılım değil, acentelerin stratejik iş ortağı
                    ve büyüme katalizörü olmayı hayal ediyoruz.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="about-values-section">
    <div class="values-container">
        <div class="section-header">
            <div class="section-tag">Değerlerimiz</div>
            <h2>Bizi Biz Yapan Prensipler</h2>
            <p>Her gün bu değerlerle hareket ediyoruz</p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Odaklılık</h3>
                <p>
                    Her karar müşterilerimizin ihtiyaçları doğrultusunda alınır.
                    Geri bildirimler bizim için en değerli kaynaktır.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h3>Yenilikçilik</h3>
                <p>
                    Sürekli gelişmeye inanırız. Yeni teknolojileri takip eder ve
                    kullanıcı deneyimini iyileştirmek için çalışırız.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Güvenilirlik</h3>
                <p>
                    Verilerinizin güvenliği önceliğimizdir. %99.9 uptime garantisi ile
                    kesintisiz hizmet sunuyoruz.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-gem"></i>
                </div>
                <h3>Kalite</h3>
                <p>
                    Her özellik dikkatle tasarlanır ve test edilir. Kaliteden
                    ödün vermeden hızlı geliştirme yaparız.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-hand-thumbs-up"></i>
                </div>
                <h3>Şeffaflık</h3>
                <p>
                    Müşterilerimizle açık ve dürüst iletişim kurarız. Gizli ücret
                    veya belirsiz şartlar yoktur.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-heart"></i>
                </div>
                <h3>Tutku</h3>
                <p>
                    Yaptığımız işe tutkuyla bağlıyız. Her gün daha iyisini yapma
                    motivasyonu ile çalışırız.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
{{-- <section class="about-team-section">
    <div class="team-container">
        <div class="section-header">
            <div class="section-tag">Ekibimiz</div>
            <h2>Başarının Arkasındaki İsimler</h2>
            <p>Uzman ve deneyimli ekibimizle yanınızdayız</p>
        </div>

        <div class="team-grid">
            <div class="team-card">
                <div class="team-photo">
                    <img src="https://ui-avatars.com/api/?name=Ahmet+Yilmaz&size=200&background=0c4a6e&color=fff&bold=true"
                         alt="Ahmet Yılmaz">
                </div>
                <div class="team-info">
                    <h3>Ahmet Yılmaz</h3>
                    <p class="team-role">Kurucu & CEO</p>
                    <p class="team-bio">
                        15 yıllık yazılım deneyimi ile sigorta sektörünü dijitalleştiriyor.
                    </p>
                </div>
            </div>

            <div class="team-card">
                <div class="team-photo">
                    <img src="https://ui-avatars.com/api/?name=Mehmet+Kaya&size=200&background=06b6d4&color=fff&bold=true"
                         alt="Mehmet Kaya">
                </div>
                <div class="team-info">
                    <h3>Mehmet Kaya</h3>
                    <p class="team-role">CTO</p>
                    <p class="team-bio">
                        Teknoloji mimarisinden sorumlu, yenilikçi çözümler üretiyor.
                    </p>
                </div>
            </div>

            <div class="team-card">
                <div class="team-photo">
                    <img src="https://ui-avatars.com/api/?name=Ayse+Ozturk&size=200&background=3b82f6&color=fff&bold=true"
                         alt="Ayşe Öztürk">
                </div>
                <div class="team-info">
                    <h3>Ayşe Öztürk</h3>
                    <p class="team-role">Ürün Müdürü</p>
                    <p class="team-bio">
                        Kullanıcı deneyimi ve ürün stratejisinden sorumlu.
                    </p>
                </div>
            </div>

            <div class="team-card">
                <div class="team-photo">
                    <img src="https://ui-avatars.com/api/?name=Emre+Demir&size=200&background=8b5cf6&color=fff&bold=true"
                         alt="Emre Demir">
                </div>
                <div class="team-info">
                    <h3>Emre Demir</h3>
                    <p class="team-role">Müşteri Başarı Müdürü</p>
                    <p class="team-bio">
                        Müşteri memnuniyeti ve destek hizmetlerinden sorumlu.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Why Choose Section -->
<section class="about-why-section">
    <div class="why-container">
        <div class="section-header">
            <div class="section-tag light">Avantajlarımız</div>
            <h2>Neden Bizi Seçmelisiniz?</h2>
            <p>Rakiplerimizden bizi ayıran 6 önemli özellik</p>
        </div>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-number">01</div>
                <div class="why-icon">
                    <i class="bi bi-rocket-takeoff"></i>
                </div>
                <h3>Kolay Kurulum</h3>
                <p>
                    Dakikalar içinde hesabınızı oluşturun ve kullanmaya başlayın.
                    Karmaşık kurulum veya eğitim gerektirmez.
                </p>
            </div>

            <div class="why-card">
                <div class="why-number">02</div>
                <div class="why-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h3>Sürekli Güncelleme</h3>
                <p>
                    Her ay yeni özellikler ekliyoruz. Yazılımınız her zaman güncel
                    ve en son teknolojiye sahip.
                </p>
            </div>

            <div class="why-card">
                <div class="why-number">03</div>
                <div class="why-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <h3>Yerel Destek</h3>
                <p>
                    Türkçe destek ekibimiz, ihtiyacınız olduğunda yanınızda.
                    Hızlı ve etkili çözümler sunuyoruz.
                </p>
            </div>

            <div class="why-card">
                <div class="why-number">04</div>
                <div class="why-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <h3>Uygun Fiyat</h3>
                <p>
                    Kurumsal kalitede yazılımı, küçük acentelerin bütçesine uygun
                    fiyatlarla sunuyoruz.
                </p>
            </div>

            <div class="why-card">
                <div class="why-number">05</div>
                <div class="why-icon">
                    <i class="bi bi-lock"></i>
                </div>
                <h3>Veri Güvenliği</h3>
                <p>
                    Verileriniz şifreli sunucularda saklanır. Günlük yedekleme ile
                    hiçbir veri kaybı yaşamazsınız.
                </p>
            </div>

            <div class="why-card">
                <div class="why-number">06</div>
                <div class="why-icon">
                    <i class="bi bi-plugin"></i>
                </div>
                <h3>Entegrasyonlar</h3>
                <p>
                    SMS, e-posta ve WhatsApp entegrasyonları ile müşterilerinizle
                    kolay iletişim kurun.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Bize Katılın</h2>
        <p>14 gün boyunca tüm özellikleri ücretsiz deneyin. Kredi kartı gerektirmez.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-rocket-takeoff me-2"></i>Ücretsiz Deneyin
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-white btn-lg">
                <i class="bi bi-envelope me-2"></i>İletişime Geçin
            </a>
        </div>
    </div>
</section>

@endsection
