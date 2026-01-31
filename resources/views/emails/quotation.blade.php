<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigorta Teklifiniz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1e293b;
        }
        .message {
            margin-bottom: 25px;
            line-height: 1.8;
        }
        .custom-message {
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            font-style: italic;
        }
        .info-box {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #cbd5e1;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #64748b;
        }
        .info-value {
            color: #1e293b;
            font-weight: 500;
        }
        .cta-button {
            display: inline-block;
            background: #10b981;
            color: #ffffff !important;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            background: #059669;
        }
        .companies-list {
            margin: 20px 0;
        }
        .company-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .company-name {
            font-weight: 600;
            color: #1e293b;
        }
        .company-price {
            font-size: 18px;
            font-weight: 700;
            color: #059669;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
        .badge-recommended {
            background: #fef3c7;
            color: #92400e;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .validity-notice {
            background: #fef3c7;
            border: 1px solid #fde047;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            color: #92400e;
            font-weight: 600;
        }
        .link-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            font-size: 13px;
            color: #64748b;
            word-break: break-all;
            margin-top: 15px;
        }

        /* Tracking Pixel */
        .tracking-pixel {
            width: 1px;
            height: 1px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎯 Sigorta Teklifiniz Hazır</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ $quotation->quotation_number }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Merhaba <strong>{{ $quotation->customer->name }}</strong>,
            </div>

            <!-- Message -->
            <div class="message">
                {{ $quotation->createdBy->name ?? 'Ekibimiz' }} tarafından sizin için
                <strong>{{ $quotation->typeDisplay }}</strong> sigortası teklifi hazırlanmıştır.
            </div>

            <!-- Custom Message -->
            @if($customMessage)
            <div class="custom-message">
                {{ $customMessage }}
            </div>
            @endif

            <!-- Teklif Bilgileri -->
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Teklif Türü:</span>
                    <span class="info-value">{{ $quotation->typeDisplay }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Şirket Sayısı:</span>
                    <span class="info-value">{{ $quotation->items->count() }} firma</span>
                </div>
                <div class="info-row">
                    <span class="info-label">En Düşük Fiyat:</span>
                    <span class="info-value">
                        {{ $quotation->lowest_price_item ? number_format($quotation->lowest_price_item->premium_amount, 2) . ' ₺' : '-' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Geçerlilik Tarihi:</span>
                    <span class="info-value">{{ $quotation->valid_until->format('d.m.Y') }}</span>
                </div>
            </div>

            <!-- Şirket Teklifleri -->
            @if($quotation->items->count() > 0)
            <h3 style="color: #1e293b; margin-top: 30px;">Şirket Teklifleri</h3>
            <div class="companies-list">
                @foreach($quotation->items->sortBy('premium_amount')->take(5) as $item)
                <div class="company-item">
                    <div>
                        <div class="company-name">{{ $item->insuranceCompany->name }}</div>
                        @if($item->coverage_summary)
                        <div style="font-size: 13px; color: #64748b; margin-top: 5px;">
                            {{ Str::limit($item->coverage_summary, 60) }}
                        </div>
                        @endif
                    </div>
                    <div>
                        <div class="company-price">{{ number_format($item->premium_amount, 2) }} ₺</div>
                        @if($item->is_recommended)
                        <span class="badge badge-recommended">⭐ Önerilen</span>
                        @endif
                    </div>
                </div>
                @endforeach

                @if($quotation->items->count() > 5)
                <div style="text-align: center; margin-top: 10px; color: #64748b; font-size: 14px;">
                    + {{ $quotation->items->count() - 5 }} şirket daha
                </div>
                @endif
            </div>
            @endif

            <!-- CTA Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('quotations.email-click', $trackingToken) }}" class="cta-button">
                    📋 Teklifi Görüntüle ve Yanıtla
                </a>
            </div>

            <!-- Link -->
            <div style="text-align: center; color: #64748b; font-size: 14px;">
                veya aşağıdaki linki kullanabilirsiniz:
            </div>
            <div class="link-box">
                {{ $quotation->share_url }}
            </div>

            <!-- Validity Notice -->
            <div class="validity-notice">
                ⏰ Bu teklif {{ $quotation->valid_until->format('d.m.Y') }} tarihine kadar geçerlidir.
            </div>

            <!-- Contact Info -->
            <div style="margin-top: 30px; text-align: center; color: #64748b;">
                <p style="margin: 5px 0;">Herhangi bir sorunuz olursa bizimle iletişime geçmekten çekinmeyin.</p>
                <p style="margin: 5px 0; font-weight: 600; color: #1e293b;">
                    {{ config('app.name') }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 5px 0;">Bu email {{ config('app.name') }} tarafından gönderilmiştir.</p>
            <p style="margin: 5px 0; font-size: 12px;">
                © {{ date('Y') }} {{ config('app.name') }}. Tüm hakları saklıdır.
            </p>
        </div>
    </div>

    <!-- Tracking Pixel -->
    <img src="{{ route('quotations.email-open', $trackingToken) }}" alt="" class="tracking-pixel">
</body>
</html>
