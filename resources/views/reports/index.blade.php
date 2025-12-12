@extends('layouts.app')

@section('title', 'Raporlar')

@section('content')
<!-- Header -->
<div class="mb-4">
    <h1 class="h3 mb-2">
        <i class="bi bi-graph-up me-2"></i>Raporlar ve Analizler
    </h1>
    <p class="text-muted">İşletmenizin performansını analiz edin</p>
</div>

<!-- Rapor Kartları -->
<div class="row g-4">
    <!-- Satış Raporları -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
                <div class="report-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-graph-up" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title mb-2">Satış Raporları</h5>
                <p class="card-text text-muted small mb-3">
                    Poliçe satışları, prim tutarları ve performans analizleri
                </p>
                <a href="{{ route('reports.sales') }}" class="btn btn-primary w-100">
                    Raporları Görüntüle
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Komisyon Raporları -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
                <div class="report-icon bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-wallet2" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title mb-2">Komisyon Raporları</h5>
                <p class="card-text text-muted small mb-3">
                    Kazanç analizleri, şirket ve ürün bazında komisyon takibi
                </p>
                <a href="{{ route('reports.commission') }}" class="btn btn-success w-100">
                    Raporları Görüntüle
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Müşteri Analizleri -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
                <div class="report-icon bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title mb-2">Müşteri Analizleri</h5>
                <p class="card-text text-muted small mb-3">
                    Müşteri segmentasyonu, demografik analizler ve trendler
                </p>
                <a href="{{ route('reports.customers') }}" class="btn btn-info w-100">
                    Raporları Görüntüle
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Yenileme Raporları -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
                <div class="report-icon bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-repeat" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title mb-2">Yenileme Raporları</h5>
                <p class="card-text text-muted small mb-3">
                    Yenileme oranları, başarı metrikleri ve kayıp analizi
                </p>
                <a href="{{ route('reports.renewals') }}" class="btn btn-warning w-100">
                    Raporları Görüntüle
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Ödeme Raporları -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
                <div class="report-icon bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-cash-coin" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title mb-2">Ödeme Raporları</h5>
                <p class="card-text text-muted small mb-3">
                    Tahsilat takibi, ödeme yöntemleri ve nakit akışı
                </p>
                <a href="{{ route('reports.payments') }}" class="btn btn-danger w-100">
                    Raporları Görüntüle
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Özel Raporlar (Yakında) -->
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
                <div class="report-icon bg-secondary bg-opacity-10 text-secondary rounded-circle mx-auto mb-3"
                     style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-file-earmark-bar-graph" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="card-title mb-2">Özel Raporlar</h5>
                <p class="card-text text-muted small mb-3">
                    Özelleştirilebilir raporlar ve gelişmiş filtreler
                </p>
                <button class="btn btn-secondary w-100" disabled>
                    Yakında
                    <i class="bi bi-clock ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hızlı İstatistikler -->
<div class="row g-3 mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-speedometer2 me-2"></i>Hızlı Bakış
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-primary mb-1">{{ \App\Models\Policy::count() }}</h3>
                            <small class="text-muted">Toplam Poliçe</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-success mb-1">{{ number_format(\App\Models\Policy::sum('premium_amount'), 0) }} ₺</h3>
                            <small class="text-muted">Toplam Prim</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-info mb-1">{{ \App\Models\Customer::count() }}</h3>
                            <small class="text-muted">Toplam Müşteri</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-warning mb-1">{{ number_format(\App\Models\Policy::sum('commission_amount'), 0) }} ₺</h3>
                            <small class="text-muted">Toplam Komisyon</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.report-icon {
    transition: transform 0.2s;
}

.hover-card:hover .report-icon {
    transform: scale(1.1);
}
</style>
@endpush
