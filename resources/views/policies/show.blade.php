@extends('layouts.app')

@section('title', 'Poliçe Detayı - ' . $policy->policy_number)

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

    .stat-box {
        background: #fafafa;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        background: #f5f5f5;
        border-color: #d0d0d0;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
    }

    .nav-tabs-modern {
        border: none;
        background: #fafafa;
        border-radius: 12px;
        padding: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .nav-tabs-modern .nav-link {
        border: none;
        border-radius: 8px;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 0.75rem 1.25rem;
        margin: 0 0.25rem;
    }

    .nav-tabs-modern .nav-link:hover {
        background: #f0f0f0;
        color: #495057;
    }

    .nav-tabs-modern .nav-link.active {
        background: #ffffff;
        color: #212529;
        border: 1px solid #dcdcdc;
    }

    .content-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead {
        background: #fafafa;
        border-bottom: 2px solid #e8e8e8;
    }

    .table-modern thead th {
        border: none;
        color: #495057;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .summary-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .timeline-item {
        padding: 1rem;
        border-left: 2px solid #e0e0e0;
        margin-left: 1rem;
        position: relative;
        background: #fafafa;
        border-radius: 0 8px 8px 0;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        border-left-color: #999;
        background: #f5f5f5;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 1.5rem;
        width: 0.75rem;
        height: 0.75rem;
        background: #ffffff;
        border: 2px solid #999;
        border-radius: 50%;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        .stat-box {
            padding: 1rem;
        }

        .stat-icon {
            font-size: 2rem;
        }

        .stat-value {
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
                    <i class="bi bi-file-earmark-text me-2"></i>{{ $policy->policy_number }}
                </h1>
                <p class="text-muted mb-0 small">
                    {{ $policy->policy_type_label }} •
                    Oluşturulma: {{ $policy->created_at->format('d.m.Y H:i') }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'active' => ['color' => 'success', 'label' => 'Aktif', 'icon' => 'check-circle-fill'],
                        'expiring_soon' => ['color' => 'warning', 'label' => 'Yaklaşan', 'icon' => 'clock-fill'],
                        'critical' => ['color' => 'danger', 'label' => 'Kritik', 'icon' => 'exclamation-triangle-fill'],
                        'expired' => ['color' => 'secondary', 'label' => 'Dolmuş', 'icon' => 'x-circle-fill'],
                        'renewed' => ['color' => 'info', 'label' => 'Yenilendi', 'icon' => 'arrow-repeat'],
                        'cancelled' => ['color' => 'dark', 'label' => 'İptal', 'icon' => 'slash-circle-fill'],
                    ];
                    $config = $statusConfig[$policy->status] ?? ['color' => 'secondary', 'label' => $policy->status, 'icon' => 'circle-fill'];
                @endphp
                <span class="badge badge-modern bg-{{ $config['color'] }}">
                    <i class="bi bi-{{ $config['icon'] }}"></i>
                    {{ $config['label'] }}
                </span>
                <a href="{{ route('policies.edit', $policy) }}" class="btn btn-warning action-btn">
                    <i class="bi bi-pencil me-2"></i>Düzenle
                </a>
                <a href="{{ route('policies.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <!-- Tarih Bilgileri -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                <i class="bi bi-calendar-check stat-icon text-success"></i>
                <div class="stat-label">Başlangıç Tarihi</div>
                <div class="stat-value">{{ $policy->start_date->format('d.m.Y') }}</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="stat-box">
                <i class="bi bi-calendar-x stat-icon text-danger"></i>
                <div class="stat-label">Bitiş Tarihi</div>
                <div class="stat-value">{{ $policy->end_date->format('d.m.Y') }}</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="stat-box">
                @php
                    $daysLeft = $policy->days_until_expiry;
                    $iconClass = $daysLeft <= 7 ? 'text-danger' : ($daysLeft <= 30 ? 'text-warning' : 'text-info');
                @endphp
                <i class="bi bi-clock-history stat-icon {{ $iconClass }}"></i>
                <div class="stat-label">Kalan Süre</div>
                @if($daysLeft > 0)
                    <div class="stat-value">{{ $daysLeft }} Gün</div>
                @elseif($daysLeft === 0)
                    <div class="stat-value text-danger">Bugün Bitiyor</div>
                @else
                    <div class="stat-value text-danger">{{ abs($daysLeft) }} Gün Önce</div>
                @endif
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
                            <a href="{{ route('customers.show', $policy->customer) }}" class="customer-link">
                                {{ $policy->customer->name }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">
                            <a href="tel:{{ $policy->customer->phone }}" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone me-1"></i>{{ $policy->customer->phone }}
                            </a>
                        </div>
                    </div>

                    @if($policy->customer->email)
                    <div class="info-item">
                        <div class="info-label">E-posta</div>
                        <div class="info-value">
                            <a href="mailto:{{ $policy->customer->email }}" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope me-1"></i>{{ $policy->customer->email }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($policy->customer->city)
                    <div class="info-item">
                        <div class="info-label">Şehir</div>
                        <div class="info-value">
                            <i class="bi bi-geo-alt me-1"></i>{{ $policy->customer->city }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sigorta Şirketi -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-building"></i>
                        <span>Sigorta Şirketi</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Şirket Adı</div>
                        <div class="info-value">{{ $policy->insuranceCompany->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Şirket Kodu</div>
                        <div class="info-value">{{ $policy->insuranceCompany->code }}</div>
                    </div>

                    @if($policy->insuranceCompany->phone)
                    <div class="info-item">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">
                            <i class="bi bi-telephone me-1"></i>{{ $policy->insuranceCompany->phone }}
                        </div>
                    </div>
                    @endif

                    @if($policy->insuranceCompany->website)
                    <div class="info-item">
                        <div class="info-label">Website</div>
                        <div class="info-value">
                            <a href="{{ $policy->insuranceCompany->website }}" target="_blank" class="text-decoration-none">
                                <i class="bi bi-globe me-1"></i>Siteye Git
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Araç/Konut Bilgileri -->
            @if($policy->isVehiclePolicy())
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-car-front"></i>
                        <span>Araç Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Plaka</div>
                        <div class="info-value text-primary" style="font-size: 1.25rem;">{{ $policy->vehicle_plate }}</div>
                    </div>

                    @if($policy->vehicle_brand || $policy->vehicle_model)
                    <div class="info-item">
                        <div class="info-label">Marka / Model</div>
                        <div class="info-value">{{ $policy->vehicle_brand }} {{ $policy->vehicle_model }}</div>
                    </div>
                    @endif

                    @if($policy->vehicle_year)
                    <div class="info-item">
                        <div class="info-label">Model Yılı</div>
                        <div class="info-value">{{ $policy->vehicle_year }}</div>
                    </div>
                    @endif

                    @if($policy->vehicle_chassis_no)
                    <div class="info-item">
                        <div class="info-label">Ruhsat Seri No</div>
                        <div class="info-value">
                            <small class="font-monospace">{{ $policy->vehicle_chassis_no }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @elseif($policy->isPropertyPolicy())
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-house"></i>
                        <span>Konut Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Adres</div>
                        <div class="info-value">{{ $policy->property_address }}</div>
                    </div>

                    @if($policy->property_area)
                    <div class="info-item">
                        <div class="info-label">Brüt Alan</div>
                        <div class="info-value">{{ $policy->property_area }} m²</div>
                    </div>
                    @endif

                    @if($policy->property_floor)
                    <div class="info-item">
                        <div class="info-label">Kat Numarası</div>
                        <div class="info-value">{{ $policy->property_floor }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Mali Bilgiler -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-cash-stack"></i>
                        <span>Mali Bilgiler</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="summary-item">
                        <span>Prim Tutarı</span>
                        <strong>{{ number_format($policy->premium_amount, 2) }} ₺</strong>
                    </div>
                    <div class="summary-item">
                        <span>Komisyon Oranı</span>
                        <strong>% {{ number_format($policy->commission_rate, 2) }}</strong>
                    </div>
                    <div class="summary-item">
                        <span>Komisyon Tutarı</span>
                        <strong class="text-success">{{ number_format($policy->commission_amount, 2) }} ₺</strong>
                    </div>
                    <div class="summary-item">
                        <span>Ödeme Şekli</span>
                        <strong>{{ $policy->payment_type === 'cash' ? 'Peşin' : 'Taksitli' }}</strong>
                    </div>
                    @if($policy->payment_type === 'installment')
                    <div class="summary-item">
                        <span>Taksit Sayısı</span>
                        <strong>{{ $policy->installment_count }} Taksit</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Modern Tabs -->
            <ul class="nav nav-tabs-modern" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment">
                        <i class="bi bi-credit-card me-2"></i>Ödeme Planı
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#renewal">
                        <i class="bi bi-arrow-repeat me-2"></i>Yenileme
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reminders">
                        <i class="bi bi-bell me-2"></i>Hatırlatıcılar
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notes">
                        <i class="bi bi-sticky me-2"></i>Notlar
                    </button>
                </li>
            </ul>

            <!-- Tab Contents -->
            <div class="tab-content">
                <!-- Ödeme Planı -->
                <div class="tab-pane fade show active" id="payment">
                    <div class="content-card card">
                        <div class="card-body">
                            @if($policy->paymentPlan)
                                @if($policy->paymentPlan->installments->isEmpty())
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h6 class="text-muted mb-1">Taksit Bilgisi Yok</h6>
                                        <p class="text-muted small mb-0">Henüz taksit bilgisi girilmemiş.</p>
                                    </div>
                                @else
                                    <!-- Ödeme Özeti -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-3">
                                            <div class="summary-box">
                                                <div class="stat-label">Toplam Tutar</div>
                                                <div class="h5 mb-0">{{ number_format($policy->paymentPlan->total_amount, 2) }} ₺</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="summary-box border-success">
                                                <div class="stat-label text-success">Ödenen</div>
                                                <div class="h5 mb-0 text-success">{{ number_format($policy->paymentPlan->paid_amount, 2) }} ₺</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="summary-box border-danger">
                                                <div class="stat-label text-danger">Kalan</div>
                                                <div class="h5 mb-0 text-danger">{{ number_format($policy->paymentPlan->remaining_amount, 2) }} ₺</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="summary-box">
                                                <div class="stat-label">İlerleme</div>
                                                <div class="h5 mb-0">% {{ $policy->paymentPlan->payment_progress }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Taksit Listesi -->
                                    <div class="table-responsive">
                                        <table class="table table-modern">
                                            <thead>
                                                <tr>
                                                    <th>Taksit</th>
                                                    <th>Tutar</th>
                                                    <th>Vade Tarihi</th>
                                                    <th>Ödeme Tarihi</th>
                                                    <th>Yöntem</th>
                                                    <th>Durum</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($policy->paymentPlan->installments as $installment)
                                                <tr>
                                                    <td><strong>{{ $installment->installment_number }}</strong></td>
                                                    <td><strong>{{ number_format($installment->amount, 2) }} ₺</strong></td>
                                                    <td>{{ $installment->due_date->format('d.m.Y') }}</td>
                                                    <td>
                                                        @if($installment->paid_date)
                                                            {{ $installment->paid_date->format('d.m.Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($installment->payment_method)
                                                            <span class="badge bg-light text-dark border">
                                                                {{ $installment->payment_method_label }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-modern bg-{{ $installment->status_color }}">
                                                            {{ $installment->status_label }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-credit-card"></i>
                                    <h6 class="text-muted mb-1">Ödeme Planı Yok</h6>
                                    <p class="text-muted small mb-0">Henüz ödeme planı oluşturulmamış.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Yenileme -->
                <div class="tab-pane fade" id="renewal">
                    <div class="content-card card">
                        <div class="card-body">
                            @if($policy->renewal)
                                <div class="summary-box border-info">
                                    <h6 class="mb-3">
                                        <i class="bi bi-info-circle me-2"></i>Yenileme Süreci
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-label">Durum</div>
                                            <div class="info-value">{{ $policy->renewal->status_label }}</div>
                                        </div>
                                        @if($policy->renewal->contacted_at)
                                        <div class="col-md-6">
                                            <div class="info-label">İletişim Tarihi</div>
                                            <div class="info-value">{{ $policy->renewal->contacted_at->format('d.m.Y') }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    @if($policy->renewal->notes)
                                        <hr class="my-3">
                                        <p class="mb-0 text-muted">{{ $policy->renewal->notes }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <h6 class="text-muted mb-2">Yenileme Süreci Başlatılmamış</h6>
                                    <p class="text-muted small mb-3">Poliçe yenileme süreci henüz başlatılmamış.</p>
                                    @if($policy->status === 'expiring_soon' || $policy->status === 'critical')
                                        <button class="btn btn-primary action-btn" disabled>
                                            <i class="bi bi-plus-circle me-2"></i>Yenileme Başlat
                                        </button>
                                        <p class="text-muted mt-2 small">Yakında aktif olacak</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hatırlatıcılar -->
                <div class="tab-pane fade" id="reminders">
                    <div class="content-card card">
                        <div class="card-body">
                            @if($policy->reminders->isEmpty())
                                <div class="empty-state">
                                    <i class="bi bi-bell-slash"></i>
                                    <h6 class="text-muted mb-1">Hatırlatıcı Yok</h6>
                                    <p class="text-muted small mb-0">Bu poliçe için hatırlatıcı bulunmuyor.</p>
                                </div>
                            @else
                                @foreach($policy->reminders->sortBy('reminder_date') as $reminder)
                                <div class="timeline-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $reminder->reminder_type_label }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $reminder->reminder_date->format('d.m.Y') }}
                                                <i class="bi bi-send ms-3 me-1"></i>{{ ucfirst($reminder->channel) }}
                                            </small>
                                        </div>
                                        <span class="badge badge-modern bg-{{ $reminder->status === 'sent' ? 'success' : ($reminder->status === 'failed' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($reminder->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notlar -->
                <div class="tab-pane fade" id="notes">
                    <div class="content-card card">
                        <div class="card-body">
                            @if($policy->notes)
                                <div class="summary-box">
                                    <h6 class="mb-3">
                                        <i class="bi bi-sticky me-2"></i>Poliçe Notları
                                    </h6>
                                    <p class="mb-0">{{ $policy->notes }}</p>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-sticky"></i>
                                    <h6 class="text-muted mb-1">Not Yok</h6>
                                    <p class="text-muted small mb-0">Bu poliçe için not bulunmuyor.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
