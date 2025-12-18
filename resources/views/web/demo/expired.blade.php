@extends('web.layouts.app')

@section('title', 'Demo Süreniz Doldu')
@section('meta_description', 'Demo süreniz sona erdi. Paketi seçerek kullanmaya devam edebilirsiniz.')

@section('content')

<!-- Hero Section -->
<section class="demo-expired-hero">
    <div class="demo-expired-icon">
        <i class="bi bi-clock-history"></i>
    </div>
    <h1>Demo Süreniz Doldu</h1>
    <p>14 günlük deneme süreniz sona erdi. Umarız sistemimizi beğenmişsinizdir!</p>
</section>

<!-- Stats Section -->
<section class="demo-stats-section">
    <div class="container">
        <h2 class="section-title">Demo Süresince Yaptıklarınız</h2>
        <p class="section-subtitle">
            14 gün boyunca neler başardınız?
        </p>

        <div class="demo-stats-grid">
            <div class="demo-stat-card animate-on-scroll">
                <div class="demo-stat-value">{{ $stats['customers'] ?? 0 }}</div>
                <div class="demo-stat-label">Müşteri Eklendi</div>
            </div>

            <div class="demo-stat-card animate-on-scroll">
                <div class="demo-stat-value">{{ $stats['policies'] ?? 0 }}</div>
                <div class="demo-stat-label">Poliçe Oluşturuldu</div>
            </div>

            <div class="demo-stat-card animate-on-scroll">
                <div class="demo-stat-value">{{ number_format($stats['payments'] ?? 0, 0, ',', '.') }}₺</div>
                <div class="demo-stat-label">Toplam Ödeme</div>
            </div>

            <div class="demo-stat-card animate-on-scroll">
                <div class="demo-stat-value">{{ $stats['days_used'] ?? 14 }}</div>
                <div class="demo-stat-label">Gün Kullanıldı</div>
            </div>
        </div>
    </div>
</section>

<!-- What Happens Section -->
<section class="demo-features-section">
    <div class="container">
        <h2 class="section-title">Şimdi Ne Olacak?</h2>
        <p class="section-subtitle">
            Demo verileriniz 30 gün boyunca saklanır
        </p>

        <div class="demo-features-grid">
            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h3>Verileriniz Güvende</h3>
                <p>
                    Demo süresince oluşturduğunuz tüm veriler 30 gün boyunca saklanır.
                    Bu süre içinde paket satın alırsanız verilerinize erişmeye devam edebilirsiniz.
                </p>
            </div>

            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon" style="background: linear-gradient(135deg, #fff3e0, #ffe0b2);">
                    <i class="bi bi-credit-card"></i>
                </div>
                <h3>Paket Seçin</h3>
                <p>
                    Size uygun paketi seçin ve kullanmaya devam edin. Tüm demo verileriniz
                    otomatik olarak yeni hesabınıza aktarılır.
                </p>
            </div>

            <div class="demo-feature-card animate-on-scroll">
                <div class="demo-feature-icon" style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9);">
                    <i class="bi bi-headset"></i>
                </div>
                <h3>Destek Alın</h3>
                <p>
                    Sorularınız mı var? Ekibimiz size yardımcı olmak için hazır.
                    Bize ulaşın, en iyi paketi bulmanıza yardımcı olalım.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section style="background: #ffffff; padding: 5rem 2rem;">
    <div class="container">
        <h2 class="section-title">Kullanmaya Devam Edin</h2>
        <p class="section-subtitle">
            Size uygun paketi seçin ve tüm özelliklere erişin
        </p>

        <div class="pricing-cards-wrapper" style="max-width: 1200px; margin: 3rem auto 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">

            <!-- Temel Paket -->
            <div class="pricing-package-card animate-on-scroll" style="background: #ffffff; border: 2px solid #e8eaed; border-radius: 20px; padding: 0; overflow: hidden;">
                <div class="package-header" style="padding: 2rem; text-align: center;">
                    <div class="package-icon" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; color: #1a73e8;">
                        <i class="bi bi-star"></i>
                    </div>
                    <h3 class="package-name" style="font-size: 1.5rem; font-weight: 700; color: #202124; margin-bottom: 0.5rem;">Temel</h3>
                    <p style="color: #5f6368; font-size: 0.9375rem;">Küçük acenteler için</p>
                    <div style="margin: 1.5rem 0;">
                        <span style="font-size: 2.5rem; font-weight: 800; color: #1a73e8;">999₺</span>
                        <span style="font-size: 1rem; color: #5f6368;">/ay</span>
                    </div>
                </div>
                <div style="padding: 0 2rem 2rem;">
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; padding: 1rem; border-radius: 12px; font-weight: 600;">
                        Bu Paketi Seç
                    </a>
                </div>
            </div>

            <!-- Profesyonel Paket - Featured -->
            <div class="pricing-package-card featured animate-on-scroll" style="background: #ffffff; border: 3px solid #1a73e8; border-radius: 20px; padding: 0; overflow: hidden; position: relative; transform: scale(1.05);">
                <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #1a73e8, #34a853); color: #ffffff; padding: 0.375rem 1.5rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                    ÖNERİLEN
                </div>
                <div class="package-header" style="padding: 2.5rem 2rem 2rem; text-align: center;">
                    <div class="package-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #1a73e8, #34a853); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2.5rem; color: #ffffff;">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h3 class="package-name" style="font-size: 1.75rem; font-weight: 700; color: #202124; margin-bottom: 0.5rem;">Profesyonel</h3>
                    <p style="color: #5f6368; font-size: 0.9375rem;">En popüler paket</p>
                    <div style="margin: 1.5rem 0;">
                        <span style="font-size: 3rem; font-weight: 800; background: linear-gradient(135deg, #1a73e8, #34a853); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">1.999₺</span>
                        <span style="font-size: 1rem; color: #5f6368;">/ay</span>
                    </div>
                </div>
                <div style="padding: 0 2rem 2.5rem;">
                    <a href="{{ route('contact') }}" class="btn btn-primary" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; padding: 1.125rem; border-radius: 12px; font-weight: 700; background: linear-gradient(135deg, #1a73e8, #34a853); color: #ffffff; border: none;">
                        Bu Paketi Seç
                    </a>
                </div>
            </div>

            <!-- Kurumsal Paket -->
            <div class="pricing-package-card animate-on-scroll" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border: 2px solid #dadce0; border-radius: 20px; padding: 0; overflow: hidden;">
                <div class="package-header" style="padding: 2rem; text-align: center;">
                    <div class="package-icon" style="width: 70px; height: 70px; background: linear-gradient(135deg, #e0e0e0, #bdbdbd); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; color: #5f6368;">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3 class="package-name" style="font-size: 1.5rem; font-weight: 700; color: #202124; margin-bottom: 0.5rem;">Kurumsal</h3>
                    <p style="color: #5f6368; font-size: 0.9375rem;">Büyük kuruluşlar için</p>
                    <div style="margin: 1.5rem 0;">
                        <span style="font-size: 2rem; font-weight: 700; color: #5f6368;">Özel Fiyat</span>
                    </div>
                </div>
                <div style="padding: 0 2rem 2rem;">
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; padding: 1rem; border-radius: 12px; font-weight: 600;">
                        Bize Ulaşın
                    </a>
                </div>
            </div>

        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('pricing') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-grid me-2"></i>Tüm Paketleri Görüntüle
            </a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="contact-faq-section" style="background: linear-gradient(to bottom, #fafbfc, #ffffff); padding: 5rem 2rem;">
    <div class="container">
        <h2 class="section-title">Sıkça Sorulan Sorular</h2>
        <p class="section-subtitle">
            Demo sonrası hakkında merak edilenler
        </p>

        <div class="contact-faq-wrapper" style="max-width: 900px; margin: 3rem auto 0;">
            <div class="faq-item" style="background: #ffffff; border: 2px solid #e8eaed; border-radius: 16px; margin-bottom: 1.5rem; overflow: hidden;">
                <button class="faq-question-button" onclick="toggleFAQ(this)" style="width: 100%; padding: 1.5rem 2rem; background: none; border: none; text-align: left; font-size: 1.125rem; font-weight: 600; color: #202124; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>Verilerim ne oldu?</span>
                    <span class="faq-icon-wrapper" style="width: 32px; height: 32px; background: #f1f3f4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                    <div class="faq-answer-content" style="padding: 0 2rem 1.5rem; color: #5f6368; line-height: 1.7;">
                        Demo süresince oluşturduğunuz tüm veriler 30 gün boyunca güvenli bir şekilde saklanır.
                        Bu süre içinde paket satın alırsanız, tüm verileriniz otomatik olarak yeni hesabınıza
                        aktarılır ve kaldığınız yerden devam edebilirsiniz.
                    </div>
                </div>
            </div>

            <div class="faq-item" style="background: #ffffff; border: 2px solid #e8eaed; border-radius: 16px; margin-bottom: 1.5rem; overflow: hidden;">
                <button class="faq-question-button" onclick="toggleFAQ(this)" style="width: 100%; padding: 1.5rem 2rem; background: none; border: none; text-align: left; font-size: 1.125rem; font-weight: 600; color: #202124; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>Hangi paketi seçmeliyim?</span>
                    <span class="faq-icon-wrapper" style="width: 32px; height: 32px; background: #f1f3f4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                    <div class="faq-answer-content" style="padding: 0 2rem 1.5rem; color: #5f6368; line-height: 1.7;">
                        Müşteri sayınıza ve ihtiyaçlarınıza göre paket seçebilirsiniz. Küçük acenteler için
                        Temel paket yeterlidir. Orta ve büyük acenteler için Profesyonel paket önerilir.
                        Şubeleriniz varsa veya özel entegrasyon ihtiyacınız varsa Kurumsal paket en iyisidir.
                    </div>
                </div>
            </div>

            <div class="faq-item" style="background: #ffffff; border: 2px solid #e8eaed; border-radius: 16px; margin-bottom: 1.5rem; overflow: hidden;">
                <button class="faq-question-button" onclick="toggleFAQ(this)" style="width: 100%; padding: 1.5rem 2rem; background: none; border: none; text-align: left; font-size: 1.125rem; font-weight: 600; color: #202124; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>Paket değişikliği yapabilir miyim?</span>
                    <span class="faq-icon-wrapper" style="width: 32px; height: 32px; background: #f1f3f4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                    <div class="faq-answer-content" style="padding: 0 2rem 1.5rem; color: #5f6368; line-height: 1.7;">
                        Evet, istediğiniz zaman paket yükseltme veya düşürme yapabilirsiniz.
                        Paket değişikliklerinde kalan süre için ödediğiniz tutar yeni pakete devredilir.
                        Verileriniz korunur ve kesinti yaşamazsınız.
                    </div>
                </div>
            </div>

            <div class="faq-item" style="background: #ffffff; border: 2px solid #e8eaed; border-radius: 16px; margin-bottom: 1.5rem; overflow: hidden;">
                <button class="faq-question-button" onclick="toggleFAQ(this)" style="width: 100%; padding: 1.5rem 2rem; background: none; border: none; text-align: left; font-size: 1.125rem; font-weight: 600; color: #202124; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <span>Tekrar demo alabilir miyim?</span>
                    <span class="faq-icon-wrapper" style="width: 32px; height: 32px; background: #f1f3f4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </button>
                <div class="faq-answer-wrapper" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                    <div class="faq-answer-content" style="padding: 0 2rem 1.5rem; color: #5f6368; line-height: 1.7;">
                        Hayır, her e-posta adresi için sadece 1 demo hakkı bulunmaktadır.
                        Ancak daha fazla zaman ihtiyacınız varsa veya özel bir demo talebiniz varsa
                        bizimle iletişime geçin, size yardımcı olalım.
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
        <p>Size uygun paketi seçin veya bize ulaşın, size yardımcı olalım.</p>
        <div class="cta-buttons">
            <a href="{{ route('pricing') }}" class="btn btn-white btn-lg">
                <i class="bi bi-tag me-2"></i>Paketleri Görüntüle
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-envelope me-2"></i>Bize Ulaşın
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
        const answerWrapper = item.querySelector('.faq-answer-wrapper');
        if (answerWrapper) {
            answerWrapper.style.maxHeight = '0';
        }
        const icon = item.querySelector('.faq-icon-wrapper');
        if (icon) {
            icon.style.background = '#f1f3f4';
            icon.style.color = '#202124';
            icon.style.transform = 'rotate(0deg)';
        }
    });

    // Open clicked FAQ if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
        const answerWrapper = faqItem.querySelector('.faq-answer-wrapper');
        if (answerWrapper) {
            answerWrapper.style.maxHeight = '500px';
        }
        const icon = faqItem.querySelector('.faq-icon-wrapper');
        if (icon) {
            icon.style.background = '#1a73e8';
            icon.style.color = '#ffffff';
            icon.style.transform = 'rotate(180deg)';
        }
    }
}
</script>
@endpush
