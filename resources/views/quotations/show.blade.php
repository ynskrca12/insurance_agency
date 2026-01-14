@extends('layouts.app')

@section('title', 'Teklif Detayı - ' . $quotation->quotation_number)

@push('styles')
<style>
    .detail-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .info-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1rem 1.25rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: #6c757d;
        font-size: 1.125rem;
    }

    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.8125rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #212529;
        font-weight: 600;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 8px;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .validity-card {
        text-align: center;
        padding: 1.5rem;
    }

    .validity-date {
        font-size: 1.75rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .share-link-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .share-link-box input {
        border: none;
        background: transparent;
        flex: 1;
        font-size: 0.875rem;
        color: #495057;
    }

    .share-link-box input:focus {
        outline: none;
    }

    .copy-btn {
        width: 2rem;
        height: 2rem;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .copy-btn:hover {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .company-item {
        background: #fafafa;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .company-item:hover {
        background: #f5f5f5;
        border-color: #d0d0d0;
        transform: translateX(5px);
    }

    .company-item.recommended {
        background: #fff8e1;
        border: 2px solid #ffc107;
    }

    .company-item.lowest {
        background: #e8f5e9;
        border: 2px solid #4caf50;
    }

    .company-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-lowest {
        background: #4caf50;
        color: #ffffff;
    }

    .badge-recommended {
        background: #ffc107;
        color: #000000;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
    }

    .price-comparison {
        padding: 1.5rem;
        background: #fafafa;
        border-radius: 10px;
    }

    .comparison-item {
        margin-bottom: 1rem;
    }

    .comparison-item:last-child {
        margin-bottom: 0;
    }

    .comparison-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .comparison-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #495057;
    }

    .comparison-price {
        font-size: 0.875rem;
        font-weight: 700;
        color: #212529;
    }

    .progress-modern {
        height: 28px;
        background: #e9ecef;
        border-radius: 6px;
        overflow: hidden;
    }

    .progress-bar-modern {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #ffffff;
        transition: width 0.6s ease;
    }

    .view-stat {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }

    .view-stat i {
        color: #6c757d;
    }

    .vehicle-info-grid,
    .property-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .info-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
    }

    .modal-modern .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        background: #4caf50;
        color: #ffffff;
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-modern .modal-body {
        padding: 1.5rem;
    }

    .modal-modern .modal-footer {
        background: #fafafa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .company-item {
            padding: 1rem;
        }

        .price-value {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="flex-grow-1">
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-file-earmark-text me-2"></i>{{ $quotation->quotation_number }}
                </h1>
                <p class="text-muted mb-0 small">
                    {{ ucfirst($quotation->quotation_type) }} Teklifi •
                    {{ $quotation->created_at->format('d.m.Y H:i') }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'draft' => ['color' => 'secondary', 'label' => 'Taslak', 'icon' => 'file-earmark'],
                        'sent' => ['color' => 'info', 'label' => 'Gönderildi', 'icon' => 'send-check'],
                        'viewed' => ['color' => 'primary', 'label' => 'Görüntülendi', 'icon' => 'eye-fill'],
                        'approved' => ['color' => 'warning', 'label' => 'Onaylandı', 'icon' => 'hand-thumbs-up'],
                        'rejected' => ['color' => 'danger', 'label' => 'Reddedildi', 'icon' => 'hand-thumbs-down'],
                        'converted' => ['color' => 'success', 'label' => 'Dönüştürüldü', 'icon' => 'check-circle-fill'],
                        'expired' => ['color' => 'dark', 'label' => 'Süresi Doldu', 'icon' => 'x-circle-fill'],
                    ];
                    $config = $statusConfig[$quotation->status] ?? ['color' => 'secondary', 'label' => $quotation->status, 'icon' => 'circle-fill'];
                @endphp
                <span class="badge badge-modern bg-{{ $config['color'] }}">
                    <i class="bi bi-{{ $config['icon'] }}"></i>
                    {{ $config['label'] }}
                </span>

                @if($quotation->status === 'draft')
                <form method="POST" action="{{ route('quotations.send', $quotation) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success action-btn">
                        <i class="bi bi-send me-2"></i>Müşteriye Gönder
                    </button>
                </form>
                @endif

                @if($quotation->status !== 'converted')
                <button type="button" class="btn btn-primary action-btn" onclick="copyShareLink()">
                    <i class="bi bi-share me-2"></i>Link Kopyala
                </button>
                <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-warning action-btn">
                    <i class="bi bi-pencil me-2"></i>Düzenle
                </a>
                @endif

                @if($quotation->status === 'approved' && $quotation->status !== 'converted')
                <button type="button" class="btn btn-success action-btn" data-bs-toggle="modal" data-bs-target="#convertModal">
                    <i class="bi bi-arrow-right-circle me-2"></i>Poliçeye Dönüştür
                </button>
                @endif

                <a href="{{ route('quotations.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Sidebar -->
        <div class="col-lg-4">
            <!-- Müşteri Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-person"></i>
                        <span>Müşteri Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Müşteri Adı</div>
                        <div class="info-value">
                            <a href="{{ route('customers.show', $quotation->customer) }}" class="text-decoration-none text-dark">
                                {{ $quotation->customer->name }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">
                            <a href="tel:{{ $quotation->customer->phone }}" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone me-1"></i>{{ $quotation->customer->phone }}
                            </a>
                        </div>
                    </div>

                    @if($quotation->customer->email)
                    <div class="info-item">
                        <div class="info-label">E-posta</div>
                        <div class="info-value">
                            <a href="mailto:{{ $quotation->customer->email }}" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope me-1"></i>{{ $quotation->customer->email }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Geçerlilik -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-calendar-check"></i>
                        <span>Geçerlilik Durumu</span>
                    </h6>
                </div>
                <div class="card-body validity-card">
                    <div class="validity-date">{{ $quotation->valid_until->format('d.m.Y') }}</div>
                    @if($quotation->isValid())
                        <span class="badge badge-modern bg-success">
                            <i class="bi bi-check-circle-fill"></i>
                            Geçerli
                        </span>
                    @else
                        <span class="badge badge-modern bg-danger">
                            <i class="bi bi-x-circle-fill"></i>
                            Süresi Dolmuş
                        </span>
                    @endif
                </div>
            </div>

            <!-- Görüntüleme İstatistikleri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-eye"></i>
                        <span>Görüntüleme İstatistikleri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Toplam Görüntüleme</div>
                        <div class="info-value">{{ $quotation->view_count }} kez</div>
                    </div>

                    @if($quotation->views->isNotEmpty())
                    <div class="mt-3">
                        <div class="info-label mb-2">Son Görüntülemeler</div>
                        @foreach($quotation->views->sortByDesc('viewed_at')->take(3) as $view)
                        <div class="view-stat">
                            <i class="bi bi-{{ $view->device_type === 'mobile' ? 'phone' : ($view->device_type === 'tablet' ? 'tablet' : 'laptop') }}"></i>
                            <span class="small">{{ $view->viewed_at->format('d.m.Y H:i') }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Paylaşım Linki -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-share"></i>
                        <span>Paylaşım Linki</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="share-link-box">
                        <input type="text"
                               id="shareLink"
                               value="{{ $quotation->share_url }}"
                               readonly>
                        <button class="copy-btn" onclick="copyShareLink()" title="Kopyala">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2">
                        Bu linki müşteriye göndererek teklifi görüntülemesini sağlayabilirsiniz.
                    </small>
                </div>
            </div>

            @if($quotation->status === 'converted' && $quotation->convertedPolicy)
            <!-- Dönüştürülen Poliçe -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-check-circle"></i>
                        <span>Dönüştürülen Poliçe</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Poliçe Numarası</div>
                        <div class="info-value">{{ $quotation->convertedPolicy->policy_number }}</div>
                    </div>
                    <a href="{{ route('policies.show', $quotation->convertedPolicy) }}"
                       class="btn btn-success action-btn w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>Poliçeyi Görüntüle
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Şirket Teklifleri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-building"></i>
                        <span>Şirket Teklifleri ({{ $quotation->items->count() }})</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($quotation->items->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h6 class="text-muted mb-1">Teklif Bulunamadı</h6>
                            <p class="text-muted small mb-0">Henüz hiç şirket teklifi eklenmemiş.</p>
                        </div>
                    @else
                        @foreach($quotation->items->sortBy('premium_amount') as $item)
                        <div class="company-item {{ $item->is_recommended ? 'recommended' : '' }} {{ $loop->first ? 'lowest' : '' }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $item->insuranceCompany->name }}</h6>
                                    <small class="text-muted">{{ $item->insuranceCompany->code }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="price-value">{{ number_format($item->premium_amount, 2) }} ₺</div>
                                    <div class="mt-1">
                                        @if($loop->first)
                                        <span class="company-badge badge-lowest">
                                            <i class="bi bi-trophy-fill"></i>
                                            En Düşük
                                        </span>
                                        @endif
                                        @if($item->is_recommended)
                                        <span class="company-badge badge-recommended">
                                            <i class="bi bi-star-fill"></i>
                                            Önerilen
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($item->coverage_summary)
                            <div class="mt-2 pt-2 border-top">
                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-shield-check me-1"></i>Teminatlar
                                </small>
                                <p class="mb-0 small">{{ $item->coverage_summary }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach

                        <!-- Fiyat Karşılaştırması -->
                        <div class="price-comparison mt-3">
                            <h6 class="mb-3 fw-bold">
                                <i class="bi bi-bar-chart me-2"></i>Fiyat Karşılaştırması
                            </h6>
                            @foreach($quotation->items->sortBy('premium_amount') as $item)
                            <div class="comparison-item">
                                <div class="comparison-header">
                                    <span class="comparison-label">{{ $item->insuranceCompany->code }}</span>
                                    <span class="comparison-price">{{ number_format($item->premium_amount, 2) }} ₺</span>
                                </div>
                                @php
                                    $maxPrice = $quotation->items->max('premium_amount');
                                    $percentage = $maxPrice > 0 ? ($item->premium_amount / $maxPrice) * 100 : 0;
                                    $barColor = $item->is_recommended ? '#ffc107' : ($loop->first ? '#4caf50' : '#0d6efd');
                                @endphp
                                <div class="progress-modern">
                                    <div class="progress-bar-modern"
                                         style="width: {{ $percentage }}%; background: {{ $barColor }};">
                                        {{ number_format($percentage, 0) }}%
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Araç Bilgileri -->
            @if($quotation->vehicle_info && count(array_filter($quotation->vehicle_info)) > 0)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-car-front"></i>
                        <span>Araç Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="vehicle-info-grid">
                        @if(isset($quotation->vehicle_info['plate']) && $quotation->vehicle_info['plate'])
                        <div class="info-box">
                            <div class="info-label">Plaka</div>
                            <div class="info-value">{{ $quotation->vehicle_info['plate'] }}</div>
                        </div>
                        @endif
                        @if(isset($quotation->vehicle_info['brand']) && $quotation->vehicle_info['brand'])
                        <div class="info-box">
                            <div class="info-label">Marka</div>
                            <div class="info-value">{{ $quotation->vehicle_info['brand'] }}</div>
                        </div>
                        @endif
                        @if(isset($quotation->vehicle_info['model']) && $quotation->vehicle_info['model'])
                        <div class="info-box">
                            <div class="info-label">Model</div>
                            <div class="info-value">{{ $quotation->vehicle_info['model'] }}</div>
                        </div>
                        @endif
                        @if(isset($quotation->vehicle_info['year']) && $quotation->vehicle_info['year'])
                        <div class="info-box">
                            <div class="info-label">Model Yılı</div>
                            <div class="info-value">{{ $quotation->vehicle_info['year'] }}</div>
                        </div>
                        @endif
                    </div>
                    @if(isset($quotation->vehicle_info['chassis']) && $quotation->vehicle_info['chassis'])
                    <div class="info-box mt-2">
                        <div class="info-label">Ruhsat Seri No</div>
                        <div class="info-value font-monospace small">{{ $quotation->vehicle_info['chassis'] }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Konut Bilgileri -->
            @if($quotation->property_info && count(array_filter($quotation->property_info)) > 0)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-house"></i>
                        <span>Konut Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if(isset($quotation->property_info['address']) && $quotation->property_info['address'])
                    <div class="info-box mb-2">
                        <div class="info-label">Adres</div>
                        <div class="info-value">{{ $quotation->property_info['address'] }}</div>
                    </div>
                    @endif
                    <div class="property-info-grid">
                        @if(isset($quotation->property_info['area']) && $quotation->property_info['area'])
                        <div class="info-box">
                            <div class="info-label">Brüt Alan</div>
                            <div class="info-value">{{ $quotation->property_info['area'] }} m²</div>
                        </div>
                        @endif
                        @if(isset($quotation->property_info['floor']) && $quotation->property_info['floor'])
                        <div class="info-box">
                            <div class="info-label">Kat Numarası</div>
                            <div class="info-value">{{ $quotation->property_info['floor'] }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Poliçeye Dönüştürme Modal -->
<div class="modal fade modal-modern" id="convertModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-arrow-right-circle me-2"></i>Poliçeye Dönüştür
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('quotations.convert', $quotation) }}" id="convertForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Seçilen Şirket <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="selected_item_id" required>
                            <option value="">Şirket seçiniz</option>
                            @foreach($quotation->items->sortBy('premium_amount') as $item)
                            <option value="{{ $item->id }}" {{ $item->is_recommended ? 'selected' : '' }}>
                                {{ $item->insuranceCompany->name }} - {{ number_format($item->premium_amount, 2) }} ₺
                                {{ $item->is_recommended ? '(Önerilen)' : '' }}
                            </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Poliçeye dönüştürülecek şirketi seçin</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Başlangıç Tarihi <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               class="form-control"
                               name="start_date"
                               value="{{ now()->format('Y-m-d') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ödeme Şekli <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="payment_type" id="payment_type_modal" required>
                            <option value="cash">Peşin Ödeme</option>
                            <option value="installment" selected>Taksitli Ödeme</option>
                        </select>
                    </div>

                    <div class="mb-3" id="installment_count_modal_div">
                        <label class="form-label fw-semibold">Taksit Sayısı</label>
                        <select class="form-select" name="installment_count">
                            <option value="1">1 Taksit</option>
                            <option value="2">2 Taksit</option>
                            <option value="3">3 Taksit</option>
                            <option value="4">4 Taksit</option>
                            <option value="6" selected>6 Taksit</option>
                            <option value="9">9 Taksit</option>
                            <option value="12">12 Taksit</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-success action-btn">
                        <i class="bi bi-check-circle me-2"></i>Poliçe Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyShareLink() {
    const link = document.getElementById('shareLink').value;
    navigator.clipboard.writeText(link).then(function() {
        // Modern toast notification
        const toast = `
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 10px;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Başarılı!</strong> Paylaşım linki kopyalandı.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').append(toast);

        setTimeout(function() {
            $('.alert').fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    }, function() {
        prompt('Linki manuel olarak kopyalayın:', link);
    });
}

$(document).ready(function() {
    // Ödeme tipi değişimi
    $('#payment_type_modal').on('change', function() {
        if ($(this).val() === 'installment') {
            $('#installment_count_modal_div').slideDown(300);
        } else {
            $('#installment_count_modal_div').slideUp(300);
        }
    });

    // Form gönderme
    $('#convertForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Oluşturuluyor...');
    });

    // Progress bar animasyonu
    $('.progress-bar-modern').each(function(index) {
        const $bar = $(this);
        const width = $bar.css('width');
        $bar.css('width', '0');

        setTimeout(function() {
            $bar.css({
                'width': width,
                'transition': 'width 0.8s ease'
            });
        }, 100 + (index * 100));
    });
});
</script>
@endpush
