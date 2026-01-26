@extends('layouts.app')

@section('title', 'Finansal Özet Raporu')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
    }

    .stat-card.green {
        border-left-color: #28a745;
        background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    }

    .stat-card.green::before { background: #28a745; }

    .stat-card.blue {
        border-left-color: #0d6efd;
        background: linear-gradient(135deg, #e7f1ff 0%, #ffffff 100%);
    }

    .stat-card.blue::before { background: #0d6efd; }

    .stat-card.orange {
        border-left-color: #fd7e14;
        background: linear-gradient(135deg, #fff4e6 0%, #ffffff 100%);
    }

    .stat-card.orange::before { background: #fd7e14; }

    .stat-card.purple {
        border-left-color: #6f42c1;
        background: linear-gradient(135deg, #f3eeff 0%, #ffffff 100%);
    }

    .stat-card.purple::before { background: #6f42c1; }

    .stat-card.red {
        border-left-color: #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    }

    .stat-card.red::before { background: #dc3545; }

    .stat-card.cyan {
        border-left-color: #0dcaf0;
        background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
    }

    .stat-card.cyan::before { background: #0dcaf0; }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.8;
    }

    .stat-card.green .stat-icon { color: #28a745; }
    .stat-card.blue .stat-icon { color: #0d6efd; }
    .stat-card.orange .stat-icon { color: #fd7e14; }
    .stat-card.purple .stat-icon { color: #6f42c1; }
    .stat-card.red .stat-icon { color: #dc3545; }
    .stat-card.cyan .stat-icon { color: #0dcaf0; }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .stat-meta {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        color: #6c757d;
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

    .chart-card .card-body {
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
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

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .comparison-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.25rem;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .comparison-card:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
    }

    .comparison-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .comparison-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .comparison-change {
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .comparison-change.positive {
        color: #28a745;
    }

    .comparison-change.negative {
        color: #dc3545;
    }

    .cash-status-item {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 0.75rem;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .cash-status-item:hover {
        border-color: #0dcaf0;
        box-shadow: 0 2px 8px rgba(13, 202, 240, 0.1);
    }

    .cash-type-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .cash-type-badge.kasa {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .cash-type-badge.banka {
        background: #d4edda;
        color: #155724;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .chart-container {
            height: 250px;
        }
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
                    <i class="bi bi-currency-exchange me-2"></i>Finansal Özet Raporu
                </h1>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar-range me-1"></i>
                    {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}
                </p>
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.financial') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Finansal Özet Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card green">
                <div class="stat-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['commission_income'], 2) }} ₺</div>
                <div class="stat-label">Komisyon Geliri</div>
                <div class="stat-meta">Dönem içi kazanılan</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card blue">
                <div class="stat-icon">
                    <i class="bi bi-credit-card-2-front"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['collections'], 2) }} ₺</div>
                <div class="stat-label">Toplam Tahsilat</div>
                <div class="stat-meta">Müşterilerden tahsil edilen</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card orange">
                <div class="stat-icon">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['payments'], 2) }} ₺</div>
                <div class="stat-label">Toplam Ödeme</div>
                <div class="stat-meta">Şirketlere ödenen</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card {{ $financialSummary['net_income'] >= 0 ? 'green' : 'red' }}">
                <div class="stat-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['net_income'], 2) }} ₺</div>
                <div class="stat-label">Net Gelir</div>
                <div class="stat-meta">Gelir - Gider</div>
            </div>
        </div>
    </div>

    <!-- Nakit Durum & Alacak/Borç -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="stat-card purple">
                <div class="stat-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['total_cash'], 2) }} ₺</div>
                <div class="stat-label">Toplam Nakit</div>
                <div class="stat-meta">Kasa + Banka Bakiyesi</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="stat-card cyan">
                <div class="stat-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['customer_receivables'], 2) }} ₺</div>
                <div class="stat-label">Müşteri Alacakları</div>
                <div class="stat-meta">Tahsil edilecek</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="stat-card red">
                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-value">{{ number_format($financialSummary['company_payables'], 2) }} ₺</div>
                <div class="stat-label">Şirket Borçları</div>
                <div class="stat-meta">Ödenecek</div>
            </div>
        </div>
    </div>

    <!-- Aylık Karşılaştırma -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-bar-chart-line"></i>
                <span>Aylık Karşılaştırma (Bu Ay vs Geçen Ay)</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="comparison-card">
                        <div class="comparison-label">Komisyon Geliri</div>
                        <div class="comparison-value text-primary">
                            {{ number_format($monthlyComparison['this_month']['commission'], 2) }} ₺
                        </div>
                        <div class="comparison-change {{ $monthlyComparison['commission_change'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="bi bi-{{ $monthlyComparison['commission_change'] >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($monthlyComparison['commission_change']), 1) }}%
                            <small class="text-muted ms-1">önceki aya göre</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="comparison-card">
                        <div class="comparison-label">Tahsilat</div>
                        <div class="comparison-value text-success">
                            {{ number_format($monthlyComparison['this_month']['collections'], 2) }} ₺
                        </div>
                        <div class="comparison-change {{ $monthlyComparison['collections_change'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="bi bi-{{ $monthlyComparison['collections_change'] >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($monthlyComparison['collections_change']), 1) }}%
                            <small class="text-muted ms-1">önceki aya göre</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="comparison-card">
                        <div class="comparison-label">Poliçe Sayısı</div>
                        <div class="comparison-value text-info">
                            {{ number_format($monthlyComparison['this_month']['policies']) }}
                        </div>
                        <div class="comparison-change {{ $monthlyComparison['policies_change'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="bi bi-{{ $monthlyComparison['policies_change'] >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ number_format(abs($monthlyComparison['policies_change']), 1) }}%
                            <small class="text-muted ms-1">önceki aya göre</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nakit Akış Trendi -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-graph-up"></i>
                <span>Nakit Akış Trendi (Son 6 Ay)</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Kasa/Banka Durum & Günlük Akış -->
    <div class="row g-4 mb-4">
        <!-- Kasa/Banka Durum -->
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-safe"></i>
                        <span>Kasa/Banka Durum Raporu</span>
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($cashBankStatus as $item)
                    <div class="cash-status-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="cash-type-badge {{ $item['hesap']->tip }}">
                                    {{ $item['hesap']->tip_label }}
                                </span>
                                <h6 class="mt-2 mb-1">{{ $item['hesap']->ad }}</h6>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary" style="font-size: 1.25rem;">
                                    {{ number_format($item['hesap']->bakiye, 2) }} ₺
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-4">
                                <small class="text-muted d-block">Giriş (7g)</small>
                                <strong class="text-success">+{{ number_format($item['girisler_7gun'], 2) }} ₺</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Çıkış (7g)</small>
                                <strong class="text-danger">-{{ number_format($item['cikislar_7gun'], 2) }} ₺</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Net (7g)</small>
                                <strong class="text-{{ $item['net_7gun'] >= 0 ? 'success' : 'danger' }}">
                                    {{ $item['net_7gun'] >= 0 ? '+' : '' }}{{ number_format($item['net_7gun'], 2) }} ₺
                                </strong>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Günlük Nakit Akışı -->
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-calendar-week"></i>
                        <span>Günlük Nakit Akışı (Son 7 Gün)</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="dailyCashChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Şirket Borç/Alacak -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-building"></i>
                <span>Şirket Borç/Alacak Durumu (Top 10)</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Şirket</th>
                            <th class="text-end">Borç</th>
                            <th class="text-end">Alacak</th>
                            <th class="text-end">Bakiye</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companyDebts as $item)
                        <tr>
                            <td>
                                <strong>{{ $item['cari']->insuranceCompany->name ?? $item['cari']->ad }}</strong>
                                <br>
                                <small class="text-muted">{{ $item['cari']->kod }}</small>
                            </td>
                            <td class="text-end">
                                <span class="text-danger">{{ number_format($item['borc'], 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="text-success">{{ number_format($item['alacak'], 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <strong class="text-{{ $item['bakiye'] < 0 ? 'danger' : ($item['bakiye'] > 0 ? 'success' : 'secondary') }}">
                                    {{ number_format($item['bakiye'], 2) }} ₺
                                </strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $item['bakiye'] < 0 ? 'danger' : ($item['bakiye'] > 0 ? 'success' : 'secondary') }}">
                                    {{ $item['durum'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Kayıt bulunamadı
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Müşteri Alacakları -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-people"></i>
                <span>En Yüksek Borçlu Müşteriler (Top 10)</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Müşteri</th>
                            <th class="text-end">Toplam Borç</th>
                            <th class="text-end">Vade Geçmiş</th>
                            <th class="text-end">Vade İçerisinde</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerCredits as $item)
                        <tr>
                            <td>
                                <strong>{{ $item['cari']->customer->name ?? $item['cari']->ad }}</strong>
                                <br>
                                <small class="text-muted">{{ $item['cari']->kod }}</small>
                            </td>
                            <td class="text-end">
                                <strong class="text-danger">{{ number_format($item['toplam_borc'], 2) }} ₺</strong>
                            </td>
                            <td class="text-end">
                                <span class="text-danger fw-semibold">{{ number_format($item['vade_gecmis'], 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="text-success">{{ number_format($item['vade_icerisinde'], 2) }} ₺</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Kayıt bulunamadı
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Karlılık Analizi -->
    <div class="chart-card card">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-piggy-bank"></i>
                <span>Branş Bazlı Karlılık Analizi</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Branş</th>
                            <th class="text-end">Poliçe</th>
                            <th class="text-end">Toplam Prim</th>
                            <th class="text-end">Komisyon</th>
                            <th class="text-end">Ort. Oran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $labels = [
                                'kasko' => 'Kasko',
                                'trafik' => 'Trafik',
                                'konut' => 'Konut',
                                'dask' => 'DASK',
                                'saglik' => 'Sağlık',
                                'hayat' => 'Hayat',
                                'tss' => 'TSS'
                            ];
                        @endphp
                        @forelse($profitability['branch_profitability'] as $branch)
                        <tr>
                            <td><strong>{{ $labels[$branch->policy_type] ?? $branch->policy_type }}</strong></td>
                            <td class="text-end">{{ number_format($branch->count) }}</td>
                            <td class="text-end">{{ number_format($branch->total_premium, 2) }} ₺</td>
                            <td class="text-end text-success fw-semibold">{{ number_format($branch->total_commission, 2) }} ₺</td>
                            <td class="text-end">
                                <span class="badge bg-primary">%{{ number_format($branch->avg_rate, 1) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Kayıt bulunamadı
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot style="background: #fafafa; border-top: 2px solid #e8e8e8;">
                        <tr>
                            <th>TOPLAM</th>
                            <th class="text-end">{{ number_format($profitability['branch_profitability']->sum('count')) }}</th>
                            <th class="text-end">{{ number_format($profitability['total_premium'], 2) }} ₺</th>
                            <th class="text-end text-success">{{ number_format($profitability['total_commission'], 2) }} ₺</th>
                            <th class="text-end">
                                <span class="badge bg-primary">%{{ number_format($profitability['avg_commission_rate'], 1) }}</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// Nakit Akış Trendi
const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
new Chart(cashFlowCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($cashFlowTrend->pluck('month')) !!},
        datasets: [
            {
                label: 'Gelir',
                data: {!! json_encode($cashFlowTrend->pluck('income')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'rgb(40, 167, 69)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            },
            {
                label: 'Gider',
                data: {!! json_encode($cashFlowTrend->pluck('expense')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderColor: 'rgb(220, 53, 69)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'rgb(220, 53, 69)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            },
            {
                label: 'Net',
                data: {!! json_encode($cashFlowTrend->pluck('net')) !!},
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderColor: 'rgb(13, 110, 253)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'rgb(13, 110, 253)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: { 
                display: true,
                position: 'top',
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + ' ₺';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('tr-TR') + ' ₺';
                    }
                }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});

// Günlük Nakit Akışı
const dailyCashCtx = document.getElementById('dailyCashChart').getContext('2d');
new Chart(dailyCashCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailyCashFlow->pluck('date')) !!},
        datasets: [
            {
                label: 'Gelir',
                data: {!! json_encode($dailyCashFlow->pluck('income')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.85)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 2,
                borderRadius: 6,
            },
            {
                label: 'Gider',
                data: {!! json_encode($dailyCashFlow->pluck('expense')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.85)',
                borderColor: 'rgb(220, 53, 69)',
                borderWidth: 2,
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'top' },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
</script>
@endpush