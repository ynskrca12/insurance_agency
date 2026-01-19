@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .stat-card .card-body {
        padding: 1.5rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-trend {
        font-size: 0.8125rem;
        font-weight: 500;
    }

    .content-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
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

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead th {
        background: #f8f9fa;
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

    .customer-list-item {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        color: inherit;
    }

    .customer-list-item:last-child {
        border-bottom: none;
    }

    .customer-list-item:hover {
        background: #f8f9fa;
        border-radius: 8px;
    }

    .customer-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 600;
        border: 1px solid #e0e0e0;
        flex-shrink: 0;
    }

    .customer-info h6 {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .customer-info small {
        color: #6c757d;
        font-size: 0.8125rem;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .quick-action-btn {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-action-btn:hover {
        border-color: #b0b0b0;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .stat-card .card-body {
            padding: 1.25rem;
        }

        .stat-value {
            font-size: 1.75rem;
        }
    }
</style>

<style>
    /* ========================================
    DASHBOARD - COLORED STAT CARDS
    ======================================== */

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
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
    }

    /* Stat Info */
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

    .stat-card .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.813rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.8);
    }

    .stat-card .stat-trend i {
        font-size: 1rem;
    }

    /* Background Icon */
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

    /* ========================================
    COLOR VARIANTS
    ======================================== */

    /* Primary - Mavi */
    .stat-card-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .stat-card-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Purple - Mor */
    .stat-card-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .stat-card-purple:hover {
        background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    }

    /* Warning - Turuncu */
    .stat-card-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-card-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    /* Success - Yeşil */
    .stat-card-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* Danger - Kırmızı (opsiyonel) */
    .stat-card-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stat-card-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    /* Info - Cyan (opsiyonel) */
    .stat-card-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .stat-card-info:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    /* ========================================
    RESPONSIVE
    ======================================== */

    @media (max-width: 1200px) {
        .stat-card .stat-value {
            font-size: 2rem;
        }

        .stat-card-bg {
            font-size: 140px;
        }
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 1.5rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
        }

        .stat-card-bg {
            font-size: 120px;
            bottom: -15px;
            right: -15px;
        }
    }

    @media (max-width: 576px) {
        .stat-card .stat-value {
            font-size: 1.5rem;
        }

        .stat-card .stat-label {
            font-size: 0.75rem;
        }

        .stat-card-bg {
            font-size: 100px;
        }
    }

    /* ========================================
    ANIMATION
    ======================================== */

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>

<style>
    .br-14{
        border-radius: 14px !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

<!-- İstatistik Kartları -->
<div class="row g-4 mb-4">
    <!-- Toplam Müşteri - MAVİ -->
    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Toplam Müşteri</div>
                    <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
                    <div class="stat-trend">
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

    <!-- Toplam Poliçe - MOR -->
    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-purple">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Toplam Poliçe</div>
                    <div class="stat-value">{{ number_format($stats['total_policies']) }}</div>
                    <div class="stat-trend">
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

    <!-- Süresi Yaklaşan - TURUNCU -->
    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Süresi Yaklaşan</div>
                    <div class="stat-value">{{ number_format($stats['expiring_soon']) }}</div>
                    <div class="stat-trend">
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

    <!-- Bekleyen Görevler - YEŞİL -->
    <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-success">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Bekleyen Görev</div>
                    <div class="stat-value">{{ number_format($stats['pending_tasks']) }}</div>
                    <div class="stat-trend">
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

    <!-- İçerik Kartları -->
    <div class="row g-4">
        <!-- Süresi Yaklaşan Poliçeler -->
        <div class="col-lg-8">
            <div class="content-card card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <span>Süresi Yaklaşan Poliçeler</span>
                        </h5>
                        <a href="#" class="quick-action-btn btn-light">
                            <span>Tümünü Gör</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($expiringPolicies->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-check-circle"></i>
                            <h6 class="text-muted mb-1">Harika!</h6>
                            <p class="text-muted small mb-0">Süresi yaklaşan poliçe bulunmuyor.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>Müşteri</th>
                                        <th>Poliçe No</th>
                                        <th>Poliçe Türü</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Kalan Süre</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringPolicies as $policy)
                                    <tr>
                                        <td>
                                            <a href="{{ route('customers.show', $policy->customer) }}"
                                               class="text-decoration-none text-dark fw-semibold">
                                                {{ $policy->customer->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $policy->policy_number }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-modern bg-info">
                                                {{ $policy->policy_type_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $policy->end_date->format('d.m.Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $policy->end_date->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($policy->status === 'critical')
                                                <span class="badge badge-modern bg-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                    Kritik
                                                </span>
                                            @else
                                                <span class="badge badge-modern bg-warning">
                                                    <i class="bi bi-clock me-1"></i>
                                                    Yaklaşıyor
                                                </span>
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

        <!-- Son Eklenen Müşteriler -->
        <div class="col-lg-4">
            <div class="content-card card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-plus text-primary"></i>
                            <span>Son Müşteriler</span>
                        </h5>
                        <a href="{{ route('customers.index') }}" class="quick-action-btn btn-light">
                            <span>Tümü</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentCustomers->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <h6 class="text-muted mb-1">Müşteri Yok</h6>
                            <p class="text-muted small mb-3">Henüz müşteri eklenmemiş.</p>
                            <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Müşteri Ekle
                            </a>
                        </div>
                    @else
                        <div class="customer-list">
                            @foreach($recentCustomers as $customer)
                            <a href="{{ route('customers.show', $customer) }}" class="customer-list-item">
                                <div class="customer-avatar bg-primary bg-opacity-10 text-primary">
                                    {{ strtoupper(mb_substr($customer->name, 0, 1)) }}
                                </div>
                                <div class="customer-info flex-grow-1">
                                    <h6 class="mb-0">{{ $customer->name }}</h6>
                                    <small>{{ $customer->phone }}</small>
                                </div>
                                <div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        <div class="px-3 py-3 bg-light border-top">
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

    {{-- Cari Durum Dashboard Widget --}}
@php
    $musteriCariToplam = \App\Models\CariHesap::where('tenant_id', auth()->id())
        ->where('tip', 'musteri')
        ->sum('bakiye');

    $sirketCariToplam = \App\Models\CariHesap::where('tenant_id', auth()->id())
        ->where('tip', 'sirket')
        ->sum('bakiye');

    $kasaBankaToplam = \App\Models\CariHesap::where('tenant_id', auth()->id())
        ->whereIn('tip', ['kasa', 'banka'])
        ->sum('bakiye');

    $vadeGecmisMusteriler = \App\Models\CariHareket::where('tenant_id', auth()->id())
        ->where('islem_tipi', 'borc')
        ->where('vade_tarihi', '<', now())
        ->whereNull('karsi_cari_hesap_id')
        ->whereHas('cariHesap', function($q) {
            $q->where('tip', 'musteri');
        })
        ->sum('tutar');

    $bugunTahsilatlar = \App\Models\Tahsilat::where('tenant_id', auth()->id())
        ->whereDate('tahsilat_tarihi', today())
        ->sum('tutar');

    $bugunOdemeler = \App\Models\SirketOdeme::where('tenant_id', auth()->id())
        ->whereDate('odeme_tarihi', today())
        ->sum('tutar');
@endphp

<div class="row mb-4">
    <div class="col-12">
        <h5 class="mb-3">
            <i class="bi bi-cash-stack me-2"></i>
            Cari Durum Özeti
        </h5>
    </div>
</div>

<div class="row mb-4">
    {{-- Müşteri Alacaklar --}}
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
                    {{ number_format(abs($musteriCariToplam), 2) }}₺
                </h3>
                <small class="text-muted">
                    <i class="bi bi-arrow-up me-1"></i>
                    Bizim alacağımız
                </small>
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Vade Geçmiş:</small>
                    <strong class="text-danger">{{ number_format($vadeGecmisMusteriler, 2) }}₺</strong>
                </div>
                <a href="{{ route('cari-hesaplar.index', ['tip' => 'musteri', 'bakiye_durumu' => 'borclu']) }}"
                   class="btn btn-sm btn-outline-danger w-100 mt-2">
                    <i class="bi bi-eye me-1"></i>Detay
                </a>
            </div>
        </div>
    </div>

    {{-- Şirket Borçlar --}}
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
                    {{ number_format(abs($sirketCariToplam), 2) }}₺
                </h3>
                <small class="text-muted">
                    <i class="bi bi-arrow-down me-1"></i>
                    Bizim borcumuz
                </small>
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Aktif Şirket:</small>
                    <strong>
                        {{ \App\Models\CariHesap::where('tenant_id', auth()->id())->where('tip', 'sirket')->count() }}
                    </strong>
                </div>
                <a href="{{ route('cari-hesaplar.index', ['tip' => 'sirket']) }}"
                   class="btn btn-sm btn-outline-warning w-100 mt-2">
                    <i class="bi bi-eye me-1"></i>Detay
                </a>
            </div>
        </div>
    </div>

    {{-- Kasa/Banka --}}
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
                    {{ number_format(abs($kasaBankaToplam), 2) }}₺
                </h3>
                <small class="text-muted">
                    <i class="bi bi-arrow-right me-1"></i>
                    Mevcut bakiye
                </small>
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Hesap Sayısı:</small>
                    <strong>
                        {{ \App\Models\CariHesap::where('tenant_id', auth()->id())->whereIn('tip', ['kasa', 'banka'])->count() }}
                    </strong>
                </div>
                <a href="{{ route('cari-hesaplar.kasa-banka') }}"
                   class="btn btn-sm btn-outline-success w-100 mt-2">
                    <i class="bi bi-eye me-1"></i>Rapor
                </a>
            </div>
        </div>
    </div>

    {{-- Bugünkü Hareketler --}}
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
                        +{{ number_format($bugunTahsilatlar, 2) }}₺
                    </h5>
                </div>
                <div>
                    <small class="text-muted d-block">Ödemeler</small>
                    <h5 class="mb-0 text-danger">
                        -{{ number_format($bugunOdemeler, 2) }}₺
                    </h5>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Net:</small>
                    <strong class="{{ ($bugunTahsilatlar - $bugunOdemeler) >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($bugunTahsilatlar - $bugunOdemeler, 2) }}₺
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hızlı İşlemler --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightning-charge me-2"></i>
                    Hızlı Cari İşlemler
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3">
                        <a href="{{ route('tahsilatlar.create') }}" class="btn btn-success w-100">
                            <i class="bi bi-cash-coin me-2"></i>Yeni Tahsilat
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('sirket-odemeleri.create') }}" class="btn btn-warning w-100">
                            <i class="bi bi-bank me-2"></i>Şirket Ödemesi
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('cari-hesaplar.yasilandirma') }}" class="btn btn-danger w-100">
                            <i class="bi bi-calendar-x me-2"></i>Yaşlandırma
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('cari-hesaplar.index') }}" class="btn btn-primary w-100">
                            <i class="bi bi-journal-text me-2"></i>Cari Hesaplar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Vade Geçmiş Uyarıları --}}
@if($vadeGecmisMusteriler > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>Dikkat!</strong> {{ number_format($vadeGecmisMusteriler, 2) }}₺ tutarında vade geçmiş müşteri borcu bulunuyor.
                    <a href="{{ route('cari-hesaplar.yasilandirma', ['tip' => 'musteri']) }}" class="alert-link ms-2">
                        Detaylı Rapor →
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

    <!-- Hızlı Aksiyonlar -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="content-card card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning text-primary"></i>
                        <span>Hızlı İşlemler</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('customers.create') }}" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-person-plus-fill mb-2" style="font-size: 2rem;"></i>
                                <strong>Yeni Müşteri</strong>
                                <small class="text-muted">Müşteri ekle</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('policies.create') }}" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-file-earmark-plus-fill mb-2" style="font-size: 2rem;"></i>
                                <strong>Yeni Poliçe</strong>
                                <small class="text-muted">Poliçe oluştur</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('quotations.create') }}" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-calculator-fill mb-2" style="font-size: 2rem;"></i>
                                <strong>Yeni Teklif</strong>
                                <small class="text-muted">Teklif hazırla</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('reports.index') }}" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-graph-up-arrow mb-2" style="font-size: 2rem;"></i>
                                <strong>Raporlar</strong>
                                <small class="text-muted">Rapor görüntüle</small>
                            </a>
                        </div>
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
    // İstatistik kartlarını animasyonlu göster
    $('.stat-card').each(function(index) {
        $(this).css('opacity', '0');
        setTimeout(() => {
            $(this).animate({opacity: 1}, 400);
        }, index * 100);
    });
});
</script>
@endpush
