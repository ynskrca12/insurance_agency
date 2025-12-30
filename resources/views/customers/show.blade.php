@extends('layouts.app')

@section('title', $customer->name . ' - Müşteri Detayı')

@push('styles')
<style>
    .customer-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .info-card {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        background: #ffffff;
    }

    .info-card .card-header {
        background: #fafafa;
        border: none;
        border-radius: 10px 10px 0 0 !important;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e8e8e8;
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
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        color: #212529;
        font-weight: 600;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .nav-tabs-modern {
        border: 1px solid #dcdcdc;
        background: #fafafa;
        border-radius: 10px;
        padding: 0.5rem;
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
        border-radius: 10px;
        background: #ffffff;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .table-modern thead th {
        border: none;
        background: #fafafa;
        color: #495057;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .table-modern tbody tr {
        background: #ffffff;
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        border-color: #b0b0b0;
        transform: translateY(-1px);
    }

    .table-modern tbody td {
        border: none;
        padding: 1rem;
        vertical-align: middle;
    }

    .table-modern tbody td:first-child {
        border-left: 1px solid #e8e8e8;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .table-modern tbody td:last-child {
        border-right: 1px solid #e8e8e8;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .timeline-item {
        padding: 1.25rem;
        border-left: 2px solid #e0e0e0;
        margin-left: 1rem;
        position: relative;
        transition: all 0.3s ease;
        background: #fafafa;
        border-radius: 0 8px 8px 0;
        margin-bottom: 0.75rem;
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

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .note-form {
        background: #fafafa;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .quick-action-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .quick-action-btn:hover {
        transform: scale(1.05);
        border-color: #b0b0b0;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        /* border: 1px solid #e0e0e0; */
    }

    .stat-box {
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        background: #f5f5f5;
        border-color: #d0d0d0;
    }

    .header-badge {
        background: #f5f5f5;
        border: 1px solid #dcdcdc;
        color: #495057;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .customer-header {
            padding: 1.5rem;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }
    }
</style>
<style>
    /* ============================================
       MOBILE OPTIMIZATION - PROFESSIONAL
    ============================================ */
    @media (max-width: 768px) {
        /* Customer Header Mobile */
        .customer-header {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .customer-header h1 {
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem;
        }

        .customer-header .d-flex.gap-3 {
            gap: 0.5rem !important;
        }

        .customer-header .header-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Action Buttons Mobile */
        .customer-header .d-flex.gap-2 {
            width: 100%;
            margin-top: 1rem;
        }

        .customer-header .action-btn {
            flex: 1;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        /* Quick Stats Grid Mobile */
        .customer-header .row.g-3 {
            margin-top: 1rem !important;
            gap: 0.75rem !important;
        }

        .customer-header .col-6 {
            padding: 0 !important;
        }

        .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 18px;
            margin-right: 0.5rem !important;
        }
        .stat-box {
            margin: 2px;
            padding: 12px 5px;
        }

        .stat-box .h4 {
            font-size: 1.25rem !important;
        }

        .stat-box small {
            font-size: 0.7rem;
        }

        /* Sidebar Mobile - Full Width */
        .col-lg-4 {
            order: 2;
        }

        .col-lg-8 {
            order: 1;
        }

        /* Info Cards Mobile */
        .info-card {
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .info-card .card-header {
            padding: 0.75rem 1rem;
            border-radius: 8px 8px 0 0 !important;
        }

        .info-card .card-header h6 {
            font-size: 0.875rem;
        }

        .info-card .card-body {
            padding: 1rem;
        }

        .info-item {
            padding: 0.625rem 0;
        }

        .info-label {
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.875rem;
        }

        .quick-action-btn {
            width: 2rem;
            height: 2rem;
            font-size: 14px;
        }

        /* Tabs Mobile - Horizontal Scroll */
        .nav-tabs-modern {
            border-radius: 8px;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .nav-tabs-modern::-webkit-scrollbar {
            display: none;
        }

        .nav-tabs-modern .nav-item {
            display: inline-block;
        }

        .nav-tabs-modern .nav-link {
            font-size: 0.8125rem;
            border-radius: 6px;
        }

        .nav-tabs-modern .nav-link span:not(.badge) {
            display: inline;
        }

        .nav-tabs-modern .badge {
            padding: 2px 6px;
            font-size: 0.7rem;
        }

        /* Tab Content Mobile */
        .content-card {
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .content-card .card-body {
            padding: 1rem;
        }

        /* Table Mobile - Card View */
        .table-responsive {
            margin: 0;
            padding: 0 !important;
        }

        .table-modern {
            display: none;
        }

        /* Policy Card Mobile */
        .policy-card-mobile {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .policy-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .policy-card-number {
            font-size: 0.875rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 0.25rem;
        }

        .policy-card-type {
            font-size: 0.75rem;
        }

        .policy-card-body {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .policy-info-item {
            display: flex;
            flex-direction: column;
        }

        .policy-info-label {
            font-size: 0.7rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .policy-info-value {
            font-size: 0.875rem;
            color: #1e293b;
            font-weight: 600;
        }

        .policy-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid #f1f5f9;
        }

        .policy-card-action {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        /* Timeline Mobile */
        .timeline-item {
            padding: 0.875rem;
            margin-left: 0.5rem;
            margin-bottom: 0.625rem;
            border-radius: 0 6px 6px 0;
        }

        .timeline-item::before {
            left: -0.375rem;
            top: 1rem;
            width: 0.625rem;
            height: 0.625rem;
        }

        .timeline-item strong,
        .timeline-item p {
            font-size: 0.875rem;
        }

        .timeline-item small {
            font-size: 0.75rem;
        }

        /* Note Form Mobile */
        .note-form {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .note-form label {
            font-size: 0.875rem;
        }

        .note-form textarea {
            font-size: 0.875rem;
        }

        .note-form .btn-sm {
            font-size: 0.8125rem;
            padding: 0.5rem 0.875rem;
        }

        /* Empty State Mobile */
        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state h6 {
            font-size: 0.9375rem;
        }

        .empty-state p {
            font-size: 0.8125rem;
        }

        .empty-state .btn-sm {
            font-size: 0.8125rem;
        }

        /* Badge Mobile */
        .badge-modern {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        /* Row Gap Mobile */
        .row.g-4 {
            gap: 1rem !important;
        }
    }

    /* Ultra Small Screens */
    @media (max-width: 374px) {
        .customer-header h1 {
            font-size: 1.125rem !important;
        }

        .stat-box .h4 {
            font-size: 1.125rem !important;
        }

        .stat-box small {
            font-size: 0.65rem;
        }

        .nav-tabs-modern .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        .policy-card-mobile {
            padding: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Clean Header -->
<div class="customer-header">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-2">
                <h1 class="h2 mb-0 fw-bold text-dark">{{ $customer->name }}</h1>
                @if($customer->isVIP())
                    <span class="badge bg-warning text-dark badge-modern">
                        <i class="bi bi-star-fill"></i> VIP
                    </span>
                @endif
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap text-muted">
                <span><i class="bi bi-hash me-1"></i>{{ $customer->id }}</span>
                <span><i class="bi bi-calendar-check me-1"></i>{{ $customer->created_at->format('d.m.Y') }}</span>
                @php
                    $statusLabels = [
                        'active' => 'Aktif Müşteri',
                        'potential' => 'Potansiyel',
                        'passive' => 'Pasif',
                        'lost' => 'Kayıp',
                    ];
                @endphp
                <span class="header-badge">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                    {{ $statusLabels[$customer->status] }}
                </span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning action-btn">
                <i class="bi bi-pencil me-2"></i>Düzenle
            </a>
            <a href="{{ route('customers.index') }}" class="btn btn-light action-btn">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-3">
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-primary me-3">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $customer->total_policies }}</div>
                        <small class="text-muted">Toplam Poliçe</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-success me-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ number_format($customer->total_premium, 0) }}₺</div>
                        <small class="text-muted">Toplam Prim</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-info me-3">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ number_format($customer->lifetime_value, 0) }}₺</div>
                        <small class="text-muted">Komisyon</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-box">
                <div class="d-flex align-items-center">
                    <div class="stat-icon text-danger me-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <span class="badge badge-modern bg-{{ $customer->risk_score >= 70 ? 'danger' : ($customer->risk_score >= 40 ? 'warning' : 'success') }}">
                            {{ $customer->risk_score }}/100
                        </span>
                        <small class="text-muted d-block">Risk Skoru</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sol Sidebar - Bilgiler -->
    <div class="col-lg-4">
        <!-- İletişim Bilgileri -->
        <div class="info-card card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="bi bi-telephone text-primary me-2"></i>İletişim Bilgileri
                </h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <div class="info-label">Telefon</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="info-value">{{ $customer->phone }}</span>
                        <a href="tel:{{ $customer->phone }}" class="quick-action-btn btn btn-light">
                            <i class="bi bi-telephone text-primary"></i>
                        </a>
                    </div>
                </div>

                @if($customer->phone_secondary)
                <div class="info-item">
                    <div class="info-label">İkinci Telefon</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="info-value">{{ $customer->phone_secondary }}</span>
                        <a href="tel:{{ $customer->phone_secondary }}" class="quick-action-btn btn btn-light">
                            <i class="bi bi-telephone text-primary"></i>
                        </a>
                    </div>
                </div>
                @endif

                @if($customer->email)
                <div class="info-item">
                    <div class="info-label">E-posta</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="info-value text-break">{{ $customer->email }}</span>
                        <a href="mailto:{{ $customer->email }}" class="quick-action-btn btn btn-light">
                            <i class="bi bi-envelope text-primary"></i>
                        </a>
                    </div>
                </div>
                @endif

                @if($customer->id_number)
                <div class="info-item">
                    <div class="info-label">TC Kimlik No</div>
                    <span class="info-value">{{ $customer->id_number }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Kişisel Bilgiler -->
        <div class="info-card card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="bi bi-person-badge text-info me-2"></i>Kişisel Bilgiler
                </h6>
            </div>
            <div class="card-body">
                @if($customer->birth_date)
                <div class="info-item">
                    <div class="info-label">Doğum Tarihi & Yaş</div>
                    <span class="info-value">{{ $customer->birth_date->format('d.m.Y') }}</span>
                    <span class="badge badge-modern bg-light text-dark border ms-2">{{ $customer->birth_date->age }} yaş</span>
                </div>
                @endif

                @if($customer->occupation)
                <div class="info-item">
                    <div class="info-label">Meslek</div>
                    <span class="info-value">{{ $customer->occupation }}</span>
                </div>
                @endif

                @if($customer->workplace)
                <div class="info-item">
                    <div class="info-label">İş Yeri</div>
                    <span class="info-value">{{ $customer->workplace }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Adres -->
        @if($customer->address || $customer->city)
        <div class="info-card card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="bi bi-geo-alt text-danger me-2"></i>Adres Bilgileri
                </h6>
            </div>
            <div class="card-body">
                @if($customer->address)
                <div class="info-item">
                    <div class="info-label">Adres</div>
                    <span class="info-value">{{ $customer->address }}</span>
                </div>
                @endif

                @if($customer->city || $customer->district)
                <div class="info-item">
                    <div class="info-label">Şehir / İlçe</div>
                    <span class="info-value">
                        {{ $customer->district ? $customer->district . ' / ' : '' }}
                        {{ $customer->city }}
                    </span>
                </div>
                @endif

                @if($customer->postal_code)
                <div class="info-item">
                    <div class="info-label">Posta Kodu</div>
                    <span class="info-value">{{ $customer->postal_code }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Ana İçerik -->
    <div class="col-lg-8">
        <!-- Modern Tabs -->
        <ul class="nav nav-tabs-modern mb-4" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#policies">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span>Poliçeler</span>
                    <span class="badge badge-modern bg-primary ms-2">{{ $customer->policies->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quotations">
                    <i class="bi bi-file-earmark-plus me-2"></i>
                    <span>Teklifler</span>
                    <span class="badge badge-modern bg-secondary ms-2">{{ $customer->quotations->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notes">
                    <i class="bi bi-sticky me-2"></i>
                    <span>Notlar</span>
                    <span class="badge badge-modern bg-secondary ms-2">{{ $customer->customerNotes->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#calls">
                    <i class="bi bi-telephone me-2"></i>
                    <span>Aramalar</span>
                    <span class="badge badge-modern bg-secondary ms-2">{{ $customer->customerCalls->count() }}</span>
                </button>
            </li>
        </ul>

        <!-- Tab İçerikleri -->
        <div class="tab-content">
        <!-- Poliçeler -->
        <div class="tab-pane fade show active" id="policies">
            <div class="content-card card">
                <div class="card-body p-0">
                    @if($customer->policies->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h6 class="text-muted mb-2">Henüz Poliçe Bulunmuyor</h6>
                            <p class="text-muted small mb-3">Bu müşteriye ait henüz bir poliçe kaydı eklenmemiş.</p>
                            <a href="{{ route('policies.create') }}" class="btn btn-primary btn-sm action-btn">
                                <i class="bi bi-plus-circle me-2"></i>Yeni Poliçe Ekle
                            </a>
                        </div>
                    @else
                        <!-- Desktop Table View -->
                        <div class="table-responsive p-3 d-none d-md-block">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Poliçe No</th>
                                        <th>Tür</th>
                                        <th>Şirket</th>
                                        <th>Başlangıç</th>
                                        <th>Bitiş</th>
                                        <th>Prim</th>
                                        <th>Durum</th>
                                        <th class="text-center">İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->policies as $policy)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $policy->policy_number }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-modern bg-info">
                                                {{ $policy->policy_type_label }}
                                            </span>
                                        </td>
                                        <td>{{ $policy->insuranceCompany->name }}</td>
                                        <td>
                                            <small class="text-muted">{{ $policy->start_date->format('d.m.Y') }}</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $policy->end_date->format('d.m.Y') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($policy->premium_amount, 2) }} ₺</strong>
                                        </td>
                                        <td>
                                            @php
                                                $statusConfig = [
                                                    'active' => ['color' => 'success', 'label' => 'Aktif'],
                                                    'expiring_soon' => ['color' => 'warning', 'label' => 'Yakında Bitiyor'],
                                                    'critical' => ['color' => 'danger', 'label' => 'Kritik'],
                                                    'expired' => ['color' => 'secondary', 'label' => 'Süresi Bitti'],
                                                    'renewed' => ['color' => 'info', 'label' => 'Yenilendi'],
                                                    'cancelled' => ['color' => 'dark', 'label' => 'İptal'],
                                                ];
                                                $config = $statusConfig[$policy->status] ?? ['color' => 'secondary', 'label' => $policy->status];
                                            @endphp
                                            <span class="badge badge-modern bg-{{ $config['color'] }}">
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('policies.show', $policy) }}"
                                            class="quick-action-btn btn btn-light"
                                            title="Detaylar">
                                                <i class="bi bi-eye text-primary"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="d-md-none p-3">
                            @foreach($customer->policies as $policy)
                                @php
                                    $statusConfig = [
                                        'active' => ['color' => 'success', 'label' => 'Aktif'],
                                        'expiring_soon' => ['color' => 'warning', 'label' => 'Yakında Bitiyor'],
                                        'critical' => ['color' => 'danger', 'label' => 'Kritik'],
                                        'expired' => ['color' => 'secondary', 'label' => 'Süresi Bitti'],
                                        'renewed' => ['color' => 'info', 'label' => 'Yenilendi'],
                                        'cancelled' => ['color' => 'dark', 'label' => 'İptal'],
                                    ];
                                    $config = $statusConfig[$policy->status] ?? ['color' => 'secondary', 'label' => $policy->status];
                                @endphp

                                <div class="policy-card-mobile">
                                    <!-- Card Header -->
                                    <div class="policy-card-header">
                                        <div>
                                            <div class="policy-card-number">{{ $policy->policy_number }}</div>
                                            <span class="badge badge-modern bg-info policy-card-type">
                                                {{ $policy->policy_type_label }}
                                            </span>
                                        </div>
                                        <span class="badge badge-modern bg-{{ $config['color'] }}">
                                            {{ $config['label'] }}
                                        </span>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="policy-card-body">
                                        <div class="policy-info-item">
                                            <div class="policy-info-label">Şirket</div>
                                            <div class="policy-info-value">{{ $policy->insuranceCompany->name }}</div>
                                        </div>

                                        <div class="policy-info-item">
                                            <div class="policy-info-label">Prim Tutarı</div>
                                            <div class="policy-info-value text-success">{{ number_format($policy->premium_amount, 2) }} ₺</div>
                                        </div>

                                        <div class="policy-info-item">
                                            <div class="policy-info-label">Başlangıç</div>
                                            <div class="policy-info-value">{{ $policy->start_date->format('d.m.Y') }}</div>
                                        </div>

                                        <div class="policy-info-item">
                                            <div class="policy-info-label">Bitiş</div>
                                            <div class="policy-info-value">{{ $policy->end_date->format('d.m.Y') }}</div>
                                        </div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="policy-card-footer">
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ $policy->created_at->diffForHumans() }}
                                        </span>
                                        <a href="{{ route('policies.show', $policy) }}" class="policy-card-action">
                                            <i class="bi bi-eye"></i>
                                            Detay
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

            <!-- Teklifler -->
            <div class="tab-pane fade" id="quotations">
                <div class="content-card card">
                    <div class="card-body">
                        @if($customer->quotations->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-file-earmark-plus"></i>
                                <h6 class="text-muted mb-2">Henüz Teklif Bulunmuyor</h6>
                                <p class="text-muted small mb-0">Bu müşteriye ait henüz bir teklif kaydı eklenmemiş.</p>
                            </div>
                        @else
                            @foreach($customer->quotations as $quotation)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <strong>{{ $quotation->quotation_number }}</strong>
                                            <span class="badge badge-modern bg-info">
                                                {{ $quotation->quotation_type }}
                                            </span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            Geçerlilik: {{ $quotation->valid_until->format('d.m.Y') }}
                                        </small>
                                    </div>
                                    <span class="badge badge-modern bg-{{ $quotation->status === 'converted' ? 'success' : 'warning' }}">
                                        {{ $quotation->status === 'converted' ? 'Poliçeye Dönüştü' : 'Beklemede' }}
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
                        <!-- Alert Container (AJAX mesajları için) -->
                        <div id="noteAlertContainer"></div>

                        <!-- Not Ekleme Formu -->
                        <form id="addNoteForm" class="note-form">
                            @csrf
                            <label class="form-label fw-semibold mb-2 text-dark">
                                <i class="bi bi-pencil-square me-1"></i>Yeni Not Ekle
                            </label>

                            <!-- Not Tipi Seçimi -->
                            <div class="mb-3">
                                <select class="form-select border" id="note_type" name="note_type" style="border-color: #dcdcdc;">
                                    <option value="note">📝 Genel Not</option>
                                    <option value="call">📞 Telefon Görüşmesi</option>
                                    <option value="meeting">👥 Toplantı</option>
                                    <option value="email">📧 E-posta</option>
                                    <option value="sms">💬 SMS</option>
                                </select>
                            </div>

                            <!-- Not İçeriği -->
                            <div class="input-group">
                                <textarea class="form-control border"
                                        id="newNote"
                                        name="note"
                                        rows="3"
                                        placeholder="Müşteri hakkında not ekleyin..."
                                        style="resize: none; border-color: #dcdcdc;"
                                        required></textarea>
                            </div>

                            <!-- Sonraki İşlem Tarihi (Opsiyonel) -->
                            <div class="mt-3">
                                <label class="form-label small text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>Sonraki İşlem Tarihi (Opsiyonel)
                                </label>
                                <input type="date"
                                    class="form-control border"
                                    id="next_action_date"
                                    name="next_action_date"
                                    style="border-color: #dcdcdc;">
                            </div>

                            <!-- Form Butonları -->
                            <div class="d-flex justify-content-end mt-3 gap-2">
                                <button type="button"
                                        class="btn btn-light btn-sm action-btn"
                                        onclick="document.getElementById('addNoteForm').reset()">
                                    <i class="bi bi-x-circle me-1"></i>Temizle
                                </button>
                                <button type="submit"
                                        class="btn btn-primary btn-sm action-btn"
                                        id="submitNoteBtn">
                                    <i class="bi bi-check-circle me-1"></i>Notu Kaydet
                                </button>
                            </div>
                        </form>

                        <!-- Notlar Listesi Container -->
                        <div id="notesListContainer" class="mt-4">
                            @if($customer->customerNotes->isEmpty())
                                <div class="empty-state" id="emptyNotesState">
                                    <i class="bi bi-sticky"></i>
                                    <h6 class="text-muted mb-2">Henüz Not Bulunmuyor</h6>
                                    <p class="text-muted small mb-0">Müşteri ile ilgili önemli bilgileri not olarak ekleyebilirsiniz.</p>
                                </div>
                            @else
                                <div id="notesList">
                                    @foreach($customer->customerNotes->sortByDesc('created_at') as $note)
                                        @include('customers.partials.note-item', ['note' => $note])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aramalar -->
            <div class="tab-pane fade" id="calls">
                <div class="content-card card">
                    <div class="card-body">
                        @if($customer->customerCalls->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-telephone"></i>
                                <h6 class="text-muted mb-2">Henüz Arama Kaydı Bulunmuyor</h6>
                                <p class="text-muted small mb-0">Müşteri ile yapılan aramalar burada görüntülenecektir.</p>
                            </div>
                        @else
                            @foreach($customer->customerCalls->sortByDesc('called_at') as $call)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge badge-modern bg-{{ $call->outcome === 'answered' ? 'success' : 'warning' }}">
                                            {{ $call->outcome_label }}
                                        </span>
                                        @if($call->duration)
                                            <span class="badge badge-modern bg-light text-dark border">
                                                <i class="bi bi-stopwatch me-1"></i>{{ $call->duration_in_minutes }} dk
                                            </span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        {{ $call->called_at->format('d.m.Y H:i') }}
                                    </small>
                                </div>
                                @if($call->notes)
                                    <p class="mb-2 text-dark">{{ $call->notes }}</p>
                                @endif
                                <small class="text-muted">
                                    <i class="bi bi-person-circle me-1"></i>
                                    <strong>{{ $call->user->name }}</strong>
                                </small>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#addNoteForm').on('submit', function(e) {
        e.preventDefault();

        const note = $('#newNote').val().trim();
        if (!note) {
            showNoteAlert('Lütfen bir not giriniz.', 'warning');
            return;
        }

        const submitBtn = $('#submitNoteBtn');
        const originalBtnText = submitBtn.html();

        // Butonu devre dışı bırak
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-1"></span>Kaydediliyor...');

        const formData = {
            note: note,
            note_type: $('#note_type').val(),
            next_action_date: $('#next_action_date').val() || null,
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: '{{ route("customers.addNote", $customer) }}',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Başarılı mesaj
                    showNoteAlert(response.message, 'success');

                    // Formu temizle
                    $('#addNoteForm')[0].reset();

                    // Empty state'i kaldır
                    $('#emptyNotesState').remove();

                    // notesList div'i yoksa oluştur
                    if ($('#notesList').length === 0) {
                        $('#notesListContainer').html('<div id="notesList"></div>');
                    }

                    // Yeni notu listeye ekle
                    addNoteToList(response.note);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Not eklenirken bir hata oluştu.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage = errors.join('<br>');
                }

                showNoteAlert(errorMessage, 'danger');
            },
            complete: function() {
                // Butonu tekrar aktif et
                submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });

    // Yeni notu listeye ekle
    function addNoteToList(note) {
        const noteTypeEmojis = {
            'note': '📝',
            'call': '📞',
            'meeting': '👥',
            'email': '📧',
            'sms': '💬'
        };

        const emoji = noteTypeEmojis[note.note_type] || '📝';

        const nextActionBadge = note.next_action_date ?
            `<div class="mb-2">
                <span class="badge bg-warning text-dark">
                    <i class="bi bi-calendar-event me-1"></i>
                    Sonraki işlem: ${note.next_action_date}
                </span>
            </div>` : '';

        const noteHtml = `
            <div class="timeline-item new-note" data-note-id="${note.id}" style="animation: slideInDown 0.5s;">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge badge-modern bg-light text-dark border">
                        ${emoji} ${note.note_type_label}
                    </span>
                    <small class="text-muted">
                        <span class="badge bg-success">YENİ</span>
                        ${note.created_at}
                    </small>
                </div>
                <p class="mb-2 text-dark">${escapeHtml(note.note)}</p>
                ${nextActionBadge}
                <small class="text-muted">
                    <i class="bi bi-person-circle me-1"></i>
                    <strong>${note.user_name}</strong>
                </small>
            </div>
        `;

        // Listeye en üste ekle
        $('#notesList').prepend(noteHtml);

        // 3 saniye sonra "YENİ" badge'ini kaldır
        setTimeout(function() {
            $('.new-note .badge-success').fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }

    function showNoteAlert(message, type = 'info') {
        const icons = {
            'success': 'check-circle-fill',
            'danger': 'exclamation-triangle-fill',
            'warning': 'exclamation-circle-fill',
            'info': 'info-circle-fill'
        };

        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi bi-${icons[type]} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        $('#noteAlertContainer').html(alertHtml);

        setTimeout(function() {
            $('#noteAlertContainer .alert').fadeOut(function() {
                $(this).remove();
            });
        }, 5000);

        $('html, body').animate({
            scrollTop: $('#noteAlertContainer').offset().top - 100
        }, 300);
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    $('.nav-tabs-modern .nav-link').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.nav-tabs-modern').offset().top - 100
        }, 300);
    });
});

const style = document.createElement('style');
style.textContent = `
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .timeline-item {
        padding: 1rem;
        border-left: 3px solid #e2e8f0;
        margin-bottom: 1rem;
        background: #f8fafc;
        border-radius: 0 8px 8px 0;
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        border-left-color: #3b82f6;
        background: #eff6ff;
        transform: translateX(5px);
    }

    .timeline-item.new-note {
        border-left-color: #10b981;
        background: linear-gradient(90deg, #f0fdf4 0%, #f8fafc 100%);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
`;
document.head.appendChild(style);
</script>
@endpush
