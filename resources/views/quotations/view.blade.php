<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigorta Teklifi - {{ $quotation->quotation_number }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .document-container { box-shadow: none !important; max-width: 100% !important; }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f7fa;
            color: #1e293b;
            line-height: 1.6;
            padding: 2rem 1rem;
        }

        .document-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header - Logo & Company Info */
        .document-header {
            background: #ffffff;
            border-bottom: 3px solid #1e40af;
            padding: 2rem;
        }

        .company-logo-section {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .company-logo {
            max-width: 200px;
            height: auto;
        }

        .company-info {
            text-align: right;
            font-size: 0.875rem;
            color: #64748b;
        }

        .company-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .document-title {
            text-align: center;
            padding: 1.5rem 0;
        }

        .document-title h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .quotation-meta {
            display: flex;
            justify-content: center;
            gap: 2rem;
            font-size: 0.9375rem;
            color: #64748b;
        }

        .quotation-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Validity Banner */
        .validity-banner {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            padding: 1rem 1.5rem;
            margin: 0 2rem 2rem 2rem;
            border-radius: 4px;
        }

        .validity-banner.expired {
            background: #fef2f2;
            border-left-color: #ef4444;
        }

        .validity-banner .banner-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .validity-banner i {
            font-size: 1.5rem;
            color: #22c55e;
        }

        .validity-banner.expired i {
            color: #ef4444;
        }

        .validity-text {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #166534;
        }

        .validity-banner.expired .validity-text {
            color: #991b1b;
        }

        /* Content Sections */
        .content-section {
            padding: 0 2rem 2rem 2rem;
        }

        .section-header {
            background: #f8fafc;
            padding: 0.875rem 1.25rem;
            margin: 0 -2rem 1.5rem -2rem;
            border-left: 4px solid #1e40af;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .section-title i {
            color: #1e40af;
            font-size: 1.25rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.375rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        /* Company Offers Table */
        .offers-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 1.5rem;
        }

        .offers-table thead {
            background: #1e40af;
            color: white;
        }

        .offers-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9375rem;
            border-bottom: 2px solid #1e3a8a;
        }

        .offers-table th:first-child {
            border-radius: 6px 0 0 0;
        }

        .offers-table th:last-child {
            border-radius: 0 6px 0 0;
            text-align: right;
        }

        .offers-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s ease;
        }

        .offers-table tbody tr:hover {
            background: #f8fafc;
        }

        .offers-table tbody tr.best-offer {
            background: #f0fdf4;
        }

        .offers-table tbody tr.recommended {
            background: #fef9e7;
        }

        .offers-table td {
            padding: 1rem;
            font-size: 0.9375rem;
        }

        .company-name-cell {
            font-weight: 600;
            color: #1e293b;
        }

        .price-cell {
            text-align: right;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e40af;
        }

        .badge-offer {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.625rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-best {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-recommended {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde047;
        }

        /* Summary Box */
        .summary-box {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px dashed #cbd5e1;
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-top: 1rem;
            margin-top: 0.5rem;
            border-top: 2px solid #cbd5e1;
        }

        .summary-label {
            font-size: 0.9375rem;
            color: #64748b;
            font-weight: 500;
        }

        .summary-value {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #1e293b;
        }

        .summary-row:last-child .summary-label {
            font-size: 1.125rem;
            color: #1e293b;
        }

        .summary-row:last-child .summary-value {
            font-size: 1.5rem;
            color: #1e40af;
        }

        /* Customer Response Section */
        .response-section {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 2rem;
            margin: 2rem 2rem;
        }

        .response-section .section-title {
            justify-content: center;
            margin-bottom: 1rem;
        }

        .response-intro {
            text-align: center;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .response-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-response {
            padding: 1rem 1.5rem;
            border: 2px solid;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
        }

        .btn-approve {
            background: #22c55e;
            border-color: #22c55e;
            color: white;
        }

        .btn-approve:hover {
            background: #16a34a;
            border-color: #16a34a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .btn-reject {
            background: white;
            border-color: #cbd5e1;
            color: #64748b;
        }

        .btn-reject:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        /* Alert Messages */
        .alert-custom {
            border-radius: 6px;
            border: 1px solid;
            padding: 1.25rem;
            margin: 0 2rem 2rem 2rem;
        }

        .alert-success-custom {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }

        .alert-danger-custom {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .alert-custom .alert-title {
            font-weight: 700;
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Footer */
        .document-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 2rem;
            margin-top: 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .footer-section h6 {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .footer-section p {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.375rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.8125rem;
            color: #94a3b8;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            color: #64748b;
            font-size: 0.8125rem;
        }

        /* Action Buttons */
        .action-bar {
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            color: #64748b;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-action:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #1e293b;
        }

        .btn-action.btn-primary {
            background: #1e40af;
            border-color: #1e40af;
            color: white;
        }

        .btn-action.btn-primary:hover {
            background: #1e3a8a;
            border-color: #1e3a8a;
        }

        /* Coverage Details */
        .coverage-item {
            padding: 0.75rem;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
            }

            .document-header,
            .content-section,
            .response-section,
            .alert-custom {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .section-header {
                margin-left: -1rem;
                margin-right: -1rem;
            }

            .company-logo-section {
                flex-direction: column;
                gap: 1rem;
            }

            .company-info {
                text-align: left;
            }

            .quotation-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .offers-table {
                font-size: 0.875rem;
            }

            .offers-table th,
            .offers-table td {
                padding: 0.75rem 0.5rem;
            }

            .response-buttons {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-wrap: wrap;
            }
        }

        .notes-section {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }

        .notes-section h6 {
            font-size: 0.875rem;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .notes-section p {
            font-size: 0.875rem;
            color: #78350f;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="document-container">
        <!-- Header -->
        <div class="document-header">
            <div class="company-logo-section">
                <div>
                    <div class="company-name">{{ $agency_info['company_name'] }}</div>
                    <p style="margin: 0; color: #64748b; font-size: 0.875rem;">Sigorta Acenteliği</p>
                </div>
                <div class="company-info">
                    <p style="margin: 0;"><i class="bi bi-telephone"></i> +90 {{ $agency_info['company_phone'] }}</p>
                    <p style="margin: 0;"><i class="bi bi-envelope"></i> {{ $agency_info['company_email'] }}</p>
                    <p style="margin: 0;"><i class="bi bi-geo-alt"></i> {{ $agency_info['company_address'] }}</p>
                </div>
            </div>

            <div class="document-title">
                <h1>SİGORTA TEKLİFİ</h1>
                <div class="quotation-meta">
                    <span>
                        <i class="bi bi-file-earmark-text"></i>
                        {{ $quotation->quotation_number }}
                    </span>
                    <span>
                        <i class="bi bi-calendar3"></i>
                        {{ $quotation->created_at->format('d.m.Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Validity Banner -->
        <div class="validity-banner {{ $quotation->isValid() ? '' : 'expired' }} mt-3">
            <div class="banner-content">
                <i class="bi bi-{{ $quotation->isValid() ? 'check-circle-fill' : 'exclamation-triangle-fill' }}"></i>
                <div>
                    <div class="validity-text">
                        @if($quotation->isValid())
                            Bu teklif {{ $quotation->valid_until->format('d.m.Y') }} tarihine kadar geçerlidir
                        @else
                            Bu teklifin geçerlilik süresi {{ $quotation->valid_until->format('d.m.Y') }} tarihinde sona ermiştir
                        @endif
                    </div>
                    <small style="color: #64748b; font-size: 0.8125rem;">
                        @if($quotation->isValid())
                            Kalan süre: {{ max(0, (int) now()->diffInDays(\Carbon\Carbon::parse($quotation->valid_until))) }} gün
                        @else
                            Güncel teklif için lütfen bizimle iletişime geçiniz
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-person-vcard"></i>
                    Müşteri Bilgileri
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Ad Soyad</div>
                    <div class="info-value">{{ $quotation->customer->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Telefon</div>
                    <div class="info-value">{{ $quotation->customer->phone }}</div>
                </div>
                @if($quotation->customer->email)
                <div class="info-item">
                    <div class="info-label">E-posta</div>
                    <div class="info-value">{{ $quotation->customer->email }}</div>
                </div>
                @endif
                @if($quotation->customer->address)
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Adres</div>
                    <div class="info-value">{{ $quotation->customer->address }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Policy Details -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Teklif Detayları
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Sigorta Türü</div>
                    <div class="info-value">{{ $quotation->typeDisplay }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Teklif Tarihi</div>
                    <div class="info-value">{{ $quotation->created_at->format('d.m.Y H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Geçerlilik Bitiş</div>
                    <div class="info-value">{{ $quotation->valid_until->format('d.m.Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Karşılaştırılan Şirket</div>
                    <div class="info-value">{{ $quotation->items->count() }} Firma</div>
                </div>
            </div>
        </div>

        <!-- Vehicle Information -->
        @if($quotation->vehicle_info && count(array_filter($quotation->vehicle_info)) > 0)
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-car-front"></i>
                    Araç Bilgileri
                </h2>
            </div>

            <div class="info-grid">
                @if(isset($quotation->vehicle_info['plate']))
                <div class="info-item">
                    <div class="info-label">Plaka</div>
                    <div class="info-value">{{ $quotation->vehicle_info['plate'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['brand']))
                <div class="info-item">
                    <div class="info-label">Marka</div>
                    <div class="info-value">{{ $quotation->vehicle_info['brand'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['model']))
                <div class="info-item">
                    <div class="info-label">Model</div>
                    <div class="info-value">{{ $quotation->vehicle_info['model'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['year']))
                <div class="info-item">
                    <div class="info-label">Model Yılı</div>
                    <div class="info-value">{{ $quotation->vehicle_info['year'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['chassis']))
                <div class="info-item">
                    <div class="info-label">Şase/Ruhsat No</div>
                    <div class="info-value">{{ $quotation->vehicle_info['chassis'] }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Property Information -->
        @if($quotation->property_info && count(array_filter($quotation->property_info)) > 0)
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-house-door"></i>
                    Konut Bilgileri
                </h2>
            </div>

            <div class="info-grid">
                @if(isset($quotation->property_info['address']))
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Adres</div>
                    <div class="info-value">{{ $quotation->property_info['address'] }}</div>
                </div>
                @endif
                @if(isset($quotation->property_info['area']))
                <div class="info-item">
                    <div class="info-label">Brüt Alan (m²)</div>
                    <div class="info-value">{{ $quotation->property_info['area'] }} m²</div>
                </div>
                @endif
                @if(isset($quotation->property_info['floor']))
                <div class="info-item">
                    <div class="info-label">Kat</div>
                    <div class="info-value">{{ $quotation->property_info['floor'] }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Company Offers -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-building"></i>
                    Sigorta Şirketi Teklifleri
                </h2>
            </div>

            <table class="offers-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 40%;">Sigorta Şirketi</th>
                        <th style="width: 35%;">Teminat Özeti</th>
                        <th style="width: 20%;">Prim Tutarı</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items->sortBy('premium_amount') as $index => $item)
                    <tr class="{{ $loop->first ? 'best-offer' : '' }} {{ $item->is_recommended ? 'recommended' : '' }}">
                        <td style="text-align: center; font-weight: 600; color: #64748b;">{{ $index + 1 }}</td>
                        <td>
                            <div class="company-name-cell">{{ $item->insuranceCompany->name }}</div>
                            <div style="margin-top: 0.375rem;">
                                @if($loop->first)
                                <span class="badge-offer badge-best">
                                    <i class="bi bi-trophy-fill"></i>
                                    En Uygun Fiyat
                                </span>
                                @endif
                                @if($item->is_recommended)
                                <span class="badge-offer badge-recommended">
                                    <i class="bi bi-star-fill"></i>
                                    Acente Tavsiyesi
                                </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($item->coverage_summary)
                            <small style="color: #64748b;">{{ $item->coverage_summary }}</small>
                            @else
                            <small style="color: #94a3b8;">Detaylı bilgi için iletişime geçiniz</small>
                            @endif
                        </td>
                        <td class="price-cell">{{ number_format($item->premium_amount, 2) }} ₺</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Box -->
            @if($quotation->items->count() > 1)
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">Toplam Karşılaştırılan Şirket</span>
                    <span class="summary-value">{{ $quotation->items->count() }} Firma</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">En Düşük Teklif</span>
                    <span class="summary-value">{{ number_format($quotation->items->min('premium_amount'), 2) }} ₺</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">En Yüksek Teklif</span>
                    <span class="summary-value">{{ number_format($quotation->items->max('premium_amount'), 2) }} ₺</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Ortalama Teklif</span>
                    <span class="summary-value">{{ number_format($quotation->average_price, 2) }} ₺</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Tavsiye Edilen Teklif</span>
                    <span class="summary-value">
                        @if($quotation->recommended_item)
                            {{ number_format($quotation->recommended_item->premium_amount, 2) }} ₺
                        @else
                            {{ number_format($quotation->lowest_price_item->premium_amount, 2) }} ₺
                        @endif
                    </span>
                </div>
            </div>
            @endif
        </div>

        <!-- Notes -->
        @if($quotation->notes)
        <div class="content-section">
            <div class="notes-section">
                <h6><i class="bi bi-info-circle"></i> Önemli Notlar</h6>
                <p>{{ $quotation->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Customer Response -->
        @if($quotation->status === 'approved')
        <div class="alert-custom alert-success-custom">
            <div class="alert-title">
                <i class="bi bi-check-circle-fill"></i>
                Teklifi Onayladınız
            </div>
            <p style="margin: 0.5rem 0 0 0;">Teklifinizi onayladığınız için teşekkür ederiz. Poliçe işlemleri için en kısa sürede sizinle iletişime geçeceğiz.</p>
            @if($quotation->customer_note)
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #86efac;">
                <strong>Notunuz:</strong> {{ $quotation->customer_note }}
            </div>
            @endif
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #86efac; font-size: 0.875rem;">
                <i class="bi bi-calendar-check"></i> Onay Tarihi: {{ $quotation->customer_responded_at->format('d.m.Y H:i') }}
            </div>
        </div>
        @elseif($quotation->status === 'rejected')
        <div class="alert-custom alert-danger-custom">
            <div class="alert-title">
                <i class="bi bi-x-circle-fill"></i>
                Teklif Reddedildi
            </div>
            <p style="margin: 0.5rem 0 0 0;">Geri bildiriminiz için teşekkür ederiz. Size daha uygun teklifler sunmak için sizinle iletişime geçeceğiz.</p>
            @if($quotation->customer_note)
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #fca5a5;">
                <strong>Notunuz:</strong> {{ $quotation->customer_note }}
            </div>
            @endif
        </div>
        @elseif($quotation->isValid() && $quotation->status !== 'converted')
        <div class="response-section">
            <h2 class="section-title">
                <i class="bi bi-chat-left-text"></i>
                Teklife Yanıt Verin
            </h2>
            <p class="response-intro">
                Lütfen yukarıdaki teklifleri inceleyerek devam etmek istediğiniz sigorta şirketi hakkında bizi bilgilendirin.
                Sorularınız için 7/24 müşteri hizmetlerimizle iletişime geçebilirsiniz.
            </p>

            <form method="POST" action="{{ route('quotations.customer-approve', $quotation->shared_link_token) }}" id="responseForm">
                @csrf
                <div class="mb-3">
                    <label for="customer_note" style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem; display: block;">
                        Not / Görüşleriniz (Opsiyonel)
                    </label>
                    <textarea
                        class="form-control"
                        id="customer_note"
                        name="customer_note"
                        rows="3"
                        style="border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9375rem;"
                        placeholder="Tercih ettiğiniz şirket, ödeme planı veya başka özel talepleriniz varsa buraya yazabilirsiniz..."></textarea>
                </div>

                <div class="response-buttons">
                    <button type="submit" name="customer_response" value="approved" class="btn-response btn-approve">
                        <i class="bi bi-check-circle-fill" style="font-size: 1.25rem;"></i>
                        Teklifi Onaylıyorum
                    </button>
                    <button type="submit" name="customer_response" value="rejected" class="btn-response btn-reject">
                        <i class="bi bi-x-circle" style="font-size: 1.25rem;"></i>
                        Teklifi Reddediyorum
                    </button>
                </div>

                <p style="text-align: center; margin-top: 1rem; font-size: 0.8125rem; color: #64748b;">
                    <i class="bi bi-shield-check"></i> Yanıtlarınız güvenli bir şekilde iletilmektedir
                </p>
            </form>
        </div>
        @endif

        <!-- Action Bar -->
        <div class="action-bar no-print">
            <button onclick="window.print()" class="btn-action btn-primary">
                <i class="bi bi-printer"></i>
                Yazdır / PDF Kaydet
            </button>
            <a href="tel:+90{{ $agency_info['company_phone'] }}" class="btn-action">
                <i class="bi bi-telephone"></i>
                Bizi Arayın
            </a>
            <a href="mailto:{{ $agency_info['company_email'] }}" class="btn-action">
                <i class="bi bi-envelope"></i>
                Email Gönderin
            </a>
        </div>

        <!-- Footer -->
        <div class="document-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h6>İletişim Bilgileri</h6>
                    <p><i class="bi bi-telephone"></i> +90 {{ $agency_info['company_phone'] }}</p>
                    <p><i class="bi bi-envelope"></i> {{ $agency_info['company_email'] }}</p>
                </div>
                <div class="footer-section">
                    <h6>Adres</h6>
                    <p>{{ $agency_info['company_address'] }}</p>
                </div>
                <div class="footer-section">
                    <h6>Çalışma Saatleri</h6>
                    <p>Pazartesi - Cuma: 09:00 - 18:00</p>
                    <p>Cumartesi: 09:00 - 14:00</p>
                    <p>Acil Durum: 7/24 Hizmet</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p style="margin-bottom: 0.5rem;">
                    <span class="security-badge">
                        <i class="bi bi-shield-check"></i>
                        SSL Güvenli Bağlantı
                    </span>
                    <span class="security-badge" style="margin-left: 1rem;">
                        <i class="bi bi-file-earmark-lock"></i>
                        Kişisel Veriler Korunmaktadır
                    </span>
                </p>
                <p style="margin: 0;">
                    © {{ date('Y') }} {{ config('app.name') }}. Tüm hakları saklıdır.
                    Bu teklif {{ now()->format('d.m.Y H:i') }} tarihinde elektronik ortamda oluşturulmuştur.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submit confirmation
        document.getElementById('responseForm')?.addEventListener('submit', function(e) {
            const button = e.submitter;
            const response = button.value;
            const message = response === 'approved'
                ? 'Teklifi onaylamak istediğinizden emin misiniz?\n\nOnayladıktan sonra sizinle iletişime geçilecektir.'
                : 'Teklifi reddetmek istediğinizden emin misiniz?\n\nSize daha uygun teklifler sunmak için sizinle iletişime geçeceğiz.';

            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
