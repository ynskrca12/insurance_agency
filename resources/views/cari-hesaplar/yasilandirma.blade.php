@extends('layouts.app')

@section('title', 'Yaşlandırma Raporu')

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="bi bi-calendar-x me-2"></i>
                        Yaşlandırma Raporu
                    </h2>
                    <small class="text-muted">Vade Geçmiş Borçların Detaylı Analizi</small>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-success" onclick="exportExcel()">
                        <i class="bi bi-file-excel me-2"></i>Excel İndir
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Yazdır
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtre --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('cari-hesaplar.yasilandirma') }}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Cari Tipi</label>
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('cari-hesaplar.yasilandirma', ['tip' => 'musteri']) }}"
                               class="btn btn-outline-primary {{ $tip === 'musteri' ? 'active' : '' }}">
                                <i class="bi bi-person-circle me-2"></i>Müşteriler
                            </a>
                            <a href="{{ route('cari-hesaplar.yasilandirma', ['tip' => 'sirket']) }}"
                               class="btn btn-outline-primary {{ $tip === 'sirket' ? 'active' : '' }}">
                                <i class="bi bi-building me-2"></i>Şirketler
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Özet Kartlar --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted mb-2">0-30 Gün</h6>
                    <h3 class="mb-0 text-success">
                        {{ number_format($cariHesaplar->sum('vade_0_30'), 2) }}₺
                    </h3>
                    <small class="text-muted">Güncel vadeli</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted mb-2">31-60 Gün</h6>
                    <h3 class="mb-0 text-warning">
                        {{ number_format($cariHesaplar->sum('vade_31_60'), 2) }}₺
                    </h3>
                    <small class="text-muted">Az gecikmiş</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted mb-2">61-90 Gün</h6>
                    <h3 class="mb-0 text-danger">
                        {{ number_format($cariHesaplar->sum('vade_61_90'), 2) }}₺
                    </h3>
                    <small class="text-muted">Gecikmeli</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h6 class="text-muted mb-2">90+ Gün</h6>
                    <h3 class="mb-0 text-dark">
                        {{ number_format($cariHesaplar->sum('vade_90_plus'), 2) }}₺
                    </h3>
                    <small class="text-muted">Çok gecikmeli</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Yaşlandırma Tablosu --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Detaylı Yaşlandırma Analizi
            </h5>
        </div>
        <div class="card-body p-0">
            @if($cariHesaplar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0" id="yasilandirmaTable">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="align-middle">
                                    @if($tip === 'musteri')
                                        Müşteri
                                    @else
                                        Sigorta Şirketi
                                    @endif
                                </th>
                                <th rowspan="2" class="align-middle">Cari Kod</th>
                                <th rowspan="2" class="align-middle">Telefon</th>
                                <th colspan="4" class="text-center bg-light">Vade Grupları</th>
                                <th rowspan="2" class="text-end align-middle">Toplam Borç</th>
                                <th rowspan="2" class="text-center align-middle">Risk</th>
                            </tr>
                            <tr>
                                <th class="text-end bg-success-subtle">0-30 Gün</th>
                                <th class="text-end bg-warning-subtle">31-60 Gün</th>
                                <th class="text-end bg-danger-subtle">61-90 Gün</th>
                                <th class="text-end bg-dark-subtle">90+ Gün</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cariHesaplar as $item)
                                @php
                                    $cari = $item['cari'];
                                    $riskSeviyesi = 'low';
                                    if ($item['vade_90_plus'] > 0) {
                                        $riskSeviyesi = 'critical';
                                    } elseif ($item['vade_61_90'] > 0) {
                                        $riskSeviyesi = 'high';
                                    } elseif ($item['vade_31_60'] > 0) {
                                        $riskSeviyesi = 'medium';
                                    }
                                @endphp
                                <tr class="{{ $riskSeviyesi === 'critical' ? 'table-danger' : '' }}">
                                    <td>
                                        <a href="{{ route('cari-hesaplar.show', $cari) }}"
                                           class="text-decoration-none fw-bold">
                                            @if($cari->customer)
                                                {{ $cari->customer->name }}
                                            @elseif($cari->insuranceCompany)
                                                {{ $cari->insuranceCompany->name }}
                                            @else
                                                {{ $cari->ad }}
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $cari->kod }}</span>
                                    </td>
                                    <td>
                                        @if($cari->customer)
                                            {{ $cari->customer->phone }}
                                        @elseif($cari->insuranceCompany)
                                            {{ $cari->insuranceCompany->phone ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end {{ $item['vade_0_30'] > 0 ? 'fw-bold text-success' : 'text-muted' }}">
                                        {{ $item['vade_0_30'] > 0 ? number_format($item['vade_0_30'], 2) . '₺' : '-' }}
                                    </td>
                                    <td class="text-end {{ $item['vade_31_60'] > 0 ? 'fw-bold text-warning' : 'text-muted' }}">
                                        {{ $item['vade_31_60'] > 0 ? number_format($item['vade_31_60'], 2) . '₺' : '-' }}
                                    </td>
                                    <td class="text-end {{ $item['vade_61_90'] > 0 ? 'fw-bold text-danger' : 'text-muted' }}">
                                        {{ $item['vade_61_90'] > 0 ? number_format($item['vade_61_90'], 2) . '₺' : '-' }}
                                    </td>
                                    <td class="text-end {{ $item['vade_90_plus'] > 0 ? 'fw-bold text-dark' : 'text-muted' }}">
                                        {{ $item['vade_90_plus'] > 0 ? number_format($item['vade_90_plus'], 2) . '₺' : '-' }}
                                    </td>
                                    <td class="text-end">
                                        <strong class="fs-6">{{ number_format($item['toplam'], 2) }}₺</strong>
                                    </td>
                                    <td class="text-center">
                                        @if($riskSeviyesi === 'critical')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                Kritik
                                            </span>
                                        @elseif($riskSeviyesi === 'high')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                Yüksek
                                            </span>
                                        @elseif($riskSeviyesi === 'medium')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-dash-circle me-1"></i>
                                                Orta
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Düşük
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <td colspan="3" class="text-end"><strong>TOPLAM:</strong></td>
                                <td class="text-end">
                                    <strong class="text-success">
                                        {{ number_format($cariHesaplar->sum('vade_0_30'), 2) }}₺
                                    </strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-warning">
                                        {{ number_format($cariHesaplar->sum('vade_31_60'), 2) }}₺
                                    </strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-danger">
                                        {{ number_format($cariHesaplar->sum('vade_61_90'), 2) }}₺
                                    </strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-dark">
                                        {{ number_format($cariHesaplar->sum('vade_90_plus'), 2) }}₺
                                    </strong>
                                </td>
                                <td class="text-end">
                                    <strong class="fs-5">
                                        {{ number_format($cariHesaplar->sum('toplam'), 2) }}₺
                                    </strong>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- İstatistikler --}}
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Toplam Kayıt</small>
                            <strong class="fs-5">{{ $cariHesaplar->count() }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Kritik Risk</small>
                            <strong class="fs-5 text-danger">
                                {{ $cariHesaplar->filter(function($item) { return $item['vade_90_plus'] > 0; })->count() }}
                            </strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Ortalama Borç</small>
                            <strong class="fs-5">
                                {{ $cariHesaplar->count() > 0 ? number_format($cariHesaplar->sum('toplam') / $cariHesaplar->count(), 2) : 0 }}₺
                            </strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Vade Geçmiş Oran</small>
                            <strong class="fs-5 text-danger">
                                @php
                                    $vadeGecmis = $cariHesaplar->sum('vade_31_60') + $cariHesaplar->sum('vade_61_90') + $cariHesaplar->sum('vade_90_plus');
                                    $toplam = $cariHesaplar->sum('toplam');
                                    $oran = $toplam > 0 ? ($vadeGecmis / $toplam * 100) : 0;
                                @endphp
                                %{{ number_format($oran, 1) }}
                            </strong>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-check-circle display-1 text-success"></i>
                    <p class="text-muted mt-3">Harika! Vade geçmiş borç bulunmuyor.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Risk Açıklaması --}}
    <div class="card mt-4">
        <div class="card-body">
            <h6 class="mb-3">
                <i class="bi bi-info-circle me-2"></i>
                Risk Seviyeleri Açıklaması
            </h6>
            <div class="row">
                <div class="col-md-3">
                    <span class="badge bg-success mb-2">Düşük Risk</span>
                    <p class="small mb-0">Sadece 0-30 gün vadeli borçlar</p>
                </div>
                <div class="col-md-3">
                    <span class="badge bg-warning mb-2">Orta Risk</span>
                    <p class="small mb-0">31-60 gün gecikmiş borçlar var</p>
                </div>
                <div class="col-md-3">
                    <span class="badge bg-danger mb-2">Yüksek Risk</span>
                    <p class="small mb-0">61-90 gün gecikmiş borçlar var</p>
                </div>
                <div class="col-md-3">
                    <span class="badge bg-danger mb-2">Kritik Risk</span>
                    <p class="small mb-0">90+ gün gecikmiş borçlar var - Acil takip gerekli</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function exportExcel() {
        // Excel export fonksiyonu - ileride implement edilebilir
        alert('Excel export özelliği yakında eklenecek!');
    }
</script>
@endpush

@push('styles')
<style>
    @media print {
        .btn, .card-header, nav, footer {
            display: none !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
    }

    .bg-success-subtle {
        background-color: #d1e7dd !important;
    }

    .bg-warning-subtle {
        background-color: #fff3cd !important;
    }

    .bg-danger-subtle {
        background-color: #f8d7da !important;
    }

    .bg-dark-subtle {
        background-color: #e2e3e5 !important;
    }
</style>
@endpush
@endsection
