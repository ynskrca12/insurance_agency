@extends('layouts.app')

@section('title', 'Müşteri Analizleri')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
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

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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

    .chart-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .chart-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .chart-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-title i {
        color: #6c757d;
        font-size: 1.25rem;
    }

    .chart-card .card-body {
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
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
        white-space: nowrap;
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

    .city-name {
        font-weight: 600;
        color: #212529;
    }

    .progress-modern {
        height: 1.5rem;
        border-radius: 8px;
        background: #e9ecef;
        overflow: hidden;
        min-width: 120px;
    }

    .progress-bar-modern {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        transition: width 0.6s ease;
    }

    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .rank-badge.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #000000;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
    }

    .rank-badge.silver {
        background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
        color: #000000;
        box-shadow: 0 2px 8px rgba(192, 192, 192, 0.3);
    }

    .rank-badge.bronze {
        background: linear-gradient(135deg, #cd7f32 0%, #e59866 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(205, 127, 50, 0.3);
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

    .customer-phone {
        color: #6c757d;
        font-size: 0.8125rem;
    }

    .policy-count-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .premium-value {
        font-weight: 700;
        color: #28a745;
        font-size: 1rem;
    }

    .period-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.9375rem;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .chart-container {
            height: 250px;
        }

        .progress-modern {
            min-width: 80px;
        }
    }
</style>
<style>
    /* ========================================
    CUSTOMER REPORTS - STAT CARDS
    ======================================== */

    .customer-stat-card {
        position: relative;
        border-radius: 14px;
        padding: 1.5rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 0.875rem;
        cursor: pointer;
    }

    .customer-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    /* Content */
    .customer-stat-content {
        z-index: 2;
        position: relative;
    }

    .customer-stat-value {
        font-size: 1.875rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .customer-stat-label {
        font-size: 0.813rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Background Icon */
    .customer-stat-bg {
        position: absolute;
        bottom: -15px;
        right: -15px;
        font-size: 130px;
        color: rgba(255, 255, 255, 0.08);
        z-index: 1;
        line-height: 1;
        pointer-events: none;
        transform: rotate(-15deg);
        transition: all 0.4s ease;
    }

    .customer-stat-card:hover .customer-stat-bg {
        transform: rotate(-10deg) scale(1.05);
        color: rgba(255, 255, 255, 0.12);
    }

    /* ========================================
    COLOR VARIANTS
    ======================================== */

    /* Primary - Mavi (Toplam) */
    .customer-stat-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .customer-stat-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Success - Yeşil (Aktif) */
    .customer-stat-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .customer-stat-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* Info - Cyan (Potansiyel) */
    .customer-stat-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .customer-stat-info:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    /* Warning - Turuncu (Ortalama) */
    .customer-stat-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .customer-stat-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    /* ========================================
    RESPONSIVE
    ======================================== */

    @media (max-width: 1200px) {
        .customer-stat-value {
            font-size: 1.625rem;
        }

        .customer-stat-bg {
            font-size: 110px;
        }
    }

    @media (max-width: 992px) {
        .customer-stat-card {
            padding: 1.25rem;
        }

        .customer-stat-value {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .customer-stat-value {
            font-size: 1.375rem;
        }

        .customer-stat-label {
            font-size: 0.75rem;
        }

        .customer-stat-bg {
            font-size: 90px;
            bottom: -10px;
            right: -10px;
        }
    }

    @media (max-width: 576px) {
        .customer-stat-card {
            padding: 1rem;
        }

        .customer-stat-value {
            font-size: 1.25rem;
        }

        .customer-stat-label {
            font-size: 0.688rem;
        }

        .customer-stat-bg {
            font-size: 75px;
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

    .customer-stat-card {
        animation: fadeInScale 0.5s ease-out;
    }

    .customer-stat-card:nth-child(1) { animation-delay: 0s; }
    .customer-stat-card:nth-child(2) { animation-delay: 0.05s; }
    .customer-stat-card:nth-child(3) { animation-delay: 0.1s; }
    .customer-stat-card:nth-child(4) { animation-delay: 0.15s; }

    /* ========================================
    CLICK EFFECT
    ======================================== */

    .customer-stat-card:active {
        transform: translateY(-2px) scale(0.98);
    }

    /* Hover overlay */
    .customer-stat-card::after {
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

    .customer-stat-card:hover::after {
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
                <h1 class="h4 mb-2 fw-bold text-dark">
                    <i class="bi bi-people me-2"></i>Müşteri Analizleri
                </h1>

            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-light action-btn">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <!-- Toplam Müşteri -->
        <div class="col-lg-3 col-md-6">
            <div class="customer-stat-card customer-stat-primary">
                <div class="customer-stat-content">
                    <div class="customer-stat-value">{{ number_format($stats['total_customers'] ?? 0) }}</div>
                    <div class="customer-stat-label">Toplam Müşteri</div>
                </div>
                <div class="customer-stat-bg">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <!-- Aktif Müşteri -->
        <div class="col-lg-3 col-md-6">
            <div class="customer-stat-card customer-stat-success">
                <div class="customer-stat-content">
                    <div class="customer-stat-value">{{ number_format($stats['active_customers'] ?? 0) }}</div>
                    <div class="customer-stat-label">Aktif Müşteri</div>
                </div>
                <div class="customer-stat-bg">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>

        <!-- Potansiyel Müşteri -->
        <div class="col-lg-3 col-md-6">
            <div class="customer-stat-card customer-stat-info">
                <div class="customer-stat-content">
                    <div class="customer-stat-value">{{ number_format($stats['potential_customers'] ?? 0) }}</div>
                    <div class="customer-stat-label">Potansiyel Müşteri</div>
                </div>
                <div class="customer-stat-bg">
                    <i class="bi bi-person-plus"></i>
                </div>
            </div>
        </div>

        <!-- Müşteri Başına Poliçe -->
        <div class="col-lg-3 col-md-6">
            <div class="customer-stat-card customer-stat-warning">
                <div class="customer-stat-content">
                    <div class="customer-stat-value">{{ number_format($avgPoliciesPerCustomer ?? 0, 1) }}</div>
                    <div class="customer-stat-label">Müşteri Başına Poliçe</div>
                </div>
                <div class="customer-stat-bg">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafikler ve Tablolar -->
    <div class="row g-4">
        <!-- Şehre Göre Dağılım -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-geo-alt"></i>
                        <span>Şehre Göre Müşteri Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Şehir</th>
                                    <th class="text-end">Müşteri Sayısı</th>
                                    <th class="text-end">Dağılım Oranı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customersByCity as $city)
                                <tr>
                                    <td>
                                        <span class="city-name">{{ $city->city }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ number_format($city->count) }}</strong>
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $percentage = $stats['total_customers'] > 0 ? ($city->count / $stats['total_customers']) * 100 : 0;
                                        @endphp
                                        <div class="progress-modern">
                                            <div class="progress-bar-modern" style="width: {{ $percentage }}%">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- En Değerli Müşteriler -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-trophy"></i>
                        <span>En Değerli Müşteriler (Top 10)</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Sıra</th>
                                    <th>Müşteri Bilgileri</th>
                                    <th class="text-end">Poliçe</th>
                                    <th class="text-end">Toplam Prim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $index => $customer)
                                <tr>
                                    <td>
                                        @if($index === 0)
                                            <span class="rank-badge gold">1</span>
                                        @elseif($index === 1)
                                            <span class="rank-badge silver">2</span>
                                        @elseif($index === 2)
                                            <span class="rank-badge bronze">3</span>
                                        @else
                                            <span class="text-muted fw-semibold">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.show', $customer) }}" class="customer-link">
                                            {{ $customer->name }}
                                        </a>
                                        <div class="customer-phone">{{ $customer->phone }}</div>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge policy-count-badge bg-info">{{ $customer->policy_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="premium-value">{{ number_format($customer->total_premium, 2) }} ₺</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush
