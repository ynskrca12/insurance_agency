<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigorta Teklifi - {{ $quotation->quotation_number }}</title>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            body {
                margin: 0;
                padding: 0;
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-after: always;
            }

            .avoid-break {
                page-break-inside: avoid;
            }

            .print-button {
                display: none !important;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 10pt;
            color: #1e293b;
            line-height: 1.5;
            background: #ffffff;
        }

        .document {
            max-width: 210mm;
            margin: 30px auto;
            background: white;
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120pt;
            font-weight: 900;
            color: rgba(148, 163, 184, 0.08);
            z-index: 0;
            pointer-events: none;
            letter-spacing: 10px;
        }

        /* Header */
        .document-header {
            border-bottom: 3px solid #1e40af;
            padding-bottom: 20px;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .company-info {
            flex: 1;
        }

        .company-logo {
            font-size: 18pt;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .company-subtitle {
            font-size: 9pt;
            color: #64748b;
            margin-bottom: 8px;
        }

        .contact-info {
            font-size: 8pt;
            color: #64748b;
            line-height: 1.6;
        }

        .contact-info p {
            margin: 2px 0;
        }

        .document-meta {
            text-align: right;
            font-size: 8pt;
            color: #64748b;
        }

        .document-title {
            text-align: center;
            margin: 20px 0;
        }

        .document-title h1 {
            font-size: 20pt;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .document-number {
            font-size: 11pt;
            color: #64748b;
            font-weight: 600;
        }

        /* Validity Status */
        .validity-status {
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-left-width: 5px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: 600;
            color: #166534;
        }

        .validity-status.expired {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .validity-status .icon {
            font-size: 12pt;
            margin-right: 8px;
        }

        /* Section */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
            position: relative;
            z-index: 1;
        }

        .section-header {
            background: #f8fafc;
            border-left: 4px solid #1e40af;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 11pt;
            font-weight: 700;
            color: #1e293b;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table tr {
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table td {
            padding: 8px 10px;
            font-size: 9pt;
        }

        .info-table td:first-child {
            width: 35%;
            font-weight: 600;
            color: #64748b;
            background: #f8fafc;
        }

        .info-table td:last-child {
            color: #1e293b;
        }

        /* Offers Table */
        .offers-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .offers-table thead {
            background: #1e40af;
            color: white;
        }

        .offers-table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 9pt;
            border: 1px solid #1e3a8a;
        }

        .offers-table td {
            padding: 8px;
            border: 1px solid #e2e8f0;
            font-size: 9pt;
        }

        .offers-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .offers-table tbody tr.highlight {
            background: #f0fdf4;
        }

        .company-name {
            font-weight: 700;
            color: #1e293b;
            font-size: 10pt;
        }

        .company-code {
            font-size: 7pt;
            color: #94a3b8;
            display: block;
            margin-top: 2px;
        }

        .price {
            font-size: 11pt;
            font-weight: 700;
            color: #1e40af;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 2px;
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
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 10pt;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #cbd5e1;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 9pt;
            border-bottom: 1px dashed #e2e8f0;
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-top: 10px;
            margin-top: 5px;
            border-top: 2px solid #cbd5e1;
            font-weight: 700;
            font-size: 10pt;
        }

        .summary-label {
            color: #64748b;
        }

        .summary-value {
            color: #1e293b;
            font-weight: 600;
        }

        .summary-row:last-child .summary-value {
            color: #1e40af;
            font-size: 12pt;
        }

        /* Notes Box */
        .notes-box {
            background: #fffbeb;
            border: 2px solid #fde047;
            border-left-width: 5px;
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        .notes-box h4 {
            font-size: 9pt;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .notes-box p {
            font-size: 9pt;
            color: #78350f;
            line-height: 1.5;
        }

        /* Footer */
        .document-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            page-break-inside: avoid;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 15px;
        }

        .footer-section h4 {
            font-size: 8pt;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-section p {
            font-size: 7pt;
            color: #64748b;
            line-height: 1.4;
            margin: 2px 0;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            font-size: 7pt;
            color: #94a3b8;
        }

        .footer-bottom p {
            margin: 3px 0;
        }

        .security-info {
            display: inline-block;
            margin: 0 8px;
            color: #64748b;
        }

        /* QR Code Section */
        .qr-section {
            text-align: center;
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .qr-section h4 {
            font-size: 9pt;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 10px;
        }

        .qr-section img {
            width: 100px;
            height: 100px;
            margin: 5px 0;
        }

        .qr-section p {
            font-size: 7pt;
            color: #94a3b8;
            margin-top: 5px;
            word-break: break-all;
        }

        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1e40af;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 11pt;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            z-index: 9999;
            transition: all 0.2s ease;
        }

        .print-button:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(30, 64, 175, 0.4);
        }

        /* Important Notice Box */
        .important-notice {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 8pt;
        }

        .important-notice h4 {
            font-size: 9pt;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 6px;
        }

        .important-notice ul {
            margin: 5px 0 0 15px;
            color: #64748b;
        }

        .important-notice li {
            margin: 3px 0;
        }

        /* Status Badge for Header */
        .header-status {
            position: absolute;
            top: -10px;
            right: 140px;
            background: #f0fdf4;
            border: 2px solid #86efac;
            color: #166534;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header-status.draft {
            background: #fef3c7;
            border-color: #fde047;
            color: #92400e;
        }

        .header-status.expired {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button onclick="printDocument()" class="print-button no-print">
        🖨️ PDF Olarak Kaydet / Yazdır
    </button>

    <div class="document">
        <!-- Watermark -->
        @if($quotation->status === 'draft')
        <div class="watermark">TASLAK</div>
        @elseif(!$quotation->isValid())
        <div class="watermark">SÜRESİ DOLMUŞ</div>
        @endif

        <!-- Header -->
        <div class="document-header">
            @if($quotation->status === 'draft')
            <div class="header-status draft"> Taslak</div>
            @elseif(!$quotation->isValid())
            <div class="header-status expired"> Süresi Dolmuş</div>
            @else
            <div class="header-status">✓ Geçerli</div>
            @endif

            <div class="header-top">
                <div class="company-info">
                    <div class="company-logo">{{ $agency_info['company_name'] }}</div>
                    <div class="company-subtitle">Sigorta Acenteliği</div>
                    <div class="contact-info">
                        <p><strong>📞 Telefon:</strong> +90 {{ $agency_info['company_phone'] }}</p>
                        <p><strong>📧 E-posta:</strong> {{ $agency_info['company_email'] }}</p>
                        <p><strong>📍 Adres:</strong> {{ $agency_info['company_address'] }}</p>
                    </div>
                </div>
                <div class="document-meta">
                    <p><strong>Belge No:</strong> {{ $quotation->quotation_number }}</p>
                    <p><strong>Tarih:</strong> {{ $quotation->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Hazırlayan:</strong> {{ $quotation->createdBy->name ?? 'Acente' }}</p>
                    <p><strong>Yazdırma:</strong> {{ now()->format('d.m.Y H:i') }}</p>
                </div>
            </div>

            <div class="document-title">
                <h1>SİGORTA TEKLİF FORMU</h1>
                <div class="document-number">{{ $quotation->quotation_number }}</div>
            </div>
        </div>

        <!-- Validity Status -->
        <div class="validity-status {{ $quotation->isValid() ? '' : 'expired' }}">
            <span class="icon">{{ $quotation->isValid() ? '✓' : '⚠️' }}</span>
            @if($quotation->isValid())
                <strong>Geçerlilik Durumu:</strong> Bu teklif {{ $quotation->valid_until->format('d.m.Y') }} tarihine kadar geçerlidir
                ({{ max(0, (int) now()->diffInDays(\Carbon\Carbon::parse($quotation->valid_until))) }} gün kaldı)

            @else
                <strong>Geçerlilik Durumu:</strong> Bu teklifin süresi {{ $quotation->valid_until->format('d.m.Y') }} tarihinde dolmuştur.
                Güncel teklif için lütfen bizimle iletişime geçiniz.
            @endif
        </div>

        <!-- Customer Information -->
        <div class="section avoid-break">
            <div class="section-header"> MÜŞTERİ BİLGİLERİ</div>
            <table class="info-table">
                <tr>
                    <td>Ad Soyad</td>
                    <td><strong>{{ $quotation->customer->name }}</strong></td>
                </tr>
                <tr>
                    <td>Telefon</td>
                    <td>{{ $quotation->customer->phone }}</td>
                </tr>
                @if($quotation->customer->email)
                <tr>
                    <td>E-posta</td>
                    <td>{{ $quotation->customer->email }}</td>
                </tr>
                @endif
                @if($quotation->customer->tc_no)
                <tr>
                    <td>TC Kimlik No</td>
                    <td>{{ $quotation->customer->tc_no }}</td>
                </tr>
                @endif
                @if($quotation->customer->address)
                <tr>
                    <td>Adres</td>
                    <td>{{ $quotation->customer->address }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Quotation Details -->
        <div class="section avoid-break">
            <div class="section-header"> TEKLİF DETAYLARI</div>
            <table class="info-table">
                <tr>
                    <td>Sigorta Türü</td>
                    <td><strong>{{ $quotation->typeDisplay }}</strong></td>
                </tr>
                <tr>
                    <td>Teklif Tarihi</td>
                    <td>{{ $quotation->created_at->format('d.m.Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Geçerlilik Tarihi</td>
                    <td>{{ $quotation->valid_until->format('d.m.Y') }}</td>
                </tr>
                <tr>
                    <td>Karşılaştırılan Şirket Sayısı</td>
                    <td><strong>{{ $quotation->items->count() }} Firma</strong></td>
                </tr>
                @if($quotation->selectedCompany)
                <tr>
                    <td>Seçilen Şirket</td>
                    <td><strong>{{ $quotation->selectedCompany->name }}</strong></td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Vehicle Information -->
        @if($quotation->vehicle_info && count(array_filter($quotation->vehicle_info)) > 0)
        <div class="section avoid-break">
            <div class="section-header"> ARAÇ BİLGİLERİ</div>
            <table class="info-table">
                @if(isset($quotation->vehicle_info['plate']))
                <tr>
                    <td>Plaka</td>
                    <td><strong>{{ $quotation->vehicle_info['plate'] }}</strong></td>
                </tr>
                @endif
                @if(isset($quotation->vehicle_info['brand']))
                <tr>
                    <td>Marka</td>
                    <td>{{ $quotation->vehicle_info['brand'] }}</td>
                </tr>
                @endif
                @if(isset($quotation->vehicle_info['model']))
                <tr>
                    <td>Model</td>
                    <td>{{ $quotation->vehicle_info['model'] }}</td>
                </tr>
                @endif
                @if(isset($quotation->vehicle_info['year']))
                <tr>
                    <td>Model Yılı</td>
                    <td>{{ $quotation->vehicle_info['year'] }}</td>
                </tr>
                @endif
                @if(isset($quotation->vehicle_info['chassis']))
                <tr>
                    <td>Şase/Ruhsat Seri No</td>
                    <td>{{ $quotation->vehicle_info['chassis'] }}</td>
                </tr>
                @endif
            </table>
        </div>
        @endif

        <!-- Property Information -->
        @if($quotation->property_info && count(array_filter($quotation->property_info)) > 0)
        <div class="section avoid-break">
            <div class="section-header"> KONUT BİLGİLERİ</div>
            <table class="info-table">
                @if(isset($quotation->property_info['address']))
                <tr>
                    <td>Adres</td>
                    <td>{{ $quotation->property_info['address'] }}</td>
                </tr>
                @endif
                @if(isset($quotation->property_info['area']))
                <tr>
                    <td>Brüt Alan (m²)</td>
                    <td>{{ $quotation->property_info['area'] }} m²</td>
                </tr>
                @endif
                @if(isset($quotation->property_info['floor']))
                <tr>
                    <td>Kat</td>
                    <td>{{ $quotation->property_info['floor'] }}</td>
                </tr>
                @endif
            </table>
        </div>
        @endif

        <!-- Company Offers -->
        <div class="section">
            <div class="section-header"> SİGORTA ŞİRKETİ TEKLİFLERİ</div>
            <table class="offers-table">
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">#</th>
                        <th style="width: 35%;">Sigorta Şirketi</th>
                        <th style="width: 18%; text-align: right;">Prim Tutarı</th>
                        <th style="width: 32%;">Teminat Özeti</th>
                        <th style="width: 10%; text-align: center;">Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items->sortBy('premium_amount') as $index => $item)
                    <tr class="{{ $loop->first ? 'highlight' : '' }}">
                        <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}</td>
                        <td>
                            <div class="company-name">{{ $item->insuranceCompany->name }}</div>
                            <span class="company-code">{{ $item->insuranceCompany->code }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div class="price">{{ number_format($item->premium_amount, 2) }} ₺</div>
                        </td>
                        <td>
                            <small>{{ $item->coverage_summary ?? 'Detaylı bilgi için iletişime geçiniz' }}</small>
                        </td>
                        <td style="text-align: center;">
                            @if($loop->first)
                            <span class="badge badge-best">En Uygun</span>
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

        <!-- Summary -->
        @if($quotation->items->count() > 1)
        <div class="summary-box avoid-break">
            <div class="summary-title"> FİYAT KARŞILAŞTIRMA ÖZETİ</div>
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

        <!-- Notes -->
        @if($quotation->notes)
        <div class="notes-box avoid-break">
            <h4> ÖNEMLİ NOTLAR</h4>
            <p>{{ $quotation->notes }}</p>
        </div>
        @endif

        <!-- Important Notice -->
        <div class="important-notice avoid-break">
            <h4> ÖNEMLİ BİLGİLENDİRME</h4>
            <ul>
                <li>Bu teklif {{ $quotation->valid_until->format('d.m.Y') }} tarihine kadar geçerlidir.</li>
                <li>Belirtilen fiyatlar poliçe düzenleme tarihi itibariyle geçerlidir ve değişebilir.</li>
                <li>Teminat detayları için lütfen ilgili sigorta şirketinin poliçe şartlarını inceleyiniz.</li>
                <li>Poliçe düzenlenmesi için ek belgeler istenebilir.</li>
                <li>Ödeme planları ve taksit seçenekleri için ofisimizle iletişime geçebilirsiniz.</li>
            </ul>
        </div>

        <!-- QR Code -->
        <div class="qr-section no-print avoid-break">
            <h4> Teklifi Online Görüntülemek İçin QR Kodu Tarayın</h4>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($quotation->share_url) }}"
                 alt="QR Code">
            <p>{{ $quotation->share_url }}</p>
        </div>

        <!-- Footer -->
        <div class="document-footer">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>İLETİŞİM BİLGİLERİ</h4>
                    <p>📞 +90 {{ $agency_info['company_phone'] }}</p>
                    <p>📧 {{ $agency_info['company_email'] }}</p>
                    <p>📱 WhatsApp: +90 {{ $agency_info['company_phone'] }}</p>
                </div>
                <div class="footer-section">
                    <h4>OFİS ADRESİ</h4>
                    <p>{{ $agency_info['company_address'] }}</p>
                </div>
                <div class="footer-section">
                    <h4>ÇALIŞMA SAATLERİ</h4>
                    <p>Pazartesi - Cuma: 09:00 - 18:00</p>
                    <p>Cumartesi: 09:00 - 14:00</p>
                    <p>Pazar: Kapalı</p>
                    <p>⚡ Acil Durum: 7/24</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>
                    <span class="security-info">🔒 SSL Güvenli Bağlantı</span>
                    <span class="security-info">🛡️ Kişisel Veriler Korunmaktadır (KVKK)</span>
                    <span class="security-info">✓ Lisanslı Acente</span>
                </p>
                <p>
                    © {{ date('Y') }} {{ config('app.name') }}. Tüm hakları saklıdır.
                </p>
                <p>
                    Bu belge elektronik ortamda oluşturulmuş olup, {{ now()->format('d.m.Y H:i') }} tarihinde yazdırılmıştır.
                    Belge kimliği: {{ $quotation->quotation_number }}
                </p>
            </div>
        </div>
    </div>

    <script>
        function printDocument() {
            // PDF oluşturuldu olarak işaretle
            fetch('{{ route('quotations.mark-pdf-generated', $quotation) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            }).then(() => {
                // Print dialog aç
                window.print();
            }).catch(error => {
                console.error('PDF işaretleme hatası:', error);
                // Hata olsa bile yazdırmaya devam et
                window.print();
            });
        }

        // Klavye kısayolu (Ctrl+P / Cmd+P)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printDocument();
            }
        });

        // Sayfa yüklendiğinde yazdırma önerisi göster
        window.addEventListener('load', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('auto_print') === '1') {
                setTimeout(printDocument, 500);
            }
        });
    </script>
</body>
</html>
