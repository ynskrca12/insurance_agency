@extends('web.layouts.app')

@section('title', 'İletişim')
@section('meta_description', 'Bizimle iletişime geçin. Sorularınızı cevaplayalım, size yardımcı olalım.')

@section('content')

<!-- Hero Section -->
<section class="contact-hero">
    <div class="contact-hero-content">
        <h1>İletişime Geçin</h1>
        <p>
            Sorularınız mı var? Size yardımcı olmaktan mutluluk duyarız.
            Formu doldurun veya doğrudan bize ulaşın.
        </p>
    </div>
</section>

<!-- Contact Main Section -->
<section class="contact-main-section">
    <div class="contact-container px-4 py-5 px-md-5 py-md-5">

        <div class="row">
            <div class="col-md-6 mb-2">
                <!-- Contact Form -->
                <div class="contact-form-wrapper animate-on-scroll">
                    <h2>Mesaj Gönderin</h2>
                    <p class="contact-form-description">
                        Formu doldurun, en kısa sürede size dönüş yapalım.
                    </p>

                    @if(session('success'))
                    <div class="alert-message success">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert-message error">
                        <i class="bi bi-x-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}" class="contact-form">
                        @csrf

                        <div class="form-group">
                            <label for="full_name" class="form-label">
                                Ad Soyad <span class="required-mark">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                class="form-input @error('full_name') is-invalid @enderror"
                                placeholder="Adınız ve soyadınız"
                                value="{{ old('full_name') }}"
                                required
                            >
                            @error('full_name')
                                <span class="form-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                E-posta <span class="required-mark">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input @error('email') is-invalid @enderror"
                                placeholder="ornek@email.com"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <span class="form-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Telefon</label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                class="form-input @error('phone') is-invalid @enderror"
                                placeholder="05XX XXX XX XX"
                                value="{{ old('phone') }}"
                            >
                            @error('phone')
                                <span class="form-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subject" class="form-label">Konu</label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                class="form-input @error('subject') is-invalid @enderror"
                                placeholder="Mesajınızın konusu"
                                value="{{ old('subject') }}"
                            >
                            @error('subject')
                                <span class="form-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">
                                Mesajınız <span class="required-mark">*</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                class="form-textarea @error('message') is-invalid @enderror"
                                placeholder="Bize ne söylemek istersiniz?"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="form-submit-button">
                            <i class="bi bi-send"></i>
                            Mesajı Gönder
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Contact Info -->
                <div class="contact-info-wrapper">

                    <!-- Contact Details -->
                    <div class="contact-info-card animate-on-scroll">
                        <h3 class="contact-info-card-title">
                            <i class="bi bi-geo-alt contact-info-card-icon"></i>
                            İletişim Bilgileri
                        </h3>

                        <div class="contact-info-item">
                            <div class="contact-info-item-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-info-item-content">
                                <span class="contact-info-item-label">Telefon</span>
                                <div class="contact-info-item-value">
                                    <a href="tel:+902121234567">+90 (534) 234 64 81</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-item-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-info-item-content">
                                <span class="contact-info-item-label">E-posta</span>
                                <div class="contact-info-item-value">
                                    <a href="mailto:info@sigortayonetimsistemi.com">info@sigortayonetimsistemi.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-item-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="contact-info-item-content">
                                <span class="contact-info-item-label">Çalışma Saatleri</span>
                                <div class="contact-info-item-value">
                                    08:00 - 23:00
                                </div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-item-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-info-item-content">
                                <span class="contact-info-item-label">Adres</span>
                                <div class="contact-info-item-value">
                                    Pendik, İstanbul
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="contact-info-card animate-on-scroll">
                        <h3 class="contact-info-card-title">
                            <i class="bi bi-share contact-info-card-icon"></i>
                            Sosyal Medya
                        </h3>
                        <p class="social-description">
                            Bizi sosyal medyada takip edin, haberdar olun.
                        </p>
                        <div class="social-links-grid">
                            <a href="#" class="social-link-item" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link-item" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="social-link-item" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- FAQ Section -->
<section class="contact-faq-section">
    <div class="container">
        <h2 class="section-title">Sıkça Sorulan Sorular</h2>
        <p class="section-subtitle">
            Merak ettikleriniz burada olabilir
        </p>

        <div class="contact-faq-wrapper">
            <div class="faq-item">
                <button class="faq-question-button" onclick="toggleFAQ(this)">
                    <span>Ne kadar sürede dönüş yapıyorsunuz?</span>
                    <span class="faq-icon-wrapper">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper">
                    <div class="faq-answer-content">
                        Mesajlarınıza hafta içi 24 saat içinde, hafta sonu ise 48 saat içinde
                        dönüş yapmaya özen gösteriyoruz. Acil durumlar için telefon ile
                        iletişime geçebilirsiniz.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question-button" onclick="toggleFAQ(this)">
                    <span>Demo talep etmek için ne yapmalıyım?</span>
                    <span class="faq-icon-wrapper">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper">
                    <div class="faq-answer-content">
                        Demo talebi için <a href="{{ route('demo.form') }}">demo kayıt formu</a>nu
                        doldurmanız yeterli. Hesabınız otomatik oluşturulur ve 14 gün boyunca
                        ücretsiz kullanabilirsiniz.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question-button" onclick="toggleFAQ(this)">
                    <span>Teknik destek nasıl alırım?</span>
                    <span class="faq-icon-wrapper">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper">
                    <div class="faq-answer-content">
                        Tüm paketlerimizde e-posta destek mevcuttur. Profesyonel ve Kurumsal
                        paketlerde öncelikli destek ve telefon desteği sunuyoruz. Panel içindeki
                        destek butonu ile de bizimle iletişime geçebilirsiniz.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question-button" onclick="toggleFAQ(this)">
                    <span>Özel eğitim alabiliyor muyuz?</span>
                    <span class="faq-icon-wrapper">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper">
                    <div class="faq-answer-content">
                        Kurumsal paket kullanan müşterilerimize özel eğitim ve onboarding
                        hizmeti sunuyoruz. Diğer paketler için ek ücret karşılığında
                        eğitim hizmeti verebiliriz. Detaylı bilgi için bizimle iletişime geçin.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Hemen Başlayın</h2>
        <p>Sorunuz mu var? Demo talebinde bulunun, size yardımcı olalım.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Demo
            </a>
            <a href="tel:+902121234567" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-telephone me-2"></i>Bizi Arayın
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// FAQ Toggle Function
function toggleFAQ(button) {
    const faqItem = button.parentElement;
    const isActive = faqItem.classList.contains('active');

    // Close all FAQs
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });

    // Open clicked FAQ if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-message');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>
@endpush
