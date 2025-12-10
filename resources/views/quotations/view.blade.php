<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teklif - {{ $quotation->quotation_number }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #212529;
            padding: 2rem 0;
        }

        .quotation-container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* Header */
        .quotation-header {
            background: #ffffff;
            border-bottom: 1px solid #e8e8e8;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .quotation-logo {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .quotation-logo i {
            font-size: 2rem;
            color: #495057;
        }

        .quotation-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .quotation-number {
            font-size: 0.9375rem;
            color: #6c757d;
            font-weight: 500;
        }

        /* Info Section */
        .info-section {
            padding: 2rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .info-item {
            text-align: center;
        }

        .info-icon {
            width: 48px;
            height: 48px;
            background: #f8f9fa;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .info-icon i {
            font-size: 1.5rem;
            color: #495057;
        }

        .info-label {
            font-size: 0.8125rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.125rem;
            color: #212529;
            font-weight: 600;
        }

        .validity-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .validity-badge.valid {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .validity-badge.expired {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* Details Box */
        .details-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem;
        }

        .details-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .details-content {
            font-size: 0.9375rem;
            color: #212529;
            line-height: 1.6;
        }

        .details-content strong {
            color: #495057;
            font-weight: 600;
        }

        /* Offers Section */
        .offers-section {
            padding: 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            font-size: 0.9375rem;
            color: #6c757d;
        }

        /* Company Card */
        .company-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.75rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .company-card:hover {
            border-color: #b0b0b0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .company-card.recommended {
            background: #fffbf0;
            border: 2px solid #ffc107;
        }

        .company-card.lowest {
            background: #f0f9ff;
            border: 2px solid #0d6efd;
        }

        .badge-tag {
            position: absolute;
            top: -12px;
            right: 1.5rem;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .badge-tag.recommended {
            background: #ffc107;
            color: #000000;
        }

        .badge-tag.lowest {
            background: #0d6efd;
            color: #ffffff;
        }

        .company-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .company-info h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .company-code {
            font-size: 0.8125rem;
            color: #6c757d;
            font-weight: 500;
        }

        .company-price {
            text-align: right;
        }

        .price-value {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
        }

        .price-label {
            font-size: 0.8125rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .company-coverage {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.25rem;
        }

        .coverage-title {
            font-size: 0.8125rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .coverage-text {
            font-size: 0.9375rem;
            color: #495057;
            line-height: 1.5;
            margin: 0;
        }

        .select-btn {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            background: #ffffff;
            color: #212529;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .select-btn:hover {
            background: #212529;
            border-color: #212529;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .company-card.recommended .select-btn:hover {
            background: #ffc107;
            border-color: #ffc107;
            color: #000000;
        }

        .company-card.lowest .select-btn:hover {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #ffffff;
        }

        /* Comparison Box */
        .comparison-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 2rem 0;
        }

        .comparison-title {
            font-size: 1rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .comparison-text {
            font-size: 0.9375rem;
            color: #212529;
            line-height: 1.6;
            margin: 0;
        }

        .comparison-highlight {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .comparison-highlight strong {
            color: #856404;
        }

        /* Contact Section */
        .contact-section {
            padding: 2.5rem 2rem;
            border-top: 1px solid #f0f0f0;
            text-align: center;
        }

        .contact-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.75rem;
        }

        .contact-subtitle {
            font-size: 0.9375rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .contact-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            background: #ffffff;
            color: #212529;
            font-size: 0.9375rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #212529;
        }

        .contact-btn.phone {
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .contact-btn.phone:hover {
            background: #0d6efd;
            color: #ffffff;
        }

        .contact-btn.whatsapp {
            border-color: #25d366;
            color: #25d366;
        }

        .contact-btn.whatsapp:hover {
            background: #25d366;
            color: #ffffff;
        }

        /* Footer */
        .quotation-footer {
            background: #fafafa;
            border-top: 1px solid #e8e8e8;
            padding: 1.5rem 2rem;
            text-align: center;
        }

        .footer-text {
            font-size: 0.8125rem;
            color: #6c757d;
            line-height: 1.6;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem 0;
            }

            .quotation-header {
                padding: 2rem 1.5rem;
            }

            .quotation-title {
                font-size: 1.5rem;
            }

            .info-section {
                padding: 1.5rem;
            }

            .info-grid {
                gap: 1.5rem;
            }

            .details-box,
            .comparison-box {
                margin: 1.5rem;
            }

            .offers-section {
                padding: 1.5rem;
            }

            .company-card {
                padding: 1.5rem;
            }

            .company-header {
                flex-direction: column;
                gap: 1rem;
            }

            .company-price {
                text-align: left;
            }

            .price-value {
                font-size: 1.75rem;
            }

            .contact-section {
                padding: 2rem 1.5rem;
            }

            .contact-buttons {
                flex-direction: column;
            }

            .contact-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .quotation-container {
                box-shadow: none;
                border: 1px solid #e0e0e0;
            }

            .select-btn,
            .contact-section {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="quotation-container">
        <!-- Header -->
        <div class="quotation-header">
            <div class="quotation-logo">
                <i class="bi bi-shield-check"></i>
            </div>
            <h1 class="quotation-title">Sigorta Teklifiniz</h1>
            <div class="quotation-number">Teklif No: {{ $quotation->quotation_number }}</div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-grid">
                <!-- Müşteri Bilgisi -->
                <div class="info-item">
                    <div class="info-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="info-label">Müşteri</div>
                    <div class="info-value">{{ $quotation->customer->name }}</div>
                    <div style="font-size: 0.875rem; color: #6c757d; margin-top: 0.25rem;">
                        {{ $quotation->customer->phone }}
                    </div>
                </div>

                <!-- Teklif Türü -->
                <div class="info-item">
                    <div class="info-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="info-label">Teklif Türü</div>
                    <div class="info-value">{{ ucfirst($quotation->quotation_type) }}</div>
                    <div style="font-size: 0.875rem; color: #6c757d; margin-top: 0.25rem;">
                        {{ $quotation->items->count() }} Şirket Teklifi
                    </div>
                </div>

                <!-- Geçerlilik -->
                <div class="info-item">
                    <div class="info-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="info-label">Geçerlilik Tarihi</div>
                    <div class="info-value">{{ $quotation->valid_until->format('d.m.Y') }}</div>
                    @if($quotation->isValid())
                        <span class="validity-badge valid">
                            <i class="bi bi-check-circle-fill"></i>
                            Geçerli
                        </span>
                    @else
                        <span class="validity-badge expired">
                            <i class="bi bi-x-circle-fill"></i>
                            Süresi Doldu
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Box -->
        @if($quotation->vehicle_info || $quotation->property_info)
        <div class="details-box">
            <div class="details-title">
                <i class="bi bi-info-circle"></i>
                <span>Teklif Detayları</span>
            </div>
            <div class="details-content">
                @if($quotation->vehicle_info)
                    @if(isset($quotation->vehicle_info['brand']) && $quotation->vehicle_info['brand'])
                        <strong>Araç:</strong>
                        {{ $quotation->vehicle_info['brand'] }}
                        {{ $quotation->vehicle_info['model'] ?? '' }}
                        {{ isset($quotation->vehicle_info['year']) ? '(' . $quotation->vehicle_info['year'] . ')' : '' }}
                        <br>
                    @endif
                    @if(isset($quotation->vehicle_info['plate']) && $quotation->vehicle_info['plate'])
                        <strong>Plaka:</strong> {{ $quotation->vehicle_info['plate'] }}
                    @endif
                @endif

                @if($quotation->property_info)
                    @if(isset($quotation->property_info['address']) && $quotation->property_info['address'])
                        <strong>Adres:</strong> {{ $quotation->property_info['address'] }}
                        <br>
                    @endif
                    @if(isset($quotation->property_info['area']) && $quotation->property_info['area'])
                        <strong>Alan:</strong> {{ $quotation->property_info['area'] }} m²
                    @endif
                    @if(isset($quotation->property_info['floor']) && $quotation->property_info['floor'])
                        <strong>Kat:</strong> {{ $quotation->property_info['floor'] }}
                    @endif
                @endif
            </div>
        </div>
        @endif

        <!-- Offers Section -->
        <div class="offers-section">
            <div class="section-header">
                <h2 class="section-title">Sigorta Şirketi Teklifleri</h2>
                <p class="section-subtitle">Size en uygun teklifi seçebilirsiniz</p>
            </div>

            @foreach($quotation->items->sortBy('premium_amount') as $item)
            <div class="company-card {{ $item->is_recommended ? 'recommended' : '' }} {{ $loop->first ? 'lowest' : '' }}">
                @if($item->is_recommended)
                    <div class="badge-tag recommended">
                        <i class="bi bi-star-fill"></i> ÖNERİLEN
                    </div>
                @elseif($loop->first)
                    <div class="badge-tag lowest">
                        <i class="bi bi-trophy-fill"></i> EN UYGUN
                    </div>
                @endif

                <div class="company-header">
                    <div class="company-info">
                        <h3>{{ $item->insuranceCompany->name }}</h3>
                        <div class="company-code">{{ $item->insuranceCompany->code }}</div>
                    </div>
                    <div class="company-price">
                        <div class="price-value">{{ number_format($item->premium_amount, 2) }} ₺</div>
                        <div class="price-label">Yıllık Prim</div>
                    </div>
                </div>

                @if($item->coverage_summary)
                <div class="company-coverage">
                    <div class="coverage-title">
                        <i class="bi bi-shield-check"></i>
                        Teminatlar
                    </div>
                    <p class="coverage-text">{{ $item->coverage_summary }}</p>
                </div>
                @endif

                <button type="button"
                        class="select-btn"
                        onclick="selectCompany('{{ addslashes($item->insuranceCompany->name) }}', {{ $item->premium_amount }})">
                    <i class="bi bi-check-circle"></i>
                    Bu Teklifi Seç
                </button>
            </div>
            @endforeach
        </div>

        <!-- Comparison Box -->
        @if($quotation->items->count() > 1)
        <div class="comparison-box">
            <div class="comparison-title">
                <i class="bi bi-graph-up"></i>
                Fiyat Karşılaştırması
            </div>
            @php
                $minPrice = $quotation->items->min('premium_amount');
                $maxPrice = $quotation->items->max('premium_amount');
                $difference = $maxPrice - $minPrice;
                $percentage = $maxPrice > 0 ? ($difference / $maxPrice) * 100 : 0;
            @endphp
            <p class="comparison-text">
                Teklifler arasında <strong>{{ number_format($difference, 2) }} ₺</strong> fark bulunmaktadır.
            </p>
            <div class="comparison-highlight">
                <strong>💰 {{ number_format($percentage, 1) }}% tasarruf</strong> fırsatı! En uygun teklifi seçerek önemli bir maliyet avantajı sağlayabilirsiniz.
            </div>
        </div>
        @endif

        <!-- Contact Section -->
        <div class="contact-section">
            <h3 class="contact-title">Yardıma mı ihtiyacınız var?</h3>
            <p class="contact-subtitle">Size en uygun teklifi seçmenizde uzman ekibimiz yardımcı olsun.</p>

            <div class="contact-buttons">
                <a href="tel:{{ $quotation->customer->phone }}" class="contact-btn phone">
                    <i class="bi bi-telephone-fill"></i>
                    Bizi Arayın
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quotation->customer->phone) }}?text={{ urlencode('Merhaba, ' . $quotation->quotation_number . ' numaralı teklif hakkında bilgi almak istiyorum.') }}"
                   target="_blank"
                   class="contact-btn whatsapp">
                    <i class="bi bi-whatsapp"></i>
                    WhatsApp ile İletişim
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="quotation-footer">
            <p class="footer-text">
                Bu teklif {{ $quotation->valid_until->format('d.m.Y') }} tarihine kadar geçerlidir.
                <br>
                Teklif Numarası: {{ $quotation->quotation_number }} • Oluşturulma: {{ $quotation->created_at->format('d.m.Y') }}
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function selectCompany(companyName, amount) {
        const quotationNumber = "{{ $quotation->quotation_number }}";
        const phone = "{{ $quotation->customer->phone }}";
        const cleanPhone = phone.replace(/[^0-9]/g, '');

        const message = `Merhaba,\n\n${companyName} şirketinin ${amount.toFixed(2)} ₺ tutarındaki teklifini seçmek istiyorum.\n\nTeklif No: ${quotationNumber}`;

        // Modern dialog
        if (confirm(`✓ ${companyName} şirketinin teklifini seçtiniz.\n\nNasıl iletişime geçmek istersiniz?`)) {
            const choice = confirm('WhatsApp ile devam etmek için "Tamam"\nTelefon ile aramak için "İptal" seçin.');

            if (choice) {
                // WhatsApp
                const whatsappUrl = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
            } else {
                // Telefon
                window.location.href = `tel:${phone}`;
            }
        }
    }

    // View tracking (sayfa görüntüleme)
    document.addEventListener('DOMContentLoaded', function() {
        // Görüntüleme kaydı için AJAX isteği (opsiyonel)
        console.log('Teklif görüntülendi: {{ $quotation->quotation_number }}');
    });
    </script>
</body>
</html>
