@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        position: relative;
        border-radius: 16px;
        padding: 1.75rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .stat-card-content {
        position: relative;
        z-index: 2;
    }

    .stat-info {
        flex: 1;
    }

    .stat-card .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 0.5rem;
    }

    .stat-card .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.75rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-card .stat-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.813rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.8);
    }

    .stat-card-bg {
        position: absolute;
        bottom: -20px;
        right: -20px;
        font-size: 180px;
        color: rgba(255, 255, 255, 0.08);
        z-index: 1;
        line-height: 1;
        pointer-events: none;
        transform: rotate(-15deg);
        transition: all 0.4s ease;
    }

    .stat-card:hover .stat-card-bg {
        transform: rotate(-10deg) scale(1.1);
        color: rgba(255, 255, 255, 0.12);
    }

    /* Color Variants */
    .stat-card-primary { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .stat-card-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .stat-card-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-card-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-card-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .stat-card-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }

    .content-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .content-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .content-card .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-card {
        border-left: 4px solid;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        background: #ffffff;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-card:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .alert-card.danger {
        border-left-color: #dc3545;
        background: linear-gradient(90deg, #fff5f5 0%, #ffffff 100%);
    }

    .alert-card.warning {
        border-left-color: #ffc107;
        background: linear-gradient(90deg, #fffbf0 0%, #ffffff 100%);
    }

    .alert-card.info {
        border-left-color: #0dcaf0;
        background: linear-gradient(90deg, #f0f9ff 0%, #ffffff 100%);
    }

    .alert-icon {
        font-size: 2rem;
        flex-shrink: 0;
    }

    .alert-card.danger .alert-icon { color: #dc3545; }
    .alert-card.warning .alert-icon { color: #ffc107; }
    .alert-card.info .alert-icon { color: #0dcaf0; }

    .call-list-item {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .call-list-item:hover {
        border-color: #0dcaf0;
        box-shadow: 0 2px 8px rgba(13, 202, 240, 0.1);
    }

    .priority-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-high {
        background: #dc3545;
        color: #ffffff;
    }

    .priority-medium {
        background: #ffc107;
        color: #000000;
    }

    .progress-custom {
        height: 1.5rem;
        border-radius: 8px;
        background: #f0f0f0;
        overflow: hidden;
    }

    .progress-custom .progress-bar {
        font-weight: 600;
        font-size: 0.8125rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .br-14 {
        border-radius: 14px !important;
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 1.5rem;
        }
        .stat-card .stat-value {
            font-size: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="h4 mb-0 fw-bold text-dark">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </h1>
        <p class="text-muted mb-0">
            Hoş geldin, <strong>{{ $user->name }}</strong> ·
            <span>{{ now()->translatedFormat('d F Y, l') }}</span>
        </p>
    </div>

    <!-- 📊 Bugünün Özeti -->
    <div class="content-card card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-calendar-check"></i>
                <span>Bugünün Özeti</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="fs-2 fw-bold text-primary">{{ $todaySummary['policies'] }}</div>
                        <small class="text-muted">Yeni Poliçe</small>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="fs-2 fw-bold text-success">{{ number_format($todaySummary['premium'], 0) }}₺</div>
                        <small class="text-muted">Toplam Prim</small>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="fs-2 fw-bold text-info">{{ number_format($todaySummary['collections'], 0) }}₺</div>
                        <small class="text-muted">Tahsilat</small>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="fs-2 fw-bold text-purple">{{ $todaySummary['customers'] }}</div>
                        <small class="text-muted">Yeni Müşteri</small>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="fs-2 fw-bold text-danger">{{ $todaySummary['expires_today'] }}</div>
                        <small class="text-muted">Bugün Biten</small>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="text-center">
                        <div class="fs-2 fw-bold text-warning">%{{ number_format($todaySummary['target_progress'], 0) }}</div>
                        <small class="text-muted">Hedef</small>
                    </div>
                </div>
            </div>

            <!-- Günlük Hedef Progress -->
            <div class="mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Günlük Hedef</small>
                    <small class="fw-semibold">{{ number_format($todaySummary['premium'], 0) }}₺ / {{ number_format($todaySummary['daily_target'], 0) }}₺</small>
                </div>
                <div class="progress-custom">
                    <div class="progress-bar bg-{{ $todaySummary['target_progress'] >= 100 ? 'success' : ($todaySummary['target_progress'] >= 70 ? 'warning' : 'danger') }}"
                         style="width: {{ min(100, $todaySummary['target_progress']) }}%">
                        %{{ number_format($todaySummary['target_progress'], 0) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📈 Aylık Performans -->
    <div class="content-card card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-graph-up"></i>
                <span>Aylık Performans ({{ now()->translatedFormat('F') }})</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Poliçe Hedefi -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold">Poliçe Sayısı</span>
                            <span class="text-muted">{{ $monthlyPerformance['policies'] }} / {{ $monthlyPerformance['policy_target'] }}</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar bg-primary"
                                 style="width: {{ min(100, $monthlyPerformance['policy_progress']) }}%">
                                %{{ number_format($monthlyPerformance['policy_progress'], 0) }}
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-{{ $monthlyPerformance['policy_change'] >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-{{ $monthlyPerformance['policy_change'] >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                {{ number_format(abs($monthlyPerformance['policy_change']), 1) }}% önceki aya göre
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Prim Hedefi -->
                <div class="col-lg-6">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold">Toplam Prim</span>
                            <span class="text-muted">{{ number_format($monthlyPerformance['premium'], 0) }}₺ / {{ number_format($monthlyPerformance['premium_target'], 0) }}₺</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar bg-success"
                                 style="width: {{ min(100, $monthlyPerformance['premium_progress']) }}%">
                                %{{ number_format($monthlyPerformance['premium_progress'], 0) }}
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-{{ $monthlyPerformance['premium_change'] >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-{{ $monthlyPerformance['premium_change'] >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                {{ number_format(abs($monthlyPerformance['premium_change']), 1) }}% önceki aya göre
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aylık Özet -->
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="text-center p-3 bg-light rounded">
                        <small class="text-muted d-block">Komisyon</small>
                        <div class="fs-4 fw-bold text-success">{{ number_format($monthlyPerformance['commission'], 2) }}₺</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center p-3 bg-light rounded">
                        <small class="text-muted d-block">Tahsilat</small>
                        <div class="fs-4 fw-bold text-info">{{ number_format($monthlyPerformance['collections'], 2) }}₺</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Son 7 Gün Trend -->
    <div class="content-card card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-graph-down"></i>
                <span>Son 7 Gün Trend</span>
            </h5>
        </div>
        <div class="card-body">
            <canvas id="weeklyTrendChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- 🔔 Kritik Uyarılar -->
        <div class="col-lg-6">
            <div class="content-card card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Kritik Uyarılar</span>
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($criticalAlerts as $alert)
                    <div class="alert-card {{ $alert['type'] }}">
                        <div class="alert-icon">
                            <i class="{{ $alert['icon'] }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">{{ $alert['title'] }}</h6>
                            <p class="mb-0 text-muted small">{{ $alert['message'] }}</p>
                        </div>
                        @if($alert['count'])
                        <div class="badge bg-{{ $alert['type'] }} rounded-pill">{{ $alert['count'] }}</div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">Kritik uyarı yok, her şey yolunda! 🎉</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 📞 Bugün Aranacaklar -->
        <div class="col-lg-6">
            <div class="content-card card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-telephone"></i>
                        <span>Bugün Aranacaklar</span>
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($todayCallList as $item)
                    <div class="call-list-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $item['customer']->name }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-telephone me-1"></i>{{ $item['customer']->phone }}
                                </small>
                            </div>
                            <span class="priority-badge priority-{{ $item['priority'] }}">
                                {{ strtoupper($item['priority']) }}
                            </span>
                        </div>
                        <p class="mb-0 small text-muted">
                            <i class="bi bi-info-circle me-1"></i>{{ $item['reason'] }}
                        </p>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-telephone-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">Arama listesi boş</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">Toplam Müşteri</div>
                        <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
                        <div class="stat-meta">
                            <i class="bi bi-arrow-up"></i>
                            <span>Aktif sistem</span>
                        </div>
                    </div>
                </div>
                <div class="stat-card-bg">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-card-purple">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">Toplam Poliçe</div>
                        <div class="stat-value">{{ number_format($stats['total_policies']) }}</div>
                        <div class="stat-meta">
                            <i class="bi bi-graph-up"></i>
                            <span>Tüm poliçeler</span>
                        </div>
                    </div>
                </div>
                <div class="stat-card-bg">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">Süresi Yaklaşan</div>
                        <div class="stat-value">{{ number_format($stats['expiring_soon']) }}</div>
                        <div class="stat-meta">
                            <i class="bi bi-exclamation-circle"></i>
                            <span>Dikkat gerekli</span>
                        </div>
                    </div>
                </div>
                <div class="stat-card-bg">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">Bekleyen Görev</div>
                        <div class="stat-value">{{ number_format($stats['pending_tasks']) }}</div>
                        <div class="stat-meta">
                            <i class="bi bi-list-check"></i>
                            <span>Yapılacaklar</span>
                        </div>
                    </div>
                </div>
                <div class="stat-card-bg">
                    <i class="bi bi-check-square"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Cari Durum -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-danger h-100 br-14">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="text-muted mb-0">Müşteri Alacakları</h6>
                        </div>
                        <div>
                            <i class="bi bi-person-circle text-danger fs-3"></i>
                        </div>
                    </div>
                    <h3 class="mb-2 text-danger">
                        {{ number_format(abs($cariDurum['musteri_alacak']), 2) }}₺
                    </h3>
                    <small class="text-muted">
                        <i class="bi bi-arrow-up me-1"></i>
                        Bizim alacağımız
                    </small>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Vade Geçmiş:</small>
                        <strong class="text-danger">{{ number_format($cariDurum['vade_gecmis'], 2) }}₺</strong>
                    </div>
                    <a href="{{ route('cari-hesaplar.index', ['tip' => 'musteri', 'bakiye_durumu' => 'borclu']) }}"
                       class="btn btn-sm btn-outline-danger w-100 mt-2">
                        <i class="bi bi-eye me-1"></i>Detay
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning h-100 br-14">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="text-muted mb-0">Şirket Borçları</h6>
                        </div>
                        <div>
                            <i class="bi bi-building text-warning fs-3"></i>
                        </div>
                    </div>
                    <h3 class="mb-2 text-warning">
                        {{ number_format(abs($cariDurum['sirket_borc']), 2) }}₺
                    </h3>
                    <small class="text-muted">
                        <i class="bi bi-arrow-down me-1"></i>
                        Bizim borcumuz
                    </small>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Aktif Şirket:</small>
                        <strong>
                            {{ \App\Models\CariHesap::where('tip', 'sirket')->count() }}
                        </strong>
                    </div>
                    <a href="{{ route('cari-hesaplar.index', ['tip' => 'sirket']) }}"
                       class="btn btn-sm btn-outline-warning w-100 mt-2">
                        <i class="bi bi-eye me-1"></i>Detay
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success h-100 br-14">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="text-muted mb-0">Kasa/Banka</h6>
                        </div>
                        <div>
                            <i class="bi bi-wallet2 text-success fs-3"></i>
                        </div>
                    </div>
                    <h3 class="mb-2 text-success">
                        {{ number_format(abs($cariDurum['kasa_banka']), 2) }}₺
                    </h3>
                    <small class="text-muted">
                        <i class="bi bi-arrow-right me-1"></i>
                        Mevcut bakiye
                    </small>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Hesap Sayısı:</small>
                        <strong>
                            {{ \App\Models\CariHesap::whereIn('tip', ['kasa', 'banka'])->count() }}
                        </strong>
                    </div>
                    <a href="{{ route('cari-hesaplar.kasa-banka') }}"
                       class="btn btn-sm btn-outline-success w-100 mt-2">
                        <i class="bi bi-eye me-1"></i>Rapor
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-info h-100 br-14">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="text-muted mb-0">Bugünkü Hareketler</h6>
                        </div>
                        <div>
                            <i class="bi bi-calendar-check text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Tahsilatlar</small>
                        <h5 class="mb-0 text-success">
                            +{{ number_format($cariDurum['bugun_tahsilat'], 2) }}₺
                        </h5>
                    </div>
                    <div>
                        <small class="text-muted d-block">Ödemeler</small>
                        <h5 class="mb-0 text-danger">
                            -{{ number_format($cariDurum['bugun_odeme'], 2) }}₺
                        </h5>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Net:</small>
                        <strong class="{{ ($cariDurum['bugun_tahsilat'] - $cariDurum['bugun_odeme']) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($cariDurum['bugun_tahsilat'] - $cariDurum['bugun_odeme'], 2) }}₺
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- İçerik Kartları -->
    <div class="row g-4 mb-4">
        <!-- Süresi Yaklaşan Poliçeler -->
        <div class="col-lg-8">
            <div class="content-card card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <span>Süresi Yaklaşan Poliçeler</span>
                        </h5>
                        <a href="{{ route('policies.index') }}" class="btn btn-sm btn-light">
                            <span>Tümünü Gör</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($expiringPolicies->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mb-1 mt-3">Harika!</h6>
                            <p class="text-muted small mb-0">Süresi yaklaşan poliçe bulunmuyor.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: #fafafa;">
                                    <tr>
                                        <th>Müşteri</th>
                                        <th>Poliçe No</th>
                                        <th>Tür</th>
                                        <th>Bitiş</th>
                                        <th>Kalan</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringPolicies as $policy)
                                    <tr>
                                        <td>
                                            <a href="{{ route('customers.show', $policy->customer) }}" class="text-decoration-none fw-semibold">
                                                {{ $policy->customer->name }}
                                            </a>
                                        </td>
                                        <td><small class="text-muted">{{ $policy->policy_number }}</small></td>
                                        <td><span class="badge bg-info">{{ $policy->policy_type_label }}</span></td>
                                        <td><small>{{ $policy->end_date->format('d.m.Y') }}</small></td>
                                        <td><small class="text-muted">{{ $policy->end_date->diffForHumans() }}</small></td>
                                        <td>
                                            @if($policy->status === 'critical')
                                                <span class="badge bg-danger">Kritik</span>
                                            @else
                                                <span class="badge bg-warning">Yaklaşıyor</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Son Müşteriler -->
        <div class="col-lg-4">
            <div class="content-card card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-plus text-primary"></i>
                            <span>Son Müşteriler</span>
                        </h5>
                        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-light">
                            <span>Tümü</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentCustomers->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                            <h6 class="text-muted mb-1 mt-3">Müşteri Yok</h6>
                            <p class="text-muted small mb-3">Henüz müşteri eklenmemiş.</p>
                            <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Müşteri Ekle
                            </a>
                        </div>
                    @else
                        @foreach($recentCustomers as $customer)
                        <a href="{{ route('customers.show', $customer) }}" class="d-flex align-items-center p-3 border-bottom text-decoration-none" style="transition: all 0.3s;">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem; font-weight: 600;">
                                {{ strtoupper(mb_substr($customer->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-dark">{{ $customer->name }}</h6>
                                <small class="text-muted">{{ $customer->phone }}</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                        @endforeach

                        <div class="px-3 py-3 bg-light">
                            <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>
                                Yeni Müşteri Ekle
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hızlı İşlemler -->
    <div class="content-card card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-lightning"></i>
                <span>Hızlı İşlemler</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('customers.create') }}" class="btn btn-light d-flex flex-column align-items-center p-3 w-100 border">
                        <i class="bi bi-person-plus-fill mb-2 text-primary" style="font-size: 2rem;"></i>
                        <strong>Yeni Müşteri</strong>
                        <small class="text-muted">Müşteri ekle</small>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('policies.create') }}" class="btn btn-light d-flex flex-column align-items-center p-3 w-100 border">
                        <i class="bi bi-file-earmark-plus-fill mb-2 text-success" style="font-size: 2rem;"></i>
                        <strong>Yeni Poliçe</strong>
                        <small class="text-muted">Poliçe oluştur</small>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('tahsilatlar.create') }}" class="btn btn-light d-flex flex-column align-items-center p-3 w-100 border">
                        <i class="bi bi-cash-coin mb-2 text-info" style="font-size: 2rem;"></i>
                        <strong>Tahsilat</strong>
                        <small class="text-muted">Ödeme al</small>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('reports.index') }}" class="btn btn-light d-flex flex-column align-items-center p-3 w-100 border">
                        <i class="bi bi-graph-up-arrow mb-2 text-warning" style="font-size: 2rem;"></i>
                        <strong>Raporlar</strong>
                        <small class="text-muted">Rapor görüntüle</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Haftalık Trend Chart
const trendCtx = document.getElementById('weeklyTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($weeklyTrend->pluck('date')) !!},
        datasets: [
            {
                label: 'Poliçe',
                data: {!! json_encode($weeklyTrend->pluck('policies')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                yAxisID: 'y1',
            },
            {
                label: 'Prim (₺)',
                data: {!! json_encode($weeklyTrend->pluck('premium')) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
            },
            {
                label: 'Tahsilat (₺)',
                data: {!! json_encode($weeklyTrend->pluck('collections')) !!},
                backgroundColor: 'rgba(6, 182, 212, 0.1)',
                borderColor: 'rgb(6, 182, 212)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false,
                },
            }
        }
    }
});
</script>
@endpush
