@extends('layouts.app')

@section('title', 'Raporlar')

@push('styles')
<style>
    .report-card {
        border: 1px solid #dcdcdc;
        border-radius: 45px;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .report-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        border-color: #b0b0b0;
    }

    .report-card .card-body {
        padding: 2rem;
        text-align: center;
    }

    .report-icon-wrapper {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }

    .report-card:hover .report-icon-wrapper {
        transform: scale(1.1);
    }

    .report-icon-wrapper i {
        font-size: 2.5rem;
    }

    .report-icon-wrapper.primary {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }

    .report-icon-wrapper.success {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    }

    .report-icon-wrapper.info {
        background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);
    }

    .report-icon-wrapper.warning {
        background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
    }

    .report-icon-wrapper.danger {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
    }

    .report-icon-wrapper.secondary {
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
    }

    .report-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.75rem;
    }

    .report-description {
        color: #6c757d;
        font-size: 0.9375rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        min-height: 3rem;
    }

    .report-btn {
        border-radius: 20px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        color: #000 !important;
        background: #fff;
        border:1px solid #000;
    }
    .report-btn:hover{
        color: #fff !important;
        background: #000;
        border:1px solid #000;
    }

    .report-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .stats-card {
        border: 0;
        background: transparent;
    }

    .stat-item {
        padding: 1.5rem;
        border-right: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-item:hover {
        background: #fafafa;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .report-card {
        animation: fadeInUp 0.5s ease forwards;
    }

    .report-card:nth-child(1) { animation-delay: 0.1s; }
    .report-card:nth-child(2) { animation-delay: 0.2s; }
    .report-card:nth-child(3) { animation-delay: 0.3s; }
    .report-card:nth-child(4) { animation-delay: 0.4s; }
    .report-card:nth-child(5) { animation-delay: 0.5s; }
    .report-card:nth-child(6) { animation-delay: 0.6s; }

    @media (max-width: 768px) {

        .report-icon-wrapper {
            width: 4rem;
            height: 4rem;
        }

        .report-icon-wrapper i {
            font-size: 2rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .stat-item {
            border-right: none;
            border-bottom: 1px solid #f0f0f0;
        }

        .stat-item:last-child {
            border-bottom: none;
        }
    }
</style>
<style>
    .dashboard-stat-card {
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

    .dashboard-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    /* Content */
    .dashboard-stat-content {
        z-index: 2;
        position: relative;
    }

    .dashboard-stat-value {
        font-size: 1.875rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dashboard-stat-label {
        font-size: 0.813rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Background Icon */
    .dashboard-stat-bg {
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

    .dashboard-stat-card:hover .dashboard-stat-bg {
        transform: rotate(-10deg) scale(1.05);
        color: rgba(255, 255, 255, 0.12);
    }

    /* ========================================
    COLOR VARIANTS
    ======================================== */

    /* Primary - Mavi (Toplam Poliçe) */
    .dashboard-stat-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .dashboard-stat-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Success - Yeşil (Toplam Prim) */
    .dashboard-stat-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .dashboard-stat-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* Info - Cyan (Toplam Müşteri) */
    .dashboard-stat-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .dashboard-stat-info:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    /* Warning - Turuncu (Toplam Komisyon) */
    .dashboard-stat-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .dashboard-stat-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    /* ========================================
    RESPONSIVE
    ======================================== */

    @media (max-width: 1200px) {
        .dashboard-stat-value {
            font-size: 1.625rem;
        }

        .dashboard-stat-bg {
            font-size: 110px;
        }
    }

    @media (max-width: 992px) {
        .dashboard-stat-card {
            padding: 1.25rem;
        }

        .dashboard-stat-value {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .dashboard-stat-value {
            font-size: 1.375rem;
        }

        .dashboard-stat-label {
            font-size: 0.75rem;
        }

        .dashboard-stat-bg {
            font-size: 90px;
            bottom: -10px;
            right: -10px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-stat-card {
            padding: 1rem;
        }

        .dashboard-stat-value {
            font-size: 1.25rem;
        }

        .dashboard-stat-label {
            font-size: 0.688rem;
        }

        .dashboard-stat-bg {
            font-size: 75px;
        }
    }

    /* ========================================
    ANIMATION
    ======================================== */

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dashboard-stat-card {
        animation: fadeInDown 0.5s ease-out;
    }

    .dashboard-stat-card:nth-child(1) { animation-delay: 0s; }
    .dashboard-stat-card:nth-child(2) { animation-delay: 0.05s; }
    .dashboard-stat-card:nth-child(3) { animation-delay: 0.1s; }
    .dashboard-stat-card:nth-child(4) { animation-delay: 0.15s; }

    /* ========================================
    CLICK EFFECT
    ======================================== */

    .dashboard-stat-card:active {
        transform: translateY(-2px) scale(0.98);
    }

    /* Hover overlay */
    .dashboard-stat-card::after {
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

    .dashboard-stat-card:hover::after {
        background: rgba(255, 255, 255, 0.1);
    }

    /* ========================================
    SHINE EFFECT (Success için)
    ======================================== */

    .dashboard-stat-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        z-index: 2;
        transition: left 0.5s ease;
    }

    .dashboard-stat-success:hover::before {
        animation: shine 1s ease;
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <!-- Toplam Poliçe -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-stat-card dashboard-stat-primary">
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-value">{{ number_format(\App\Models\Policy::count()) }}</div>
                    <div class="dashboard-stat-label">Toplam Poliçe</div>
                </div>
                <div class="dashboard-stat-bg">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>

        <!-- Toplam Prim -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-stat-card dashboard-stat-success">
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-value">{{ number_format(\App\Models\Policy::sum('premium_amount'), 0) }} ₺</div>
                    <div class="dashboard-stat-label">Toplam Prim</div>
                </div>
                <div class="dashboard-stat-bg">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>

        <!-- Toplam Müşteri -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-stat-card dashboard-stat-info">
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-value">{{ number_format(\App\Models\Customer::count()) }}</div>
                    <div class="dashboard-stat-label">Toplam Müşteri</div>
                </div>
                <div class="dashboard-stat-bg">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <!-- Toplam Komisyon -->
        <div class="col-lg-3 col-md-6">
            <div class="dashboard-stat-card dashboard-stat-warning">
                <div class="dashboard-stat-content">
                    <div class="dashboard-stat-value">{{ number_format(\App\Models\Policy::sum('commission_amount'), 0) }} ₺</div>
                    <div class="dashboard-stat-label">Toplam Komisyon</div>
                </div>
                <div class="dashboard-stat-bg">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rapor Kartları -->
    <div class="row g-4 mb-5">

        <!-- Cari İşlemler Raporları -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper secondary">
                        <i class="bi bi-file-earmark-bar-graph text-secondary"></i>
                    </div>
                    <h5 class="report-title">Cari İşlemler Raporları</h5>
                    <p class="report-description">
                        Alacak/borç durumu, yaşlandırma raporu ve tahsilat analizi
                    </p>
                    <a href="{{ route('reports.cari') }}" class="btn btn-secondary report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Müşteri Analizleri -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper info">
                        <i class="bi bi-people text-info"></i>
                    </div>
                    <h5 class="report-title">Müşteri Analizleri</h5>
                    <p class="report-description">
                        Müşteri segmentasyonu, demografik analizler ve trendler
                    </p>
                    <a href="{{ route('reports.customers') }}" class="btn report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Satış Raporları -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper primary">
                        <i class="bi bi-graph-up text-primary"></i>
                    </div>
                    <h5 class="report-title">Satış Raporları</h5>
                    <p class="report-description">
                        Poliçe satışları, prim tutarları ve performans analizleri
                    </p>
                    <a href="{{ route('reports.sales') }}" class="btn btn-primary report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Finansal Özet -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper warning">
                        <i class="bi bi-arrow-repeat text-warning"></i>
                    </div>
                    <h5 class="report-title">Finansal Özet</h5>
                    <p class="report-description">
                        Gelir/gider analizi, nakit akış, kasa/banka durumu ve karlılık raporları
                    </p>
                    <a href="{{ route('reports.financial') }}" class="btn report-btn">
                       Finansal sağlık
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Satış Performans -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper secondary">
                        <i class="bi bi-file-earmark-bar-graph text-secondary"></i>
                    </div>
                    <h5 class="report-title">Satış Performans</h5>
                    <p class="report-description">
                        Temsilci performansı, hedefler, leaderboard ve kişisel metrikler
                    </p>
                    <a href="{{ route('reports.salesPerformance') }}" class="btn btn-secondary report-btn">
                        Performans Takibi
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Komisyon Raporları -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper success">
                        <i class="bi bi-wallet2 text-success"></i>
                    </div>
                    <h5 class="report-title">Komisyon Raporları</h5>
                    <p class="report-description">
                        Kazanç analizleri, şirket ve ürün bazında komisyon takibi
                    </p>
                    <a href="{{ route('reports.commission') }}" class="btn report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Yenileme Raporları -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper warning">
                        <i class="bi bi-arrow-repeat text-warning"></i>
                    </div>
                    <h5 class="report-title">Yenileme Raporları</h5>
                    <p class="report-description">
                        Yenileme oranları, başarı metrikleri ve kayıp analizi
                    </p>
                    <a href="{{ route('reports.renewals') }}" class="btn report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>




    </div>


</div>
@endsection
