@extends('web.layouts.app')

@section('title', 'Ücretsiz Demo - 14 Gün Deneyin')
@section('meta_description', '14 gün boyunca tüm özellikleri ücretsiz deneyin. Kredi kartı gerektirmez, taahhüt yok.')

@section('content')

<!-- Hero Section -->
<section class="demo-page-hero">
    <div class="demo-hero-content">
        <h1>14 Gün Ücretsiz Deneyin</h1>
        <p>
            Kredi kartı bilgisi gerektirmez. Taahhüt yok.
            Tüm özelliklere anında erişin.
        </p>

        <div class="demo-benefits-bar">
            <div class="demo-benefit-item">
                <div class="demo-benefit-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <span class="demo-benefit-text">Kredi Kartı Yok</span>
            </div>
            <div class="demo-benefit-item">
                <div class="demo-benefit-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <span class="demo-benefit-text">14 Gün Deneme</span>
            </div>
            <div class="demo-benefit-item">
                <div class="demo-benefit-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <span class="demo-benefit-text">Tam Erişim</span>
            </div>
        </div>
    </div>
</section>

<!-- Demo Form Section -->
<section class="demo-form-section">
    <div class="demo-form-container">
        <div class="demo-form-card">
            <div class="demo-form-header">
                <h2>Demo Hesabı Oluşturun</h2>
                <p>Formu doldurun ve hemen başlayın</p>
            </div>

            @if(session('success'))
            <div class="alert-message success" style="margin-bottom: 2rem;">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert-message error" style="margin-bottom: 2rem;">
                <i class="bi bi-x-circle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('demo.register') }}" class="demo-form">
                @csrf

                <div class="demo-form-group">
                    <label for="company_name" class="demo-form-label">
                        Firma Adı <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        id="company_name"
                        name="company_name"
                        class="demo-form-input @error('company_name') is-invalid @enderror"
                        placeholder="Örnek: Acme Sigorta"
                        value="{{ old('company_name') }}"
                        required
                    >
                    @error('company_name')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="demo-form-group">
                    <label for="full_name" class="demo-form-label">
                        Ad Soyad <span class="required-star">*</span>
                    </label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        class="demo-form-input @error('full_name') is-invalid @enderror"
                        placeholder="Adınız ve soyadınız"
                        value="{{ old('full_name') }}"
                        required
                    >
                    @error('full_name')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="demo-form-group">
                    <label for="email" class="demo-form-label">
                        E-posta <span class="required-star">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="demo-form-input @error('email') is-invalid @enderror"
                        placeholder="ornek@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="demo-form-group">
                    <label for="phone" class="demo-form-label">
                        Telefon <span class="required-star">*</span>
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="demo-form-input @error('phone') is-invalid @enderror"
                        placeholder="05XX XXX XX XX"
                        value="{{ old('phone') }}"
                        required
                    >
                    @error('phone')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ŞİFRE ALANLARI - YENİ -->
                <div class="demo-form-group">
                    <label for="password" class="demo-form-label">
                        Şifre <span class="required-star">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="demo-form-input @error('password') is-invalid @enderror"
                            placeholder="En az 8 karakter"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                    <small style="color: #80868b; font-size: 0.875rem; display: block; margin-top: 0.375rem;">
                        En az 8 karakter olmalıdır
                    </small>
                </div>

                <div class="demo-form-group">
                    <label for="password_confirmation" class="demo-form-label">
                        Şifre Tekrar <span class="required-star">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="demo-form-input @error('password_confirmation') is-invalid @enderror"
                            placeholder="Şifrenizi tekrar girin"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- ŞİFRE ALANLARI SON -->

                <div class="demo-form-group">
                    <label for="city" class="demo-form-label">Şehir</label>
                    <input
                        type="text"
                        id="city"
                        name="city"
                        class="demo-form-input @error('city') is-invalid @enderror"
                        placeholder="İstanbul"
                        value="{{ old('city') }}"
                    >
                    @error('city')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="demo-form-group">
                    <label for="message" class="demo-form-label">Not (İsteğe Bağlı)</label>
                    <textarea
                        id="message"
                        name="message"
                        class="demo-form-textarea @error('message') is-invalid @enderror"
                        placeholder="Özel bir ihtiyacınız varsa belirtebilirsiniz"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <span class="demo-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="demo-form-checkbox-wrapper">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        class="demo-form-checkbox"
                        required
                    >
                    <label for="terms" class="demo-form-checkbox-label">
                        <a href="#">Kullanım Koşulları</a>'nı ve
                        <a href="#">Gizlilik Politikası</a>'nı okudum, kabul ediyorum.
                        <span class="required-star">*</span>
                    </label>
                </div>
                @error('terms')
                    <span class="demo-form-error" style="margin-top: -1rem; margin-bottom: 1rem; display: block;">{{ $message }}</span>
                @enderror

                <button type="submit" class="demo-form-submit">
                    <i class="bi bi-rocket-takeoff"></i>
                    Demo Hesabı Oluştur
                </button>

                <p style="text-align: center; color: #80868b; font-size: 0.875rem; margin-top: 1.5rem;">
                    Hesap oluşturduğunuzda giriş bilgileriniz e-posta ile gönderilecektir.
                </p>
            </form>

        </div>
    </div>
</section>

<!-- Demo Features -->
<section class="demo-features-section">
    <div class="container">
        <h2 class="section-title">Demo Süresince Neler Yapabilirsiniz?</h2>
        <p class="section-subtitle">
            14 gün boyunca tüm özelliklere tam erişim
        </p>

        <div class="demo-features-grid">
            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>Müşteri Ekleyin</h3>
                <p>Sınırsız müşteri kaydı oluşturun ve yönetin</p>
            </div>

            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Poliçe Oluşturun</h3>
                <p>7 farklı poliçe türünü deneyin</p>
            </div>

            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3>Teklif Hazırlayın</h3>
                <p>Profesyonel teklifler oluşturun</p>
            </div>

            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3>Raporları Görün</h3>
                <p>Detaylı raporlar ve analizler</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Sorularınız mı var?</h2>
        <p>Bize ulaşın, size yardımcı olalım.</p>
        <div class="cta-buttons">
            <a href="{{ route('contact') }}" class="btn btn-white btn-lg">
                <i class="bi bi-envelope me-2"></i>İletişime Geçin
            </a>
            <a href="{{ route('pricing') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-tag me-2"></i>Paketleri İnceleyin
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endpush
