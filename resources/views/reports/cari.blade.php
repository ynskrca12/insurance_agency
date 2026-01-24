@extends('layouts.app')

@section('title', 'Cari İşlemler Raporları')

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
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
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

    .stat-card.primary {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
        color: #ffffff;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        opacity: 0.9;
    }

    .stat-card:not(.primary) .stat-label {
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

    .table-modern tfoot {
        background: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }

    .table-modern tfoot th {
        padding: 1rem 1.25rem;
        font-weight: 700;
        color: #212529;
    }

    .aging-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        height: 100%;
    }

    .aging-card.danger {
        border-left: 4px solid #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    }

    .aging-card.warning {
        border-left: 4px solid #ffc107;
        background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
    }

    .aging-card.info {
        border-left: 4px solid #0dcaf0;
        background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
    }

    .aging-card.success {
        border-left: 4px solid #28a745;
        background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    }

    .aging-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .aging-value {
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .aging-count {
        font-size: 0.813rem;
        color: #6c757d;
    }

    .balance-positive {
        color: #28a745;
        font-weight: 700;
    }

    .balance-negative {
        color: #dc3545;
        font-weight: 700;
    }

    .overdue-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
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

        .aging-value {
            font-size: 1.25rem;
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
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>Cari İşlemler Raporları
                </h1>
                <div class="period-info">
                    <i class="bi bi-calendar-range"></i>
                    <span>{{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</span>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-light action-btn">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.cari') }}">
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
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- GENEL DURUM KARTLARI -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['toplam_alacak'], 2) }} ₺</div>
                <div class="stat-label">Toplam Alacak</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($stats['toplam_borc'], 2) }} ₺</div>
                <div class="stat-label">Toplam Borç</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-value">
                    {{ number_format(abs($stats['net_durum']), 2) }} ₺
                    @if($stats['net_durum'] >= 0)
                        <i class="bi bi-arrow-up-circle text-white"></i>
                    @else
                        <i class="bi bi-arrow-down-circle text-white"></i>
                    @endif
                </div>
                <div class="stat-label">Net Durum</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['kasa_banka_bakiye'], 2) }} ₺</div>
                <div class="stat-label">Kasa/Banka</div>
            </div>
        </div>
    </div>

    <!-- CARİ TİPLERİNE GÖRE DAĞILIM -->
    <div class="table-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-diagram-3"></i>
                <span>Cari Tipine Göre Dağılım</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Cari Tipi</th>
                            <th class="text-end">Adet</th>
                            <th class="text-end">Toplam Alacak</th>
                            <th class="text-end">Toplam Borç</th>
                            <th class="text-end">Net Bakiye</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tipLabels = [
                                'musteri' => 'Müşteri Carisi',
                                'sirket' => 'Sigorta Şirket Carisi',
                                'kasa' => 'Kasa',
                                'banka' => 'Banka Hesabı'
                            ];
                        @endphp
                        @foreach($cariByType as $tip => $data)
                        <tr>
                            <td><strong>{{ $tipLabels[$tip] ?? $tip }}</strong></td>
                            <td class="text-end">{{ number_format($data['adet']) }}</td>
                            <td class="text-end">
                                <span class="balance-positive">{{ number_format($data['toplam_alacak'], 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="balance-negative">{{ number_format($data['toplam_borc'], 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="{{ $data['net'] >= 0 ? 'balance-positive' : 'balance-negative' }}">
                                    {{ number_format($data['net'], 2) }} ₺
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAHSİLAT ANALİZİ -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($tahsilatStats['toplam_tahsilat'], 2) }} ₺</div>
                <div class="stat-label">Toplam Tahsilat</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($tahsilatStats['tahsilat_sayisi']) }}</div>
                <div class="stat-label">Tahsilat Sayısı</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($tahsilatStats['ortalama_tahsilat'], 2) }} ₺</div>
                <div class="stat-label">Ortalama Tahsilat</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ $tahsilatByMonth->count() }}</div>
                <div class="stat-label">Aktif Dönem</div>
            </div>
        </div>
    </div>

    <!-- GRAFİKLER -->
    <div class="row g-4 mb-4">
        <!-- Aylık Tahsilat Trendi -->
        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Aylık Tahsilat Trendi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="tahsilatTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ödeme Yöntemi Dağılımı -->
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Ödeme Yöntemi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- YAŞLANDIRMA RAPORU - EN ÖNEMLİ BÖLÜM -->
    <div class="chart-card card mb-4">
        <div class="card-header bg-warning bg-opacity-10">
            <h5 class="chart-title">
                <i class="bi bi-hourglass-split text-warning"></i>
                <span>Yaşlandırma Raporu (Alacak Vadelerine Göre)</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- 0-30 Gün -->
                <div class="col-lg-3 col-md-6">
                    <div class="aging-card success">
                        <div class="aging-title">0-30 Gün</div>
                        <div class="aging-value text-success">
                            {{ number_format($yaslandirma['0_30']['tutar'], 2) }} ₺
                        </div>
                        <div class="aging-count">{{ $yaslandirma['0_30']['adet'] }} işlem</div>
                    </div>
                </div>

                <!-- 31-60 Gün -->
                <div class="col-lg-3 col-md-6">
                    <div class="aging-card info">
                        <div class="aging-title">31-60 Gün</div>
                        <div class="aging-value text-info">
                            {{ number_format($yaslandirma['31_60']['tutar'], 2) }} ₺
                        </div>
                        <div class="aging-count">{{ $yaslandirma['31_60']['adet'] }} işlem</div>
                    </div>
                </div>

                <!-- 61-90 Gün -->
                <div class="col-lg-3 col-md-6">
                    <div class="aging-card warning">
                        <div class="aging-title">61-90 Gün</div>
                        <div class="aging-value text-warning">
                            {{ number_format($yaslandirma['61_90']['tutar'], 2) }} ₺
                        </div>
                        <div class="aging-count">{{ $yaslandirma['61_90']['adet'] }} işlem</div>
                    </div>
                </div>

                <!-- 90+ Gün (RİSKLİ) -->
                <div class="col-lg-3 col-md-6">
                    <div class="aging-card danger">
                        <div class="aging-title">90+ Gün (RİSKLİ)</div>
                        <div class="aging-value text-danger">
                            {{ number_format($yaslandirma['90_plus']['tutar'], 2) }} ₺
                        </div>
                        <div class="aging-count">{{ $yaslandirma['90_plus']['adet'] }} işlem</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAY TABLOLAR -->
    <div class="row g-4">
        <!-- En Yüksek Borçlu Müşteriler -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-person-exclamation"></i>
                        <span>En Yüksek Alacaklı Müşteriler</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Müşteri</th>
                                    <th>Cari Kod</th>
                                    <th class="text-end">Alacak Bakiye</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topDebtors as $debtor)
                                <tr>
                                    <td>
                                        <strong>{{ $debtor->ad }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $debtor->kod }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="balance-positive">{{ number_format($debtor->bakiye, 2) }} ₺</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Alacaklı müşteri bulunmuyor
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vade Aşımı Olan Müşteriler -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header bg-danger bg-opacity-10">
                    <h5 class="chart-title">
                        <i class="bi bi-exclamation-triangle text-danger"></i>
                        <span>Vade Aşımı Olan Müşteriler</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Müşteri</th>
                                    <th class="text-end">Vade Aşımı</th>
                                    <th class="text-end">En Eski Vade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overdueCustomers as $overdue)
                                <tr>
                                    <td>
                                        <strong>{{ $overdue->cariHesap->ad }}</strong>
                                    </td>
                                    <td class="text-end">
                                        <span class="balance-negative">{{ number_format($overdue->toplam_vade_asimi, 2) }} ₺</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="overdue-badge bg-danger">
                                            {{ \Carbon\Carbon::parse($overdue->en_eski_vade)->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Vade aşımı bulunmuyor
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kasa/Banka Hareketleri -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-wallet2"></i>
                        <span>Kasa/Banka Hareketleri Özeti</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Hesap Adı</th>
                                    <th>Tip</th>
                                    <th class="text-end">Giriş (Tahsilat)</th>
                                    <th class="text-end">Çıkış (Ödeme)</th>
                                    <th class="text-end">Net Hareket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kasaBankaHareketler as $hareket)
                                <tr>
                                    <td><strong>{{ $hareket->cariHesap->ad }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $hareket->cariHesap->tip === 'kasa' ? 'success' : 'info' }}">
                                            {{ ucfirst($hareket->cariHesap->tip) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="balance-positive">{{ number_format($hareket->toplam_giris, 2) }} ₺</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="balance-negative">{{ number_format($hareket->toplam_cikis, 2) }} ₺</span>
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $net = $hareket->toplam_giris - $hareket->toplam_cikis;
                                        @endphp
                                        <span class="{{ $net >= 0 ? 'balance-positive' : 'balance-negative' }}">
                                            {{ number_format($net, 2) }} ₺
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Seçili dönemde kasa/banka hareketi bulunmuyor
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($kasaBankaHareketler->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <th colspan="2">Toplam</th>
                                    <th class="text-end">{{ number_format($kasaBankaHareketler->sum('toplam_giris'), 2) }} ₺</th>
                                    <th class="text-end">{{ number_format($kasaBankaHareketler->sum('toplam_cikis'), 2) }} ₺</th>
                                    <th class="text-end">
                                        @php
                                            $netToplam = $kasaBankaHareketler->sum('toplam_giris') - $kasaBankaHareketler->sum('toplam_cikis');
                                        @endphp
                                        <span class="{{ $netToplam >= 0 ? 'balance-positive' : 'balance-negative' }}">
                                            {{ number_format($netToplam, 2) }} ₺
                                        </span>
                                    </th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Chart.js Global Ayarları
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// Aylık Tahsilat Trendi
const trendCtx = document.getElementById('tahsilatTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($tahsilatByMonth->pluck('month_label')) !!},
        datasets: [{
            label: 'Tahsilat (₺)',
            data: {!! json_encode($tahsilatByMonth->pluck('total')) !!},
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderColor: 'rgb(40, 167, 69)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(40, 167, 69)',
            pointBorderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Tahsilat: ' + context.parsed.y.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + ' ₺';
                    }
                }
            }
        },
        scales: {
            x: { grid: { display: false } },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('tr-TR') + ' ₺';
                    }
                }
            }
        }
    }
});

// Ödeme Yöntemi Dağılımı
const methodCtx = document.getElementById('paymentMethodChart').getContext('2d');
new Chart(methodCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($tahsilatByMethod->pluck('odeme_yontemi')->map(function($method) {
            $labels = [
                'nakit' => 'Nakit',
                'kredi_kart' => 'Kredi Kartı',
                'banka_havale' => 'Havale/EFT',
                'cek' => 'Çek',
                'sanal_pos' => 'Sanal POS',
                'diger' => 'Diğer'
            ];
            return $labels[$method] ?? $method;
        })) !!},
        datasets: [{
            data: {!! json_encode($tahsilatByMethod->pluck('total')) !!},
            backgroundColor: [
                'rgba(40, 167, 69, 0.85)',
                'rgba(13, 110, 253, 0.85)',
                'rgba(13, 202, 240, 0.85)',
                'rgba(255, 193, 7, 0.85)',
                'rgba(111, 66, 193, 0.85)',
                'rgba(108, 117, 125, 0.85)'
            ],
            borderColor: '#ffffff',
            borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: { size: 12 },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                    label: function(context) {
                        const value = context.parsed;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return context.label + ': ' + value.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + ' ₺ (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%'
    }
});
</script>
@endpush
