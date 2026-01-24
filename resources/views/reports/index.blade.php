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
        border: none;
        width: 100%;
        color: #fff !important;
    }

    .report-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .report-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .stats-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .stats-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
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
        .page-title {
            font-size: 1.5rem;
        }

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
@endpush

@section('content')
<div class="container-fluid">

        <!-- Hızlı İstatistikler -->
    <div class="stats-card card mb-5">
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-value text-primary">{{ number_format(\App\Models\Policy::count()) }}</div>
                        <div class="stat-label">Toplam Poliçe</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-value text-success">{{ number_format(\App\Models\Policy::sum('premium_amount'), 0) }} ₺</div>
                        <div class="stat-label">Toplam Prim</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-value text-info">{{ number_format(\App\Models\Customer::count()) }}</div>
                        <div class="stat-label">Toplam Müşteri</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <div class="stat-value text-warning">{{ number_format(\App\Models\Policy::sum('commission_amount'), 0) }} ₺</div>
                        <div class="stat-label">Toplam Komisyon</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rapor Kartları -->
    <div class="row g-4 mb-5">
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
                    <a href="{{ route('reports.commission') }}" class="btn btn-success report-btn">
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
                    <a href="{{ route('reports.customers') }}" class="btn btn-info report-btn">
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
                    <a href="{{ route('reports.renewals') }}" class="btn btn-warning report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ödeme Raporları -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper danger">
                        <i class="bi bi-cash-coin text-danger"></i>
                    </div>
                    <h5 class="report-title">Ödeme Raporları</h5>
                    <p class="report-description">
                        Tahsilat takibi, ödeme yöntemleri ve nakit akışı
                    </p>
                    <a href="{{ route('reports.payments') }}" class="btn btn-danger report-btn">
                        Raporları Görüntüle
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Özel Raporlar (Yakında) -->
        {{-- <div class="col-lg-4 col-md-6">
            <div class="report-card card">
                <div class="card-body">
                    <div class="report-icon-wrapper secondary">
                        <i class="bi bi-file-earmark-bar-graph text-secondary"></i>
                    </div>
                    <h5 class="report-title">Özel Raporlar</h5>
                    <p class="report-description">
                        Özelleştirilebilir raporlar ve gelişmiş filtreler
                    </p>
                    <button class="btn btn-secondary report-btn" disabled>
                        Yakında Gelecek
                        <i class="bi bi-clock ms-2"></i>
                    </button>
                </div>
            </div>
        </div> --}}
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
    </div>


</div>
@endsection
