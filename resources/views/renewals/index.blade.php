@extends('layouts.app')

@section('title', 'Poliçe Yenilemeleri')

@push('styles')
<style>
    .table-danger {
        background-color: #f8d7da !important;
    }
    .table-warning {
        background-color: #fff3cd !important;
    }
    .dataTables_length, .dataTables_filter {
        padding: 1rem 1.25rem;
    }

    .dataTables_info, .dataTables_paginate {
        padding: 1rem 1.25rem;
    }
    .dt-buttons {
        margin-bottom: 1rem;
    }
    .dt-buttons .btn {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
    }
    .dataTables_paginate .paginate_button {
        padding: 0px 2px;
        margin: 0 2px;
        border-radius: 6px;
        cursor: pointer;
    }

    .dataTables_paginate .paginate_button.current {
        background: #1f3c88 !important;
        color: white !important;
        border-color: #1f3c88 !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f1f1f1;
    }
    .filter-card,
    .main-card {
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
    }
    .filter-card .card-body {
        padding: 1.5rem;
    }
    .main-card .card-body {
        padding: 1.5rem;
    }

    .main-card td {
        vertical-align: middle;
    }
        .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .stat-card .card-body {
        padding: 1rem;
        text-align: center;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }
    .action-buttons {
        display: flex;
        gap: 0.25rem;
        justify-content: end
    }
    .btn-icon {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        color: #6c757d;
        transition: all 0.3s ease;
    }
</style>

<style>

    /* ============================================
       MOBILE OPTIMIZATION - PROFESSIONAL
    ============================================ */

    /* Mobile Cards Container */
    .mobile-cards-container {
        display: none;
    }

    /* Renewal Card Mobile */
    .renewal-card-mobile {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .renewal-card-mobile:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Priority Indicator Stripe */
    .renewal-card-stripe {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
    }

    .renewal-card-stripe.critical {
        background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
    }

    .renewal-card-stripe.high {
        background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
    }

    .renewal-card-stripe.normal {
        background: linear-gradient(180deg, #0ea5e9 0%, #0284c7 100%);
    }

    .renewal-card-stripe.low {
        background: linear-gradient(180deg, #94a3b8 0%, #64748b 100%);
    }

    /* Status Badge Ribbon */
    .renewal-status-ribbon {
        position: absolute;
        top: 12px;
        right: -28px;
        width: 100px;
        text-align: center;
        padding: 3px 0;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        color: white;
        transform: rotate(45deg);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Card Header */
    .renewal-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        padding-left: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .renewal-card-policy {
        font-size: 15px;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 4px;
    }

    .renewal-card-customer {
        font-size: 13px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .renewal-card-phone {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .renewal-card-type {
        flex-shrink: 0;
        margin-left: 8px;
    }

    /* Days Left Alert Box */
    .renewal-days-alert {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 12px;
        margin-left: 12px;
        margin-right: 12px;
    }

    .renewal-days-alert.overdue {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 2px solid #fca5a5;
    }

    .renewal-days-alert.critical {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 2px solid #fcd34d;
    }

    .renewal-days-alert.urgent {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 2px solid #93c5fd;
    }

    .renewal-days-alert.normal {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #cbd5e1;
    }

    .renewal-days-icon {
        font-size: 28px;
        margin-right: 12px;
    }

    .renewal-days-content {
        flex: 1;
    }

    .renewal-days-value {
        font-size: 20px;
        font-weight: 700;
        line-height: 1.2;
    }

    .renewal-days-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        opacity: 0.8;
    }

    /* Card Body - Grid */
    .renewal-card-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
        padding-left: 12px;
    }

    .renewal-info-item {
        display: flex;
        flex-direction: column;
    }

    .renewal-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .renewal-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    /* Priority Badge */
    .priority-badge-mobile {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
    }

    .priority-badge-mobile i {
        font-size: 12px;
    }

    /* Card Actions */
    .renewal-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        padding-left: 12px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .renewal-action-btn {
        padding: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 13px;
        font-weight: 600;
    }

    .renewal-action-btn:active {
        transform: scale(0.95);
    }

    .renewal-action-btn i {
        font-size: 16px;
    }

    .renewal-action-btn.view {
        border-color: #3b82f6;
        background: #eff6ff;
        color: #3b82f6;
    }

    .renewal-action-btn.remind {
        border-color: #10b981;
        background: #f0fdf4;
        color: #10b981;
    }

    .renewal-action-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Mobile Search Bar */
    .mobile-search-bar {
        display: none;
        position: sticky;
        top: 60px;
        z-index: 100;
        background: white;
        padding: 12px 0;
        margin: -16px 0 16px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .mobile-search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #f8fafc;
    }

    .mobile-search-input:focus {
        outline: none;
        border-color: #2563eb;
        background: white;
    }

    .mobile-search-icon {
        position: absolute;
        left: 14px;
        top: 22px;
        color: #64748b;
    }

    /* Empty State */
    .empty-state-mobile {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-mobile i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .empty-state-mobile h3 {
        font-size: 18px;
        color: #475569;
        margin-bottom: 8px;
    }

    .empty-state-mobile p {
        font-size: 14px;
        color: #94a3b8;
    }

    /* ============================================
       RESPONSIVE - MOBILE VIEW
    ============================================ */
    @media (max-width: 768px) {
        /* Page Header Mobile */
        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
            padding: 0 16px;
        }

        .d-flex.justify-content-between h1 {
            font-size: 1.125rem !important;
        }

        .d-flex.justify-content-between > div:last-child {
            width: 100%;
            display: flex;
            gap: 8px;
        }

        .d-flex.justify-content-between > div:last-child .btn {
            flex: 1;
            font-size: 0.8125rem;
            padding: 0.5rem 0.75rem;
        }

        /* Stats Cards Mobile */
        .row.g-3.mb-4 {
            margin: 0 16px 16px 16px !important;
            gap: 8px !important;
        }

        .row.g-3.mb-4 > div {
            padding: 0 !important;
        }

        .stat-card .card-body {
            padding: 0;
        }

        .stat-value {
            font-size: 1.375rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        /* Filter Card Mobile */
        .card.mb-3 {
            margin: 0 16px 16px 16px !important;
            border-radius: 8px;
        }

        .card.mb-3 .card-body {
            padding: 12px;
        }

        .card.mb-3 .row {
            gap: 10px;
        }

        .card.mb-3 .col-md-2,
        .card.mb-3 .col-md-1 {
            width: 100%;
            padding: 0;
        }

        .card.mb-3 label {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .card.mb-3 .form-select,
        .card.mb-3 .form-control {
            font-size: 13px;
            padding: 8px 12px;
        }

        /* Hide Desktop Table */
        .main-card {
            display: none !important;
        }

        /* Show Mobile Cards */
        .mobile-cards-container {
            display: block;
            padding: 0 16px;
        }

        /* Show Mobile Search */
        .mobile-search-bar {
            display: block;
            margin: 0 16px 16px 16px;
        }
    }

    /* Small Mobile */
    @media (max-width: 374px) {
        .d-flex.justify-content-between h1 {
            font-size: 1rem !important;
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.65rem;
        }

        .renewal-card-mobile {
            padding: 0.875rem;
        }

        .renewal-days-alert {
            padding: 10px;
        }

        .renewal-days-value {
            font-size: 18px;
        }
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-arrow-repeat me-2"></i>Poliçe Yenilemeleri
        </h1>
        <p class="text-muted mb-0" id="renewalCount">
            Toplam: <strong>{{ $renewals->count() }}</strong> yenileme
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <!--  Kayıtları Oluştur Butonu -->
        @if(in_array(auth()->user()->role, ['owner', 'manager']))
        <a href="{{ route('renewals.generate') }}"
           class="btn btn-primary d-flex align-items-center"
           onclick="return confirm('⚙️ Yenileme Kayıtları Oluşturma\n\n• 90 gün içinde bitecek poliçeler taranacak\n• Yeni yenileme kayıtları oluşturulacak\n• Mevcut kayıtlar güncellenmeyecek\n\nDevam edilsin mi?')">
            <i class="bi bi-plus-circle-fill me-2"></i>
            <span class="d-none d-md-inline">Kayıtları Oluştur</span>
            <span class="d-inline d-md-none">Oluştur</span>
        </a>
        @endif

        <a href="{{ route('renewals.calendar') }}" class="btn btn-info text-white">
            <i class="bi bi-calendar3 me-2"></i>
            <span class="d-none d-md-inline">Takvim Görünümü</span>
            <span class="d-inline d-md-none">Takvim</span>
        </a>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
            <i class="bi bi-send me-2"></i>
            <span class="d-none d-md-inline">Toplu Hatırlatıcı</span>
            <span class="d-inline d-md-none">Hatırlat</span>
        </button>
    </div>
</div>


    <div class="row mb-4">
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                    <div class="stat-label">Toplam</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-success">{{ number_format($stats['pending']) }}</div>
                    <div class="stat-label">Bekliyor</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-warning">{{ number_format($stats['contacted']) }}</div>
                    <div class="stat-label">İletişimde</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-danger">{{ number_format($stats['critical']) }}</div>
                    <div class="stat-label">Kritik</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-secondary">{{ number_format($stats['renewed']) }}</div>
                    <div class="stat-label">Yenilendi</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-secondary">{{ number_format($stats['lost']) }}</div>
                    <div class="stat-label">Kaybedildi</div>
                </div>
            </div>
        </div>
    </div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-3">
            <!-- Durum -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Durum</label>
                <select id="filterStatus" class="form-select">
                    <option value="">Tüm Durumlar</option>
                    <option value="Bekliyor">Bekliyor</option>
                    <option value="İletişimde">İletişimde</option>
                    <option value="Yenilendi">Yenilendi</option>
                    <option value="Kaybedildi">Kaybedildi</option>
                </select>
            </div>

            <!-- Öncelik -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Öncelik</label>
                <select id="filterPriority" class="form-select">
                    <option value="">Tüm Öncelikler</option>
                    <option value="Düşük">Düşük</option>
                    <option value="Normal">Normal</option>
                    <option value="Yüksek">Yüksek</option>
                    <option value="Kritik">Kritik</option>
                </select>
            </div>

            <!-- Başlangıç Tarihi -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Başlangıç Tarihi</label>
                <input type="date" id="filterDateFrom" class="form-control">
            </div>

            <!-- Bitiş Tarihi -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Bitiş Tarihi</label>
                <input type="date" id="filterDateTo" class="form-control">
            </div>

            <!-- Temizle Butonu -->
            <div class="col-md-1">
                <label class="form-label small text-muted mb-1 d-none d-md-block">&nbsp;</label>
                <button type="button" class="btn btn-secondary w-100" onclick="clearFilters()">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile: Search Bar -->
<div class="mobile-search-bar">
    <i class="bi bi-search mobile-search-icon"></i>
    <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Poliçe, müşteri ara...">
</div>

<!-- Mobile: Card Görünümü -->
<div class="mobile-cards-container">
    @forelse($renewals as $renewal)
        @php
            $daysLeft = $renewal->days_until_renewal;
            $isOverdue = $daysLeft < 0;
            $isCritical = $daysLeft >= 0 && $daysLeft <= 7;
            $isUrgent = $daysLeft > 7 && $daysLeft <= 30;

            // Days Alert Config
            if ($isOverdue) {
                $daysAlertClass = 'overdue';
                $daysAlertIcon = 'bi-exclamation-triangle-fill';
                $daysAlertColor = '#ef4444';
                $daysAlertText = abs($daysLeft) . ' gün geçti';
            } elseif ($isCritical) {
                $daysAlertClass = 'critical';
                $daysAlertIcon = 'bi-clock-fill';
                $daysAlertColor = '#f59e0b';
                $daysAlertText = $daysLeft . ' gün kaldı';
            } elseif ($isUrgent) {
                $daysAlertClass = 'urgent';
                $daysAlertIcon = 'bi-calendar-check';
                $daysAlertColor = '#0ea5e9';
                $daysAlertText = $daysLeft . ' gün kaldı';
            } else {
                $daysAlertClass = 'normal';
                $daysAlertIcon = 'bi-calendar';
                $daysAlertColor = '#64748b';
                $daysAlertText = $daysLeft . ' gün kaldı';
            }

            // Priority Config
            $priorityConfig = [
                'low' => ['color' => 'secondary', 'label' => 'Düşük', 'stripe' => 'low'],
                'normal' => ['color' => 'info', 'label' => 'Normal', 'stripe' => 'normal'],
                'high' => ['color' => 'warning', 'label' => 'Yüksek', 'stripe' => 'high'],
                'critical' => ['color' => 'danger', 'label' => 'Kritik', 'stripe' => 'critical'],
            ];
            $priority = $priorityConfig[$renewal->priority] ?? ['color' => 'info', 'label' => 'Normal', 'stripe' => 'normal'];

            // Status Config
            $statusConfig = [
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor', 'ribbon' => '#f59e0b'],
                'contacted' => ['color' => 'info', 'label' => 'İletişimde', 'ribbon' => '#0ea5e9'],
                'renewed' => ['color' => 'success', 'label' => 'Yenilendi', 'ribbon' => '#10b981'],
                'lost' => ['color' => 'danger', 'label' => 'Kaybedildi', 'ribbon' => '#ef4444'],
            ];
            $status = $statusConfig[$renewal->status] ?? ['color' => 'secondary', 'label' => $renewal->status, 'ribbon' => '#6c757d'];
        @endphp

        <div class="renewal-card-mobile" data-renewal-id="{{ $renewal->id }}">
            <!-- Priority Stripe -->
            <div class="renewal-card-stripe {{ $priority['stripe'] }}"></div>

            <!-- Status Ribbon -->
            <div class="renewal-status-ribbon" style="background: {{ $status['ribbon'] }}">
                {{ $status['label'] }}
            </div>

            <!-- Card Header -->
            <div class="renewal-card-header">
                <div style="flex: 1; min-width: 0;">
                    @if($renewal->policy)
                        <div class="renewal-card-policy">{{ $renewal->policy->policy_number }}</div>
                        @if($renewal->policy->customer)
                            <div class="renewal-card-customer">{{ $renewal->policy->customer->name }}</div>
                            <div class="renewal-card-phone">
                                <i class="bi bi-telephone"></i> {{ $renewal->policy->customer->phone }}
                            </div>
                        @endif
                    @else
                        <div class="text-muted">Poliçe bulunamadı</div>
                    @endif
                </div>
                <div class="renewal-card-type">
                    @if($renewal->policy && $renewal->policy->policy_type_label)
                        <span class="badge rounded-pill bg-info">
                            {{ $renewal->policy->policy_type_label }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Days Left Alert -->
            <div class="renewal-days-alert {{ $daysAlertClass }}">
                <i class="bi {{ $daysAlertIcon }} renewal-days-icon" style="color: {{ $daysAlertColor }}"></i>
                <div class="renewal-days-content">
                    <div class="renewal-days-value" style="color: {{ $daysAlertColor }}">
                        {{ $daysAlertText }}
                    </div>
                    <div class="renewal-days-label" style="color: {{ $daysAlertColor }}">
                        {{ $isOverdue ? 'Geçmiş Yenileme' : 'Yenileme Tarihi' }}
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="renewal-card-body">
                <!-- Yenileme Tarihi -->
                <div class="renewal-info-item">
                    <div class="renewal-info-label">Yenileme Tarihi</div>
                    <div class="renewal-info-value">{{ $renewal->renewal_date->format('d.m.Y') }}</div>
                </div>

                <!-- Sigorta Şirketi -->
                <div class="renewal-info-item">
                    <div class="renewal-info-label">Sigorta Şirketi</div>
                    <div class="renewal-info-value">
                        @if($renewal->policy && $renewal->policy->insuranceCompany)
                            <span class="badge rounded-pill bg-info">
                                {{ $renewal->policy->insuranceCompany->code }}
                            </span>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Öncelik -->
                <div class="renewal-info-item">
                    <div class="renewal-info-label">Öncelik</div>
                    <div class="renewal-info-value">
                        <span class="priority-badge-mobile bg-{{ $priority['color'] }} text-white">
                            @if($priority['stripe'] === 'critical')
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            @elseif($priority['stripe'] === 'high')
                                <i class="bi bi-exclamation-circle-fill"></i>
                            @elseif($priority['stripe'] === 'normal')
                                <i class="bi bi-info-circle-fill"></i>
                            @else
                                <i class="bi bi-circle-fill"></i>
                            @endif
                            {{ $priority['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Son İletişim -->
                <div class="renewal-info-item">
                    <div class="renewal-info-label">Son Hatırlatıcı</div>
                    <div class="renewal-info-value">
                        @if($renewal->last_reminder_sent_at)
                            <small>{{ $renewal->last_reminder_sent_at->diffForHumans() }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Actions -->
            <div class="renewal-card-actions">
                <a href="{{ route('renewals.show', $renewal) }}" class="renewal-action-btn view">
                    <i class="bi bi-eye"></i>
                    <span>Detayları Gör</span>
                </a>

                @if($renewal->status === 'pending')
                    <form method="POST" action="{{ route('renewals.sendReminder', $renewal) }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="renewal-action-btn remind" style="width: 100%;">
                            <i class="bi bi-send"></i>
                            <span>Hatırlat</span>
                        </button>
                    </form>
                @else
                    <div class="renewal-action-btn remind disabled">
                        <i class="bi bi-send"></i>
                        <span>Hatırlat</span>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state-mobile">
            <i class="bi bi-arrow-repeat"></i>
            <h3>Yenileme Bulunamadı</h3>
            <p>Henüz yenileme kaydı bulunmamaktadır.</p>
        </div>
    @endforelse
</div>

<!-- Desktop: Tablo Görünümü -->
    <div class="main-card card desktop-table-container">
        <div class="card-body">
            <table id="renewalsTable" class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th width="50">#</th>
                        <th class="ps-4">Poliçe No</th>
                        <th>Müşteri</th>
                        <th>Tür</th>
                        <th>Şirket</th>
                        <th>Yenileme Tarihi</th>
                        <th>Kalan Gün</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th width="150" class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($renewals as $index => $renewal)
                    @php
                        $daysLeft = $renewal->days_until_renewal;
                        $isOverdue = $daysLeft < 0;
                        $isCritical = $daysLeft >= 0 && $daysLeft <= 7;
                        $isUrgent = $daysLeft > 7 && $daysLeft <= 30;

                        $rowClass = '';
                        if ($renewal->status !== 'renewed') {
                            if ($isOverdue) {
                                $rowClass = 'table-danger';
                            } elseif ($isCritical) {
                                $rowClass = 'table-warning';
                            }
                        }
                    @endphp
                    <tr class="{{ $rowClass }}" data-days="{{ $daysLeft }}">
                        <td></td>
                        <td class="ps-4">
                            @if($renewal->policy)
                                <a href="{{ route('policies.show', $renewal->policy->id) }}"
                                class="text-decoration-none">
                                    <strong>{{ $renewal->policy->policy_number }}</strong>
                                </a>
                            @else
                                <span class="text-muted">Poliçe bulunamadı</span>
                            @endif
                        </td>
                            <td>
                                @if($renewal->policy && $renewal->policy->customer)
                                    <a href="{{ route('customers.show', $renewal->policy->customer->id) }}"
                                    class="text-decoration-none text-dark">
                                        {{ $renewal->policy->customer->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Müşteri bulunamadı</span>
                                @endif

                            <br>
                            @if($renewal->policy && $renewal->policy->customer)
                                <small class="text-muted">
                                    {{ $renewal->policy->customer->phone }}
                                </small>
                            @endif

                        </td>
                        <td>
                            @if($renewal->policy && $renewal->policy->policy_type_label)
                                <span class="badge rounded-pill bg-info">
                                    {{ $renewal->policy->policy_type_label }}
                                </span>
                            @else
                                <span class="text-muted">Poliçe bulunamadı</span>
                            @endif
                        </td>
                        <td>
                            @if($renewal->policy && $renewal->policy->insuranceCompany)
                                <span class="badge rounded-pill bg-info">
                                    <small>{{ $renewal->policy->insuranceCompany->code }}</small>
                                </span>
                            @else
                                <span class="text-muted">Şirket kodu bulunamadı</span>
                            @endif
                        </td>
                        <td data-sort="{{ $renewal->renewal_date->format('Y-m-d') }}">
                            <strong>{{ $renewal->renewal_date->format('d.m.Y') }}</strong>
                        </td>
                        <td data-order="{{ $daysLeft }}">
                            @if($isOverdue)
                                @if ($renewal->status == 'renewed')
                                     <span class="badge bg-success">Yenilendi</span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        {{ abs($daysLeft) }} gün geçti
                                    </span>
                                @endif
                            @elseif($isCritical)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $daysLeft }} gün
                                </span>
                            @elseif($isUrgent)
                                <span class="badge bg-info">
                                    {{ $daysLeft }} gün
                                </span>
                            @else
                                <span class="text-muted">{{ $daysLeft }} gün</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $priorityConfig = [
                                    'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                    'normal' => ['color' => 'info', 'label' => 'Normal'],
                                    'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                    'critical' => ['color' => 'danger', 'label' => 'Kritik'],
                                ];
                                $priority = $priorityConfig[$renewal->priority] ?? ['color' => 'secondary', 'label' => 'Normal'];
                            @endphp
                            <span class="badge bg-{{ $priority['color'] }}">
                                {{ $priority['label'] }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'contacted' => ['color' => 'info', 'label' => 'İletişimde'],
                                    'renewed' => ['color' => 'success', 'label' => 'Yenilendi'],
                                    'lost' => ['color' => 'danger', 'label' => 'Kaybedildi'],
                                ];
                                $status = $statusConfig[$renewal->status] ?? ['color' => 'secondary', 'label' => $renewal->status];
                            @endphp
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('renewals.show', $renewal) }}"
                                   class="btn-icon"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($renewal->status === 'pending')
                                <form method="POST" action="{{ route('renewals.sendReminder', $renewal) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn-icon"
                                            title="Hatırlatıcı Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Toplu Hatırlatıcı Modal -->
<div class="modal fade" id="bulkReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı Gönder
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.bulkSendReminders') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hedef Grup</label>
                        <select class="form-select" name="filter" required>
                            <option value="critical">Kritik (7 gün içinde - {{ $stats['critical'] }} adet)</option>
                            <option value="upcoming">Yaklaşan (30 gün içinde)</option>
                            <option value="all">Tümü (Bekliyor + İletişimde)</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Seçilen gruptaki tüm müşterilere SMS hatırlatıcısı gönderilecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send me-2"></i>Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#renewalsTable', {
        order: [[6, 'asc']], // Kalan güne göre sırala (en az kalan önce)
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [9] }, // İşlemler
            { targets: 5, type: 'date' }, // Yenileme tarihi
            { targets: 6, type: 'num' } // Kalan gün
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterPriority, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const priority = $('#filterPriority').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(8).search(status);
        } else {
            table.column(8).search('');
        }

        // Öncelik filtresi
        if (priority) {
            table.column(7).search(priority);
        } else {
            table.column(7).search('');
        }

        // Tarih filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[5]; // Yenileme tarihi sütunu
                    if (!dateStr || dateStr === '-') return true;

                    const dateParts = dateStr.match(/\d{2}\.\d{2}\.\d{4}/);
                    if (!dateParts) return true;

                    const parts = dateParts[0].split('.');
                    const rowDate = new Date(parts[2], parts[1] - 1, parts[0]);
                    const startDate = dateFrom ? new Date(dateFrom) : null;
                    const endDate = dateTo ? new Date(dateTo) : null;

                    if (startDate && rowDate < startDate) return false;
                    if (endDate && rowDate > endDate) return false;

                    return true;
                }
            );
        }

        table.draw();
    });

    // Sayfa değişince toplam sayıyı güncelle
    table.on('draw', function() {
        const info = table.page.info();
        $('#renewalCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> yenileme`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#renewalCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> yenileme`);
});

function clearFilters() {
    $('#filterStatus, #filterPriority, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#renewalsTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>

<script>
$(document).ready(function() {
    // ... Mevcut DataTable kodu ...

    // Mobile Search
    $('#mobileSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMobileCards(searchTerm);
    });

    // Mobile Filter Function
    function filterMobileCards(searchTerm = '') {
        const status = $('#filterStatus').val();
        const priority = $('#filterPriority').val();

        let visibleCount = 0;

        $('.renewal-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.renewal-status-ribbon').text().trim();
            const cardPriority = $card.find('.priority-badge-mobile').text().trim();

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // Priority filter
            if (priority && cardPriority !== priority) {
                show = false;
            }

            if (show) {
                $card.show();
                visibleCount++;
            } else {
                $card.hide();
            }
        });

        // Update count for mobile
        if (window.innerWidth <= 768) {
            $('#renewalCount').html(`Gösterilen: <strong>${visibleCount}</strong> / <strong>{{ $renewals->count() }}</strong> yenileme`);
        }
    }

    // Filter change event for mobile
    $('#filterStatus, #filterPriority').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterStatus, #filterPriority, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#renewalsTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.renewal-card-mobile').show();

    if (window.innerWidth <= 768) {
        $('#renewalCount').html(`Toplam: <strong>{{ $renewals->count() }}</strong> yenileme`);
    }
}
</script>
@endpush
