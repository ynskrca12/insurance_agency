@extends('layouts.app')

@section('title', 'Teklifler')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
        background: #ffffff;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        background: #fafafa;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .btn-primary.action-btn {
        border-color: #0d6efd;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-card .card-body {
        padding: 1.5rem;
    }

    .table-card td {
        vertical-align: middle;
    }

    .quotation-number {
        font-weight: 600;
        color: #0d6efd;
        font-size: 0.9375rem;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .badge-pill {
        border-radius: 50px;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
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

    .btn-icon:hover {
        transform: translateY(-2px);
        border-color: #999;
    }

    .btn-icon.btn-view:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-icon.btn-edit:hover {
        background: #ffc107;
        border-color: #ffc107;
        color: #ffffff;
    }

    .btn-icon.btn-share:hover {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    /* DataTables */
    .dataTables_length, .dataTables_filter {
        padding: 1rem 1.25rem;
    }

    .dataTables_info, .dataTables_paginate {
        padding: 1rem 1.25rem;
    }
    .dt-buttons .btn {
        margin-right: 0.5rem;
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

    /* Quotation Card Mobile */
    .quotation-card-mobile {
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

    .quotation-card-mobile:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Card Ribbon - Status */
    .quotation-card-ribbon {
        position: absolute;
        top: 12px;
        right: -32px;
        width: 120px;
        text-align: center;
        padding: 4px 0;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        color: white;
        transform: rotate(45deg);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Card Header */
    .quotation-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .quotation-card-number {
        font-size: 15px;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 4px;
    }

    .quotation-card-customer {
        font-size: 13px;
        color: #475569;
        font-weight: 600;
    }

    .quotation-card-phone {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .quotation-card-type {
        flex-shrink: 0;
        margin-left: 8px;
    }

    /* Card Body - Grid */
    .quotation-card-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .quotation-info-item {
        display: flex;
        flex-direction: column;
    }

    .quotation-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .quotation-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .quotation-info-value.price {
        font-size: 16px;
        color: #10b981;
        font-weight: 700;
    }

    .quotation-info-value.companies {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .quotation-info-value.companies .count {
        font-size: 18px;
        font-weight: 700;
        color: #2563eb;
    }

    .quotation-info-value.companies .label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .quotation-info-value small {
        display: block;
        font-size: 10px;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Validity Indicator */
    .validity-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .validity-indicator i {
        font-size: 12px;
    }

    .validity-indicator.valid {
        color: #10b981;
    }

    .validity-indicator.expired {
        color: #ef4444;
    }

    /* View Count Badge */
    .view-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        background: #f1f5f9;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
    }

    .view-count-badge i {
        font-size: 12px;
        color: #64748b;
    }

    /* Card Actions */
    .quotation-card-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .quotation-action-btn {
        padding: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .quotation-action-btn:active {
        transform: scale(0.95);
    }

    .quotation-action-btn i {
        font-size: 16px;
    }

    .quotation-action-btn span {
        font-size: 10px;
        font-weight: 600;
    }

    .quotation-action-btn.view {
        border-color: #0dcaf0;
        background: #e0f7ff;
    }

    .quotation-action-btn.view i {
        color: #0dcaf0;
    }

    .quotation-action-btn.view span {
        color: #0dcaf0;
    }

    .quotation-action-btn.edit {
        border-color: #ffc107;
        background: #fff9e6;
    }

    .quotation-action-btn.edit i {
        color: #ffc107;
    }

    .quotation-action-btn.edit span {
        color: #ffc107;
    }

    .quotation-action-btn.share {
        border-color: #0d6efd;
        background: #e7f1ff;
    }

    .quotation-action-btn.share i {
        color: #0d6efd;
    }

    .quotation-action-btn.share span {
        color: #0d6efd;
    }

    .quotation-action-btn.delete {
        border-color: #dc3545;
        background: #ffe6e6;
    }

    .quotation-action-btn.delete i {
        color: #dc3545;
    }

    .quotation-action-btn.delete span {
        color: #dc3545;
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
            padding: 0.875rem;
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
        .filter-card .col-lg-1,
        .filter-card .col-md-6,
        .filter-card .col-md-12 {
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
        .table-card {
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

        .quotation-card-mobile {
            padding: 0.875rem;
        }

        .quotation-card-actions {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
    }
</style>

   {{-- QUOTATIONS PAGE - STAT CARDS --}}

<style>
    .quotation-stat-card {
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
        cursor: pointer;
    }

    .quotation-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    /* Content */
    .quotation-stat-content {
        z-index: 2;
        position: relative;
    }

    .quotation-stat-value {
        font-size: 1.875rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .quotation-stat-label {
        font-size: 0.813rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Background Icon */
    .quotation-stat-bg {
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

    .quotation-stat-card:hover .quotation-stat-bg {
        transform: rotate(-10deg) scale(1.05);
        color: rgba(255, 255, 255, 0.12);
    }

    /* ========================================
    COLOR VARIANTS
    ======================================== */

    /* Primary - Mavi (Toplam) */
    .quotation-stat-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .quotation-stat-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Info - Cyan (Gönderildi) */
    .quotation-stat-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .quotation-stat-info:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    /* Warning - Turuncu (Onaylandı) */
    .quotation-stat-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .quotation-stat-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    /* Success - Yeşil (Dönüştürüldü) */
    .quotation-stat-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .quotation-stat-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* Danger - Kırmızı (Süresi Doldu) */
    .quotation-stat-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .quotation-stat-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    /* ========================================
    RESPONSIVE
    ======================================== */

    @media (max-width: 1200px) {
        .quotation-stat-value {
            font-size: 1.625rem;
        }

        .quotation-stat-bg {
            font-size: 100px;
        }
    }

    @media (max-width: 992px) {
        .quotation-stat-card {
            padding: 1rem;
        }

        .quotation-stat-value {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .quotation-stat-value {
            font-size: 1.375rem;
        }

        .quotation-stat-label {
            font-size: 0.75rem;
        }

        .quotation-stat-bg {
            font-size: 80px;
            bottom: -10px;
            right: -10px;
        }
    }

    @media (max-width: 576px) {
        .quotation-stat-card {
            padding: 0.875rem;
        }

        .quotation-stat-value {
            font-size: 1.25rem;
        }

        .quotation-stat-label {
            font-size: 0.688rem;
        }

        .quotation-stat-bg {
            font-size: 70px;
        }

        /* Mobilde 2'li sıralama */
        .row.g-3 > .col-sm-6 {
            flex: 0 0 48%;
            max-width: 48%;
        }

        /* Son kart (5. kart) tam genişlik */
        .row.g-3 > .col-sm-6:last-child:nth-child(odd) {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* ========================================
    ANIMATION
    ======================================== */

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .quotation-stat-card {
        animation: fadeInScale 0.5s ease-out;
    }

    .quotation-stat-card:nth-child(1) { animation-delay: 0s; }
    .quotation-stat-card:nth-child(2) { animation-delay: 0.05s; }
    .quotation-stat-card:nth-child(3) { animation-delay: 0.1s; }
    .quotation-stat-card:nth-child(4) { animation-delay: 0.15s; }
    .quotation-stat-card:nth-child(5) { animation-delay: 0.2s; }

    /* ========================================
    CLICK EFFECT
    ======================================== */

    .quotation-stat-card:active {
        transform: translateY(-2px) scale(0.98);
    }

    /* Hover overlay */
    .quotation-stat-card::after {
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

    .quotation-stat-card:hover::after {
        background: rgba(255, 255, 255, 0.1);
    }

    /* ========================================
    PULSE EFFECT (Yeni/Önemli Kartlar İçin)
    ======================================== */

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        50% {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }
    }

    /* Kritik durumlarda pulse efekti */
    .quotation-stat-danger:hover {
        animation: pulse 2s infinite;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 fw-bold text-dark">Teklifler</h1>
            </div>
            <a href="{{ route('quotations.create') }}" class="btn btn-primary action-btn">
                <i class="bi bi-plus-circle me-2"></i>Yeni Teklif Oluştur
            </a>
        </div>
    </div>

        <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <!-- Toplam Teklif -->
        <div class="col-lg col-md-4 col-sm-6">
            <div class="quotation-stat-card quotation-stat-primary">
                <div class="quotation-stat-content">
                    <div class="quotation-stat-value">{{ number_format($stats['total']) }}</div>
                    <div class="quotation-stat-label">Toplam Teklif</div>
                </div>
                <div class="quotation-stat-bg">
                    <i class="bi bi-file-earmark-plus"></i>
                </div>
            </div>
        </div>

        <!-- Gönderildi -->
        <div class="col-lg col-md-4 col-sm-6">
            <div class="quotation-stat-card quotation-stat-info">
                <div class="quotation-stat-content">
                    <div class="quotation-stat-value">{{ number_format($stats['viewed']) }}</div>
                    <div class="quotation-stat-label">Görüntülendi</div>
                </div>
                <div class="quotation-stat-bg">
                    <i class="bi bi-send"></i>
                </div>
            </div>
        </div>

        <!-- Onaylandı -->
        {{-- <div class="col-lg col-md-4 col-sm-6">
            <div class="quotation-stat-card quotation-stat-warning">
                <div class="quotation-stat-content">
                    <div class="quotation-stat-value">{{ number_format($stats['approved']) }}</div>
                    <div class="quotation-stat-label">Onaylandı</div>
                </div>
                <div class="quotation-stat-bg">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
        </div> --}}

        <!-- Dönüştürüldü -->
        {{-- <div class="col-lg col-md-4 col-sm-6">
            <div class="quotation-stat-card quotation-stat-success">
                <div class="quotation-stat-content">
                    <div class="quotation-stat-value">{{ number_format($stats['converted']) }}</div>
                    <div class="quotation-stat-label">Dönüştürüldü</div>
                </div>
                <div class="quotation-stat-bg">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
            </div>
        </div> --}}

        <!-- Süresi Doldu -->
        <div class="col-lg col-md-4 col-sm-6">
            <div class="quotation-stat-card quotation-stat-danger">
                <div class="quotation-stat-content">
                    <div class="quotation-stat-value">{{ number_format($stats['expired']) }}</div>
                    <div class="quotation-stat-label">Süresi Doldu</div>
                </div>
                <div class="quotation-stat-bg">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Taslak">Taslak</option>
                        <option value="Gönderildi">Gönderildi</option>
                        <option value="Görüntülendi">Görüntülendi</option>
                        <option value="Onaylandı">Onaylandı</option>
                        <option value="Reddedildi">Reddedildi</option>
                        <option value="Dönüştürüldü">Dönüştürüldü</option>
                        <option value="Süresi Doldu">Süresi Doldu</option>
                    </select>
                </div>

                <!-- Tür -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Teklif Türü</label>
                    <select id="filterQuotationType" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Kasko">Kasko</option>
                        <option value="Trafik">Trafik</option>
                        <option value="Konut">Konut</option>
                        <option value="Dask">DASK</option>
                        <option value="Saglik">Sağlık</option>
                        <option value="Hayat">Hayat</option>
                        <option value="Tss">TSS</option>
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Başlangıç Tarihi</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Bitiş Tarihi</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-12">
                    <button type="button" class="btn btn-secondary action-btn w-100" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile: Search Bar -->
    <div class="mobile-search-bar">
        <i class="bi bi-search mobile-search-icon"></i>
        <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Teklif ara...">
    </div>

    <!-- Mobile: Card Görünümü -->
    <div class="mobile-cards-container">
        @forelse($quotations as $quotation)
            @php
                $statusConfig = [
                    'draft' => ['color' => 'secondary', 'label' => 'Taslak', 'ribbon' => '#6c757d'],
                    'sent' => ['color' => 'info', 'label' => 'Gönderildi', 'ribbon' => '#0dcaf0'],
                    'viewed' => ['color' => 'primary', 'label' => 'Görüntülendi', 'ribbon' => '#0d6efd'],
                    'approved' => ['color' => 'warning', 'label' => 'Onaylandı', 'ribbon' => '#ffc107'],
                    'rejected' => ['color' => 'danger', 'label' => 'Reddedildi', 'ribbon' => '#dc3545'],
                    'converted' => ['color' => 'success', 'label' => 'Dönüştürüldü', 'ribbon' => '#198754'],
                    'expired' => ['color' => 'dark', 'label' => 'Süresi Doldu', 'ribbon' => '#212529'],
                ];
                $config = $statusConfig[$quotation->status] ?? ['color' => 'secondary', 'label' => $quotation->status, 'ribbon' => '#6c757d'];
            @endphp

            <div class="quotation-card-mobile" data-quotation-id="{{ $quotation->id }}">
                <!-- Status Ribbon -->
                <div class="quotation-card-ribbon" style="background: {{ $config['ribbon'] }}">
                    {{ $config['label'] }}
                </div>

                <!-- Card Header -->
                <div class="quotation-card-header">
                    <div style="flex: 1; min-width: 0;">
                        <div class="quotation-card-number">{{ $quotation->quotation_number }}</div>
                        <div class="quotation-card-customer">{{ $quotation->customer->name }}</div>
                        <div class="quotation-card-phone">
                            <i class="bi bi-telephone"></i> {{ $quotation->customer->phone }}
                        </div>
                    </div>
                    <div class="quotation-card-type">
                        <span class="badge badge-modern badge-pill bg-info">
                            {{ ucfirst($quotation->quotation_type) }}
                        </span>
                    </div>
                </div>

                <!-- Card Body - Main Info Grid -->
                <div class="quotation-card-body">
                    <!-- Şirket Sayısı -->
                    <div class="quotation-info-item">
                        <div class="quotation-info-label">Şirket Sayısı</div>
                        <div class="quotation-info-value companies">
                            <span class="count">{{ $quotation->items->count() }}</span>
                            <span class="label">şirket</span>
                        </div>
                    </div>

                    <!-- En Düşük Fiyat -->
                    <div class="quotation-info-item">
                        <div class="quotation-info-label">En Düşük Fiyat</div>
                        <div class="quotation-info-value price">
                            @if($quotation->lowest_price_item)
                                {{ number_format($quotation->lowest_price_item->premium_amount, 0) }}₺
                            @else
                                <span style="color: #94a3b8; font-size: 13px;">-</span>
                            @endif
                        </div>
                    </div>

                    <!-- Geçerlilik Tarihi -->
                    <div class="quotation-info-item">
                        <div class="quotation-info-label">Geçerlilik</div>
                        <div class="quotation-info-value">
                            {{ $quotation->valid_until->format('d.m.Y') }}
                            <div class="validity-indicator {{ $quotation->isValid() ? 'valid' : 'expired' }}">
                                <i class="bi bi-{{ $quotation->isValid() ? 'check-circle-fill' : 'x-circle-fill' }}"></i>
                                <small>{{ $quotation->isValid() ? 'Geçerli' : 'Doldu' }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Görüntülenme -->
                    <div class="quotation-info-item">
                        <div class="quotation-info-label">Görüntülenme</div>
                        <div class="quotation-info-value">
                            <span class="view-count-badge">
                                <i class="bi bi-eye"></i>
                                {{ $quotation->view_count }} kez
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="quotation-card-actions">
                    <a href="{{ route('quotations.show', $quotation) }}" class="quotation-action-btn view">
                        <i class="bi bi-eye"></i>
                        <span>Detay</span>
                    </a>

                    @if($quotation->status !== 'converted')
                    <a href="{{ route('quotations.edit', $quotation) }}" class="quotation-action-btn edit">
                        <i class="bi bi-pencil"></i>
                        <span>Düzenle</span>
                    </a>
                    @else
                    <div class="quotation-action-btn" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="bi bi-pencil"></i>
                        <span>Düzenle</span>
                    </div>
                    @endif

                    <button onclick="copyShareLink('{{ $quotation->share_url }}')" class="quotation-action-btn share">
                        <i class="bi bi-share"></i>
                        <span>Paylaş</span>
                    </button>

                    @if($quotation->status !== 'converted')
                    <button onclick="deleteQuotation({{ $quotation->id }})" class="quotation-action-btn delete">
                        <i class="bi bi-trash"></i>
                        <span>Sil</span>
                    </button>
                    @else
                    <div class="quotation-action-btn" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="bi bi-trash"></i>
                        <span>Sil</span>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state-mobile">
                <i class="bi bi-file-earmark-text"></i>
                <h3>Teklif Bulunamadı</h3>
                <p>Henüz teklif kaydı bulunmamaktadır.</p>
            </div>
        @endforelse
    </div>

    <!-- Tablo -->
    <div class="table-card card desktop-table-container">
        <div class="card-body">
            <table class="table table-hover" id="quotationsTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Teklif No</th>
                        <th>Müşteri</th>
                        <th>Tür</th>
                        <th>Şirket</th>
                        <th>En Düşük</th>
                        <th>Geçerlilik</th>
                        <th>Görüntülenme</th>
                        <th>Durum</th>
                        <th>Oluşturan Kişi</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $index => $quotation)
                    <tr>
                        <td></td> <!-- Boş, DataTables dolduracak -->
                        <td>
                            <span class="quotation-number">{{ $quotation->quotation_number }}</span>
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $quotation->customer) }}" class="customer-link">
                                {{ $quotation->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $quotation->customer->phone }}</small>
                        </td>
                        <td>
                            <span class="badge badge-modern badge-pill bg-info">
                                {{ ucfirst($quotation->quotation_type) }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $quotation->items->count() }}</strong>
                            <small class="text-muted">şirket</small>
                        </td>
                        <td data-order="{{ $quotation->lowest_price_item ? $quotation->lowest_price_item->premium_amount : 0 }}">
                            @if($quotation->lowest_price_item)
                                <strong class="text-success">{{ number_format($quotation->lowest_price_item->premium_amount, 2) }} ₺</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td data-sort="{{ $quotation->valid_until->format('Y-m-d') }}">
                            <div class="fw-semibold">{{ $quotation->valid_until->format('d.m.Y') }}</div>
                            @if($quotation->isValid())
                                <small class="text-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>Geçerli
                                </small>
                            @else
                                <small class="text-danger">
                                    <i class="bi bi-x-circle-fill me-1"></i>Doldu
                                </small>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $quotation->view_count }}</strong>
                            <small class="text-muted">kez</small>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'draft' => ['color' => 'secondary', 'label' => 'Taslak'],
                                    'sent' => ['color' => 'info', 'label' => 'Gönderildi'],
                                    'viewed' => ['color' => 'primary', 'label' => 'Görüntülendi'],
                                    'approved' => ['color' => 'warning', 'label' => 'Onaylandı'],
                                    'rejected' => ['color' => 'danger', 'label' => 'Reddedildi'],
                                    'converted' => ['color' => 'success', 'label' => 'Dönüştürüldü'],
                                    'expired' => ['color' => 'dark', 'label' => 'Süresi Doldu'],
                                ];
                                $config = $statusConfig[$quotation->status] ?? ['color' => 'secondary', 'label' => $quotation->status];
                            @endphp
                            <span class="badge badge-modern bg-{{ $config['color'] }}">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $quotation->createdBy->name }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('quotations.show', $quotation) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($quotation->status !== 'converted')
                                <a href="{{ route('quotations.edit', $quotation) }}"
                                   class="btn-icon btn-edit"
                                   title="Düzenle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                <button type="button"
                                        class="btn-icon btn-share"
                                        onclick="copyShareLink('{{ $quotation->share_url }}')"
                                        title="Link Kopyala">
                                    <i class="bi bi-share"></i>
                                </button>
                                @if($quotation->status !== 'converted')
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        onclick="deleteQuotation({{ $quotation->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
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

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#quotationsTable', {
        order: [[6, 'desc']], // Geçerlilik tarihine göre sırala
        pageLength: 10,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [9] }, // İşlemler
            { targets: 5, type: 'num' }, // En düşük fiyat
            { targets: 6, type: 'date' } // Geçerlilik tarihi
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterQuotationType, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const quotationType = $('#filterQuotationType').val();
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

        // Tür filtresi
        if (quotationType) {
            table.column(3).search(quotationType);
        } else {
            table.column(3).search('');
        }

        // Tarih filtresi (geçerlilik tarihi)
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[6]; // Geçerlilik sütunu
                    if (!dateStr || dateStr === '-') return true;

                    // Tarihi parse et
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
});

function clearFilters() {
    $('#filterStatus, #filterQuotationType, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#quotationsTable').DataTable();
    table.search('').columns().search('').draw();
}

function deleteQuotation(quotationId) {
    if (confirm('⚠️ Bu teklifi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/quotations/' + quotationId;
        form.submit();
    }
}

function copyShareLink(url) {
    navigator.clipboard.writeText(url).then(function() {
        const toast = `
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
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
        prompt('Linki manuel olarak kopyalayın:', url);
    });
}
</script>

<script>
$(document).ready(function() {

    // Mobile Search
    $('#mobileSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMobileCards(searchTerm);
    });

    // Mobile Filter Function
    function filterMobileCards(searchTerm = '') {
        const status = $('#filterStatus').val();
        const quotationType = $('#filterQuotationType').val();

        let visibleCount = 0;

        $('.quotation-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.quotation-card-ribbon').text().trim();
            const cardType = $card.find('.badge-pill').text().trim();

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // Type filter
            if (quotationType && !cardType.toLowerCase().includes(quotationType.toLowerCase())) {
                show = false;
            }

            if (show) {
                $card.show();
                visibleCount++;
            } else {
                $card.hide();
            }
        });
    }

    // Filter change event for mobile
    $('#filterStatus, #filterQuotationType').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterStatus, #filterQuotationType, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#quotationsTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.quotation-card-mobile').show();
}

// Existing functions remain the same...
</script>
@endpush
