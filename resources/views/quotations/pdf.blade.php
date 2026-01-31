<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quotation->quotation_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.6;
        }

        .container {
            padding: 20px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28pt;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .header .quotation-number {
            font-size: 16pt;
            opacity: 0.9;
        }

        /* Info Boxes */
        .info-section {
            margin-bottom: 25px;
        }

        .info-section h2 {
            background: #f1f5f9;
            padding: 12px 15px;
            border-left: 4px solid #3b82f6;
            font-size: 14pt;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 8px 10px;
            width: 35%;
            font-weight: 600;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-value {
            display: table-cell;
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }

        /* Company Table */
        .company-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .company-table thead {
            background: #3b82f6;
            color: white;
        }

        .company-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 11pt;
        }

        .company-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .company-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .company-table tbody tr:hover {
            background: #f1f5f9;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: 600;
            margin-right: 5px;
        }

        .badge-lowest {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .badge-recommended {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde047;
        }

        .price-highlight {
            font-size: 13pt;
            font-weight: bold;
            color: #059669;
        }

        /* Summary Box */
        .summary-box {
            background: #f0f9ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #bfdbfe;
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 13pt;
            color: #1e40af;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 9pt;
        }

        .footer .validity {
            background: #fef3c7;
            border: 1px solid #fde047;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            color: #92400e;
            font-weight: 600;
        }

        /* QR Code */
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .qr-code img {
            width: 120px;
            height: 120px;
        }

        /* Vehicle/Property Info */
        .detail-grid {
            display: table;
            width: 100%;
        }

        .detail-item {
            display: table-cell;
            width: 50%;
            padding: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
        }

        .detail-label {
            font-size: 9pt;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 11pt;
            color: #1e293b;
            font-weight: 500;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: rgba(59, 130, 246, 0.05);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Watermark -->
        @if($quotation->status === 'draft')
        <div class="watermark">TASLAK</div>
        @elseif($quotation->isExpired())
        <div class="watermark">SÜRESİ DOLMUŞ</div>
        @endif

        <!-- Header -->
        <div class="header">
            <h1>SİGORTA TEKLİFİ</h1>
            <div class="quotation-number">{{ $quotation->quotation_number }}</div>
        </div>

        <!-- Teklif Bilgileri -->
        <div class="info-section">
            <h2>📋 Teklif Bilgileri</h2>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Teklif Tarihi</div>
                    <div class="info-value">{{ $quotation->created_at->format('d.m.Y H:i') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Geçerlilik Tarihi</div>
                    <div class="info-value">
                        {{ $quotation->valid_until->format('d.m.Y') }}
                        @if($quotation->isValid())
                            <span style="color: #059669; font-weight: 600;">✓ Geçerli</span>
                        @else
                            <span style="color: #dc2626; font-weight: 600;">✗ Süresi Dolmuş</span>
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Teklif Türü</div>
                    <div class="info-value">{{ strtoupper($quotation->quotation_type) }} SİGORTASI</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Hazırlayan</div>
                    <div class="info-value">{{ $quotation->createdBy->name ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Müşteri Bilgileri -->
        <div class="info-section">
            <h2>👤 Müşteri Bilgileri</h2>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Ad Soyad</div>
                    <div class="info-value">{{ $quotation->customer->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telefon</div>
                    <div class="info-value">{{ $quotation->customer->phone }}</div>
                </div>
                @if($quotation->customer->email)
                <div class="info-row">
                    <div class="info-label">E-posta</div>
                    <div class="info-value">{{ $quotation->customer->email }}</div>
                </div>
                @endif
                @if($quotation->customer->address)
                <div class="info-row">
                    <div class="info-label">Adres</div>
                    <div class="info-value">{{ $quotation->customer->address }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Araç Bilgileri (varsa) -->
        @if($quotation->vehicle_info && count(array_filter($quotation->vehicle_info)) > 0)
        <div class="info-section">
            <h2>🚗 Araç Bilgileri</h2>
            <div class="info-grid">
                @if(isset($quotation->vehicle_info['plate']))
                <div class="info-row">
                    <div class="info-label">Plaka</div>
                    <div class="info-value">{{ $quotation->vehicle_info['plate'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['brand']))
                <div class="info-row">
                    <div class="info-label">Marka</div>
                    <div class="info-value">{{ $quotation->vehicle_info['brand'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['model']))
                <div class="info-row">
                    <div class="info-label">Model</div>
                    <div class="info-value">{{ $quotation->vehicle_info['model'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['year']))
                <div class="info-row">
                    <div class="info-label">Model Yılı</div>
                    <div class="info-value">{{ $quotation->vehicle_info['year'] }}</div>
                </div>
                @endif
                @if(isset($quotation->vehicle_info['chassis']))
                <div class="info-row">
                    <div class="info-label">Ruhsat Seri No</div>
                    <div class="info-value">{{ $quotation->vehicle_info['chassis'] }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Konut Bilgileri (varsa) -->
        @if($quotation->property_info && count(array_filter($quotation->property_info)) > 0)
        <div class="info-section">
            <h2>🏠 Konut Bilgileri</h2>
            <div class="info-grid">
                @if(isset($quotation->property_info['address']))
                <div class="info-row">
                    <div class="info-label">Adres</div>
                    <div class="info-value">{{ $quotation->property_info['address'] }}</div>
                </div>
                @endif
                @if(isset($quotation->property_info['area']))
                <div class="info-row">
                    <div class="info-label">Brüt Alan</div>
                    <div class="info-value">{{ $quotation->property_info['area'] }} m²</div>
                </div>
                @endif
                @if(isset($quotation->property_info['floor']))
                <div class="info-row">
                    <div class="info-label">Kat Numarası</div>
                    <div class="info-value">{{ $quotation->property_info['floor'] }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Şirket Teklifleri -->
        <div class="info-section">
            <h2>🏢 Şirket Teklifleri</h2>
            <table class="company-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 35%;">Sigorta Şirketi</th>
                        <th style="width: 20%;">Prim Tutarı</th>
                        <th style="width: 30%;">Teminat Özeti</th>
                        <th style="width: 10%; text-align: center;">Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items->sortBy('premium_amount') as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->insuranceCompany->name }}</strong>
                            <br>
                            <small style="color: #64748b;">{{ $item->insuranceCompany->code }}</small>
                        </td>
                        <td class="price-highlight">{{ number_format($item->premium_amount, 2) }} ₺</td>
                        <td>
                            <small>{{ $item->coverage_summary ?? '-' }}</small>
                        </td>
                        <td style="text-align: center;">
                            @if($loop->first)
                                <span class="badge badge-lowest">En Düşük</span>
                            @endif
                            @if($item->is_recommended)
                                <span class="badge badge-recommended">Önerilen</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Özet Kutu -->
        @if($quotation->items->count() > 0)
        <div class="summary-box">
            <div class="summary-item">
                <span>Toplam Şirket Sayısı:</span>
                <span><strong>{{ $quotation->items->count() }}</strong></span>
            </div>
            <div class="summary-item">
                <span>En Düşük Teklif:</span>
                <span><strong>{{ number_format($quotation->items->min('premium_amount'), 2) }} ₺</strong></span>
            </div>
            <div class="summary-item">
                <span>En Yüksek Teklif:</span>
                <span><strong>{{ number_format($quotation->items->max('premium_amount'), 2) }} ₺</strong></span>
            </div>
            <div class="summary-item">
                <span>Ortalama Teklif:</span>
                <span><strong>{{ number_format($quotation->items->avg('premium_amount'), 2) }} ₺</strong></span>
            </div>
        </div>
        @endif

        <!-- QR Code (Opsiyonel) -->
        <div class="qr-code">
            <p style="margin-bottom: 10px; color: #64748b; font-size: 10pt;">
                Teklifi Online Görüntülemek İçin QR Kodu Tarayın
            </p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($quotation->share_url) }}" alt="QR Code">
            <p style="margin-top: 10px; font-size: 9pt; color: #94a3b8;">
                {{ $quotation->share_url }}
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="validity">
                ⚠️ Bu teklif {{ $quotation->valid_until->format('d.m.Y') }} tarihine kadar geçerlidir.
            </div>
            <p style="margin-bottom: 5px;">
                <strong>{{ config('app.name') }}</strong>
            </p>
            <p>
                Bu belge elektronik ortamda oluşturulmuştur.
            </p>
            <p style="margin-top: 10px; font-size: 8pt;">
                Yazdırma Tarihi: {{ now()->format('d.m.Y H:i') }}
            </p>
        </div>
    </div>
</body>
</html>
