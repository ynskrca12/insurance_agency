@extends('layouts.app')

@section('title', 'Poliçeler')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .stat-card .card-body {
        padding: 15px;
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

    .filter-card {
        margin-bottom: 1.5rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
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

    .btn-icon {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        transform: scale(1.05);
        border-color: #b0b0b0;
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
        border-radius: 20px;
    }
    .main-card .card-body {
        padding: 1.5rem;
    }
      .main-card td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
</style>
<style>
    /* ... Mevcut stiller ... */

    /* ============================================
       MOBILE OPTIMIZATION - PROFESSIONAL
    ============================================ */

    /* Mobile Cards Container */
    .mobile-cards-container {
        display: none;
    }

    /* Policy Card Mobile */
    .policy-card-mobile {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .policy-card-mobile:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Card Header */
    .policy-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .policy-card-number {
        font-size: 15px;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 4px;
    }

    .policy-card-customer {
        font-size: 13px;
        color: #475569;
        font-weight: 500;
    }

    .policy-card-status-badge {
        flex-shrink: 0;
    }

    /* Card Body - Grid */
    .policy-card-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .policy-info-item {
        display: flex;
        flex-direction: column;
    }

    .policy-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .policy-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .policy-info-value.text-primary {
        color: #2563eb;
    }

    .policy-info-value.text-success {
        color: #10b981;
    }

    .policy-info-value.text-danger {
        color: #ef4444;
    }

    .policy-info-value small {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Card Meta - Full Width Info */
    .policy-card-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .policy-card-meta-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .policy-meta-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .policy-meta-value {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .policy-meta-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Card Actions */
    .policy-card-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .policy-action-btn {
        padding: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .policy-action-btn:active {
        transform: scale(0.95);
    }

    .policy-action-btn i {
        font-size: 18px;
    }

    .policy-action-btn span {
        font-size: 11px;
        font-weight: 600;
    }

    .policy-action-btn.view {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .policy-action-btn.view i {
        color: #3b82f6;
    }

    .policy-action-btn.view span {
        color: #3b82f6;
    }

    .policy-action-btn.edit {
        border-color: #f59e0b;
        background: #fffbeb;
    }

    .policy-action-btn.edit i {
        color: #f59e0b;
    }

    .policy-action-btn.edit span {
        color: #f59e0b;
    }

    .policy-action-btn.delete {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .policy-action-btn.delete i {
        color: #ef4444;
    }

    .policy-action-btn.delete span {
        color: #ef4444;
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
        /* Container Padding */
        .container-fluid {
            padding: 0 !important;
        }

        /* Page Header Mobile */
        .page-header {
            margin: 0 16px 16px 16px;
            padding: 1rem;
            border-radius: 8px;
        }

        .page-header h1 {
            font-size: 1.125rem !important;
        }

        .page-header p {
            font-size: 0.8125rem;
        }

        .page-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .page-header .btn {
            width: 100%;
            margin-top: 12px;
        }

        /* Stats Cards Mobile */
        .row.g-3.mb-4 {
            margin: 0 16px 16px 16px !important;
            gap: 8px !important;
        }

        .row.g-3.mb-4 > div {
            padding: 0 !important;
        }

        .stat-card {
            border-radius: 8px;
        }

        .stat-value {
            font-size: 1.375rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        /* Filter Card Mobile */
        .filter-card {
            margin: 0 16px 16px 16px;
            border-radius: 8px;
        }

        .filter-card .card-body {
            padding: 12px;
        }

        .filter-card .row {
            gap: 10px;
        }

        .filter-card .col-lg-2,
        .filter-card .col-lg-3,
        .filter-card .col-lg-1,
        .filter-card .col-md-6 {
            width: 100%;
            padding: 0;
        }

        .filter-card label {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .filter-card .form-select,
        .filter-card .form-control {
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
        .page-header h1 {
            font-size: 1rem !important;
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.65rem;
        }

        .policy-card-mobile {
            padding: 0.875rem;
        }

        .policy-card-body {
            gap: 10px;
        }
    }
</style>
{{-- policies card --}}
<style>
    /* ========================================
   POLICIES PAGE - STAT CARDS
======================================== */

.policy-stat-card {
    position: relative;
    border-radius: 14px;
    padding: 1.25rem;
    overflow: hidden;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    gap: 0.75rem;
}

.policy-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

/* Icon */
.policy-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size:26px;
    color: rgba(255, 255, 255, 0.95);
    transition: all 0.3s ease;
    z-index: 2;
    position: relative;
}

.policy-stat-card:hover .policy-stat-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Content */
.policy-stat-content {
    z-index: 2;
    position: relative;
}

.policy-stat-value {
    font-size: 1.875rem;
    font-weight: 800;
    color: #ffffff;
    line-height: 1;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.policy-stat-label {
    font-size: 0.813rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: rgba(255, 255, 255, 0.85);
}

/* Background Icon */
.policy-stat-bg {
    position: absolute;
    bottom: -15px;
    right: -15px;
    font-size: 120px;
    color: rgba(255, 255, 255, 0.08);
    z-index: 1;
    line-height: 1;
    pointer-events: none;
    transform: rotate(-15deg);
    transition: all 0.4s ease;
}

.policy-stat-card:hover .policy-stat-bg {
    transform: rotate(-10deg) scale(1.05);
    color: rgba(255, 255, 255, 0.12);
}

/* ========================================
   COLOR VARIANTS
======================================== */

/* Primary - Mavi (Toplam) */
.policy-stat-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.policy-stat-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
}

/* Success - Yeşil (Aktif) */
.policy-stat-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.policy-stat-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
}

/* Warning - Turuncu (Yaklaşan) */
.policy-stat-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.policy-stat-warning:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
}

/* Danger - Kırmızı (Kritik) */
.policy-stat-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.policy-stat-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
}

/* Secondary - Gri (Dolmuş) */
.policy-stat-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
}

.policy-stat-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
}

/* ========================================
   RESPONSIVE
======================================== */

@media (max-width: 1200px) {
    .policy-stat-value {
        font-size: 1.625rem;
    }

    .policy-stat-bg {
        font-size: 100px;
    }
}

@media (max-width: 992px) {
    .policy-stat-card {
        padding: 1rem;
    }

    .policy-stat-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }

    .policy-stat-value {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .policy-stat-value {
        font-size: 1.375rem;
    }

    .policy-stat-label {
        font-size: 0.75rem;
    }

    .policy-stat-bg {
        font-size: 80px;
        bottom: -10px;
        right: -10px;
    }
}

@media (max-width: 576px) {
    .policy-stat-card {
        padding: 0.875rem;
    }

    .policy-stat-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }

    .policy-stat-value {
        font-size: 1.25rem;
    }

    .policy-stat-label {
        font-size: 0.688rem;
    }

    .policy-stat-bg {
        font-size: 70px;
    }
}

/* ========================================
   ANIMATION
======================================== */

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.policy-stat-card {
    animation: slideInRight 0.5s ease-out;
}

.policy-stat-card:nth-child(1) { animation-delay: 0s; }
.policy-stat-card:nth-child(2) { animation-delay: 0.05s; }
.policy-stat-card:nth-child(3) { animation-delay: 0.1s; }
.policy-stat-card:nth-child(4) { animation-delay: 0.15s; }
.policy-stat-card:nth-child(5) { animation-delay: 0.2s; }

/* ========================================
   TIKLAMA EFEKTİ (Opsiyonel)
======================================== */

.policy-stat-card {
    cursor: pointer;
}

.policy-stat-card:active {
    transform: translateY(-2px) scale(0.98);
}

/* Tıklanabilir görünüm için */
.policy-stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0);
    transition: all 0.3s ease;
    z-index: 3;
    pointer-events: none;
}

.policy-stat-card:hover::after {
    background: rgba(255, 255, 255, 0.1);
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 fw-bold text-dark">
                    <i class="bi bi-file-earmark-text me-2"></i>Poliçe Yönetimi
                </h1>
                <p class="text-muted mb-0 small" id="policyCount">
                    Toplam <strong>{{ number_format($policies->count()) }}</strong> poliçe listeleniyor
                </p>
            </div>
            <a href="{{ route('policies.create') }}" class="btn btn-primary action-btn">
                <i class="bi bi-plus-circle me-2"></i>Yeni Poliçe Ekle
            </a>
        </div>
    </div>

     <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <!-- Toplam Poliçe -->
        <div class="col-lg col-md-4 col-6">
            <div class="policy-stat-card policy-stat-primary">
                <div class="policy-stat-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="policy-stat-content">
                    <div class="policy-stat-value">{{ number_format($stats['total']) }}</div>
                    <div class="policy-stat-label">Toplam Poliçe</div>
                </div>
                <div class="policy-stat-bg">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>

        <!-- Aktif -->
        <div class="col-lg col-md-4 col-6">
            <div class="policy-stat-card policy-stat-success">
                <div class="policy-stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="policy-stat-content">
                    <div class="policy-stat-value">{{ number_format($stats['active']) }}</div>
                    <div class="policy-stat-label">Aktif</div>
                </div>
                <div class="policy-stat-bg">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>

        <!-- Süresi Yaklaşan -->
        <div class="col-lg col-md-4 col-6">
            <div class="policy-stat-card policy-stat-warning">
                <div class="policy-stat-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="policy-stat-content">
                    <div class="policy-stat-value">{{ number_format($stats['expiring_soon']) }}</div>
                    <div class="policy-stat-label">Süresi Yaklaşan</div>
                </div>
                <div class="policy-stat-bg">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>

        <!-- Kritik -->
        <div class="col-lg col-md-4 col-6">
            <div class="policy-stat-card policy-stat-danger">
                <div class="policy-stat-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="policy-stat-content">
                    <div class="policy-stat-value">{{ number_format($stats['critical']) }}</div>
                    <div class="policy-stat-label">Kritik</div>
                </div>
                <div class="policy-stat-bg">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>

        <!-- Süresi Dolmuş -->
        <div class="col-lg col-md-4 col-6">
            <div class="policy-stat-card policy-stat-secondary">
                <div class="policy-stat-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="policy-stat-content">
                    <div class="policy-stat-value">{{ number_format($stats['expired']) }}</div>
                    <div class="policy-stat-label">Süresi Dolmuş</div>
                </div>
                <div class="policy-stat-bg">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <div class="row g-3">
                <!-- Poliçe Türü -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Poliçe Türü</label>
                    <select id="filterPolicyType" class="form-select">
                        <option value="">Tüm Türler</option>
                        <option value="Kasko">Kasko</option>
                        <option value="Trafik">Trafik</option>
                        <option value="Konut">Konut</option>
                        <option value="DASK">DASK</option>
                        <option value="Sağlık">Sağlık</option>
                        <option value="Hayat">Hayat</option>
                        <option value="TSS">TSS</option>
                    </select>
                </div>

                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Yaklaşan">Yaklaşan</option>
                        <option value="Kritik">Kritik</option>
                        <option value="Dolmuş">Dolmuş</option>
                        <option value="Yenilendi">Yenilendi</option>
                        <option value="İptal">İptal</option>
                    </select>
                </div>

                <!-- Sigorta Şirketi -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small text-muted mb-1">Sigorta Şirketi</label>
                    <select id="filterCompany" class="form-select">
                        <option value="">Tüm Şirketler</option>
                        @foreach($insuranceCompanies as $company)
                        <option value="{{ $company->code }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Başlangıç Tarihi</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Bitiş Tarihi</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-6">
                    <label class="form-label small text-muted mb-1 d-none d-md-block">&nbsp;</label>
                    <button type="button" class="btn btn-secondary w-100 action-btn" onclick="clearFilters()">
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
        @forelse($policies as $policy)
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
                $daysLeft = $policy->days_until_expiry;
            @endphp

            <div class="policy-card-mobile" data-policy-id="{{ $policy->id }}">
                <!-- Card Header -->
                <div class="policy-card-header">
                    <div>
                        <div class="policy-card-number">{{ $policy->policy_number }}</div>
                        <div class="policy-card-customer">{{ $policy->customer->name }}</div>
                    </div>
                    <div class="policy-card-status-badge">
                        <span class="badge badge-modern bg-{{ $config['color'] }}">
                            <i class="bi bi-{{ $config['icon'] }}"></i>
                            {{ $config['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Card Body - Main Info Grid -->
                <div class="policy-card-body">
                    <!-- Poliçe Türü -->
                    <div class="policy-info-item">
                        <div class="policy-info-label">Poliçe Türü</div>
                        <div class="policy-info-value">
                            <span class="badge badge-modern bg-info">{{ $policy->policy_type_label }}</span>
                        </div>
                    </div>

                    <!-- Sigorta Şirketi -->
                    <div class="policy-info-item">
                        <div class="policy-info-label">Sigorta Şirketi</div>
                        <div class="policy-info-value">{{ $policy->insuranceCompany->code }}</div>
                    </div>

                    <!-- Araç/Adres -->
                    <div class="policy-info-item">
                        <div class="policy-info-label">
                            @if($policy->isVehiclePolicy())
                                Araç Bilgisi
                            @elseif($policy->isPropertyPolicy())
                                Adres
                            @else
                                Bilgi
                            @endif
                        </div>
                        <div class="policy-info-value">
                            @if($policy->isVehiclePolicy())
                                {{ $policy->vehicle_plate }}
                                <small>{{ $policy->vehicle_brand }}</small>
                            @elseif($policy->isPropertyPolicy())
                                <small>{{ Str::limit($policy->property_address, 25) }}</small>
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <!-- Bitiş Tarihi -->
                    <div class="policy-info-item">
                        <div class="policy-info-label">Bitiş Tarihi</div>
                        <div class="policy-info-value {{ $daysLeft <= 30 ? 'text-danger' : '' }}">
                            {{ $policy->end_date->format('d.m.Y') }}
                            @if ($policy->status != 'renewed')
                                @if($daysLeft > 0)
                                    <small>{{ $daysLeft }} gün</small>
                                @elseif($daysLeft === 0)
                                    <small class="text-danger">Bugün!</small>
                                @else
                                    <small class="text-danger">{{ abs($daysLeft) }} gün önce</small>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Meta - Full Width -->
                <div class="policy-card-meta">
                    <div class="policy-card-meta-item">
                        <div class="policy-meta-icon">
                            <i class="bi bi-cash-stack text-success"></i>
                        </div>
                        <div class="policy-meta-value">{{ number_format($policy->premium_amount, 0) }}₺</div>
                        <div class="policy-meta-label">Prim Tutarı</div>
                    </div>

                    <div class="policy-card-meta-item">
                        <div class="policy-meta-icon">
                            <i class="bi bi-calendar-event text-primary"></i>
                        </div>
                        <div class="policy-meta-value">{{ $policy->start_date->format('d.m.y') }}</div>
                        <div class="policy-meta-label">Başlangıç</div>
                    </div>

                    <div class="policy-card-meta-item">
                        <div class="policy-meta-icon">
                            <i class="bi bi-telephone text-info"></i>
                        </div>
                        <div class="policy-meta-value">{{ $policy->customer->phone }}</div>
                        <div class="policy-meta-label">Telefon</div>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="policy-card-actions">
                    <a href="{{ route('policies.show', $policy) }}" class="policy-action-btn view">
                        <i class="bi bi-eye"></i>
                        <span>Detay</span>
                    </a>
                    <a href="{{ route('policies.edit', $policy) }}" class="policy-action-btn edit">
                        <i class="bi bi-pencil"></i>
                        <span>Düzenle</span>
                    </a>
                    <button onclick="deletePolicy({{ $policy->id }})" class="policy-action-btn delete">
                        <i class="bi bi-trash"></i>
                        <span>Sil</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state-mobile">
                <i class="bi bi-file-earmark-text"></i>
                <h3>Poliçe Bulunamadı</h3>
                <p>Henüz poliçe kaydı bulunmamaktadır.</p>
            </div>
        @endforelse
    </div>

    <!-- Tablo -->
    <div class="main-card card desktop-table-container">
        <div class="card-body">
            <table id="policiesTable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">#</th>
                            <th>Poliçe No</th>
                            <th>Müşteri</th>
                            <th>Tür</th>
                            <th>Şirket</th>
                            <th>Araç/Adres</th>
                            <th>Bitiş Tarihi</th>
                            <th>Prim Tutarı</th>
                            <th>Durum</th>
                            <th>Ekleyen Kişi</th>
                            <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($policies as $index => $policy)
                        <tr>
                            <td></td>
                            <td>
                                <strong class="text-primary">{{ $policy->policy_number }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('customers.show', $policy->customer) }}" class="customer-link">
                                    {{ $policy->customer->name }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $policy->customer->phone }}</small>
                            </td>
                            <td>
                                <span class="badge badge-modern bg-info">
                                    {{ $policy->policy_type_label }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $policy->insuranceCompany->code }}</span>
                            </td>
                            <td>
                                @if($policy->isVehiclePolicy())
                                    <strong>{{ $policy->vehicle_plate }}</strong><br>
                                    <small class="text-muted">{{ $policy->vehicle_brand }} {{ $policy->vehicle_model }}</small>
                                @elseif($policy->isPropertyPolicy())
                                    <small class="text-muted">{{ Str::limit($policy->property_address, 30) }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td data-sort="{{ $policy->end_date->format('Y-m-d') }}">
                                <strong>{{ $policy->end_date->format('d.m.Y') }}</strong>
                                <br>
                                @php
                                    $daysLeft = $policy->days_until_expiry;
                                @endphp
                                @if ($policy->status != 'renewed')
                                    @if($daysLeft > 0)
                                        <small class="text-muted">{{ $daysLeft }} gün kaldı</small>
                                    @elseif($daysLeft === 0)
                                        <small class="text-danger fw-semibold">Bugün bitiyor!</small>
                                    @else
                                        <small class="text-danger">{{ abs($daysLeft) }} gün önce</small>
                                    @endif
                                @endif
                            </td>
                            <td data-order="{{ $policy->premium_amount }}">
                                <strong>{{ number_format($policy->premium_amount, 2) }} ₺</strong>
                            </td>
                            <td>
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
                            </td>
                                <span class="text-muted">{{ $policy->createdBy->name ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('policies.show', $policy) }}"
                                       class="btn btn-light btn-icon"
                                       title="Detayları Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('policies.edit', $policy) }}"
                                       class="btn btn-light btn-icon"
                                       title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-light btn-icon text-danger"
                                            onclick="deletePolicy({{ $policy->id }})"
                                            title="Sil">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    const table = initDataTable('#policiesTable', {
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: [9] },
        ]
    });

    // Filtreler
    $('#filterPolicyType, #filterStatus, #filterCompany, #filterDateFrom, #filterDateTo').on('change', function() {
        const policyType = $('#filterPolicyType').val();
        const status = $('#filterStatus').val();
        const company = $('#filterCompany').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Poliçe türü filtresi
        if (policyType) {
            table.column(3).search(policyType);
        } else {
            table.column(3).search('');
        }

        // Durum filtresi
        if (status) {
            table.column(8).search(status);
        } else {
            table.column(8).search('');
        }

        // Şirket filtresi
        if (company) {
            table.column(4).search(company);
        } else {
            table.column(4).search('');
        }

        // Tarih filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[6]; // Tarih sütunu
                    if (!dateStr || dateStr === '-') return true;

                    // İlk satırdaki tarihi parse et
                    const dateParts = dateStr.split('<br>')[0].trim().match(/\d{2}\.\d{2}\.\d{4}/);
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
        $('#policyCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> poliçe`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#policyCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> poliçe`);
});

function clearFilters() {
    $('#filterPolicyType, #filterStatus, #filterCompany, #filterDateFrom, #filterDateTo').val('');

    // Tüm custom filtreleri temizle
    $.fn.dataTable.ext.search = [];

    const table = $('#policiesTable').DataTable();
    table.search('').columns().search('').draw();
}

function deletePolicy(policyId) {
    if (confirm(' DİKKAT!\n\nBu poliçeyi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/policies/' + policyId;
        form.submit();
    }
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
        const policyType = $('#filterPolicyType').val();
        const status = $('#filterStatus').val();
        const company = $('#filterCompany').val();

        let visibleCount = 0;

        $('.policy-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.policy-card-status-badge .badge').text().trim();
            const cardType = $card.find('.badge-modern.bg-info').text().trim();
            const cardCompany = $card.find('.policy-info-value').eq(1).text().trim();

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Policy type filter
            if (policyType && cardType !== policyType) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // Company filter
            if (company && cardCompany !== company) {
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
            $('#policyCount').html(`Gösterilen: <strong>${visibleCount}</strong> / <strong>{{ $policies->count() }}</strong> poliçe`);
        }
    }

    // Filter change event for mobile
    $('#filterPolicyType, #filterStatus, #filterCompany').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterPolicyType, #filterStatus, #filterCompany, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#policiesTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.policy-card-mobile').show();

    if (window.innerWidth <= 768) {
        $('#policyCount').html(`Toplam <strong>{{ $policies->count() }}</strong> poliçe`);
    }
}

// Existing deletePolicy function remains the same
</script>
@endpush
