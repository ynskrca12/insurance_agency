@extends('web.layouts.app')

@section('title', 'Modüller')
@section('meta_description', 'Sigorta Yönetim Sistemi modülleri. Müşteri yönetimi, poliçe takibi, ödeme yönetimi ve daha fazlası.')

@section('content')

<!-- Hero Section -->
<section class="modules-hero">
    <div class="modules-hero-content">
        <h1>Güçlü Modüller</h1>
        <p>
            İhtiyacınız olan tüm araçlar bir arada. Her modül, sigorta acentelerinin
            iş süreçlerini kolaylaştırmak için özel olarak tasarlanmıştır.
        </p>
    </div>
</section>

<!-- Modules Grid -->
<section class="modules-main-section">
    <div class="modules-container">
        <div class="modules-professional-grid">
            @foreach($modules as $module)
            <div class="module-professional-card animate-on-scroll">
                <div class="module-card-header">
                    <div class="module-card-icon-wrapper">
                        <i class="bi bi-{{ $module['icon'] }} module-card-icon"></i>
                    </div>
                    <div class="module-card-title-area">
                        <h3>{{ $module['name'] }}</h3>
                        <span class="module-card-category">{{ strtoupper($module['slug']) }}</span>
                    </div>
                </div>

                <div class="module-card-body">
                    <p class="module-card-description">
                        {{ $module['description'] }}
                    </p>
                </div>

                <div class="module-card-features">
                    <h4>Temel Özellikler</h4>
                    <ul class="module-features-list">
                        @php
                            $features = [
                                'musteriler' => ['Hızlı Kayıt', 'Detaylı Profil', 'İstatistikler', 'Notlar'],
                                'policeler' => ['7 Poliçe Türü', 'Otomatik Hesap', 'Vade Takibi', 'Komisyon'],
                                'teklifler' => ['Çoklu Teklif', 'Online Paylaşım', 'Karşılaştırma', 'Dönüşüm'],
                                'yenilemeler' => ['Otomatik Takip', 'Önceliklendirme', 'Hatırlatmalar', 'İstatistik'],
                                'odemeler' => ['Taksit Planı', 'Tahsilat Takip', 'Gecikme Uyarı', 'Raporlama'],
                                'gorevler' => ['Görev Atama', 'Kanban Görünüm', 'Öncelik', 'Takip'],
                                'kampanyalar' => ['SMS/Email/WA', 'Hedef Kitle', 'Şablonlar', 'İstatistik'],
                                'raporlar' => ['Gelir-Gider', 'Komisyon', 'Müşteri Analiz', 'Performans'],
                            ];
                        @endphp
                        @foreach($features[$module['slug']] ?? [] as $feature)
                            <li><i class="bi bi-check-circle-fill"></i> {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="module-card-footer">
                    <a href="{{ route('modules.' . $module['slug']) }}" class="module-card-link">
                        Detaylı İncele
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Tüm Modülleri Deneyin</h2>
        <p>14 gün boyunca tüm modülleri ücretsiz kullanın. Kredi kartı bilgisi gerektirmez.</p>
        <div class="cta-buttons">
            <a href="{{ route('demo.form') }}" class="btn btn-white btn-lg">
                <i class="bi bi-play-circle me-2"></i>Ücretsiz Deneyin
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg" style="border-color: white; color: white;">
                <i class="bi bi-envelope me-2"></i>Bize Ulaşın
            </a>
        </div>
    </div>
</section>

@endsection
