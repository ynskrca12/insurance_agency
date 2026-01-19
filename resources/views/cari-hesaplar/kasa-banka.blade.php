@extends('layouts.app')

@section('title', 'Kasa/Banka Raporu')

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="bi bi-safe me-2"></i>
                        Kasa/Banka Raporu
                    </h2>
                    <small class="text-muted">Nakit Akışı ve Bakiye Analizi</small>
                </div>
                <div class="btn-group">
                    <a href="{{ route('cari-hesaplar.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Hesap Ekle
                    </a>
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

    {{-- Kasa/Banka Yoksa Uyarı Mesajı --}}
    @if($kasaBankaHesaplari->isEmpty())
        <div class="card border-warning">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                </div>
                <h4 class="mb-3">Henüz Kasa veya Banka Hesabı Oluşturmadınız</h4>
                <p class="text-muted mb-4">
                    Finansal işlemlerinizi takip edebilmek için öncelikle en az bir kasa veya banka hesabı oluşturmanız gerekmektedir.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('cari-hesaplar.create', ['tip' => 'kasa']) }}" class="btn btn-warning btn-lg">
                        <i class="bi bi-safe me-2"></i>Kasa Hesabı Oluştur
                    </a>
                    <a href="{{ route('cari-hesaplar.create', ['tip' => 'banka']) }}" class="btn btn-info btn-lg">
                        <i class="bi bi-bank me-2"></i>Banka Hesabı Oluştur
                    </a>
                </div>
                <div class="mt-4">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        İpucu: Hem kasa hem de banka hesaplarınızı ekleyerek tüm nakit akışınızı detaylı takip edebilirsiniz.
                    </small>
                </div>
            </div>
        </div>
    @else
        {{-- Eksik Hesap Türü Uyarısı --}}
        @php
            $kasaVar = $kasaBankaHesaplari->contains(function($item) {
                return $item['hesap']->tip === 'kasa';
            });
            $bankaVar = $kasaBankaHesaplari->contains(function($item) {
                return $item['hesap']->tip === 'banka';
            });
        @endphp

        @if(!$kasaVar || !$bankaVar)
            <div class="alert alert-info alert-dismissible fade show d-print-none" role="alert">
                <i class="bi bi-lightbulb me-2"></i>
                <strong>İpucu:</strong>
                @if(!$kasaVar && !$bankaVar)
                    Hem kasa hem de banka hesabı ekleyerek tüm finansal hareketlerinizi daha iyi takip edebilirsiniz.
                    <a href="{{ route('cari-hesaplar.create', ['tip' => 'kasa']) }}" class="alert-link ms-2">Kasa Ekle</a> |
                    <a href="{{ route('cari-hesaplar.create', ['tip' => 'banka']) }}" class="alert-link">Banka Ekle</a>
                @elseif(!$kasaVar)
                    Nakit işlemlerinizi takip etmek için bir kasa hesabı eklemeyi düşünün.
                    <a href="{{ route('cari-hesaplar.create', ['tip' => 'kasa']) }}" class="alert-link ms-2">Kasa Hesabı Ekle</a>
                @else
                    Banka işlemlerinizi takip etmek için bir banka hesabı eklemeyi düşünün.
                    <a href="{{ route('cari-hesaplar.create', ['tip' => 'banka']) }}" class="alert-link ms-2">Banka Hesabı Ekle</a>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tarih Filtresi --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('cari-hesaplar.kasa-banka') }}">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Başlangıç Tarihi</label>
                            <input type="date"
                                   name="baslangic"
                                   class="form-control"
                                   value="{{ $baslangic }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bitiş Tarihi</label>
                            <input type="date"
                                   name="bitis"
                                   class="form-control"
                                   value="{{ $bitis }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-2"></i>Filtrele
                            </button>
                            <a href="{{ route('cari-hesaplar.kasa-banka') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Temizle
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Genel Özet --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-arrow-down-circle me-2"></i>
                            Toplam Giriş
                        </h6>
                        <h3 class="mb-0 text-success">
                            {{ number_format($kasaBankaHesaplari->sum('girisler'), 2) }}₺
                        </h3>
                        <small class="text-muted">Dönem içi tahsilatlar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-arrow-up-circle me-2"></i>
                            Toplam Çıkış
                        </h6>
                        <h3 class="mb-0 text-danger">
                            {{ number_format($kasaBankaHesaplari->sum('cikislar'), 2) }}₺
                        </h3>
                        <small class="text-muted">Dönem içi ödemeler</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-calculator me-2"></i>
                            Net Hareket
                        </h6>
                        <h3 class="mb-0 {{ $kasaBankaHesaplari->sum('net_hareket') >= 0 ? 'text-primary' : 'text-danger' }}">
                            {{ number_format($kasaBankaHesaplari->sum('net_hareket'), 2) }}₺
                        </h3>
                        <small class="text-muted">Giriş - Çıkış</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-wallet2 me-2"></i>
                            Güncel Toplam
                        </h6>
                        <h3 class="mb-0 text-info">
                            {{ number_format($kasaBankaHesaplari->sum(function($item) { return $item['hesap']->bakiye; }), 2) }}₺
                        </h3>
                        <small class="text-muted">Mevcut bakiye</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hızlı Hesap Ekleme Kartları --}}
        <div class="row mb-4">
            @if(!$kasaVar)
                <div class="col-md-6">
                    <div class="card border-warning bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-safe display-4 text-warning mb-3"></i>
                            <h5>Kasa Hesabı Ekle</h5>
                            <p class="text-muted mb-3">Nakit işlemlerinizi takip etmek için kasa hesabı oluşturun</p>
                            <a href="{{ route('cari-hesaplar.create', ['tip' => 'kasa']) }}" class="btn btn-warning">
                                <i class="bi bi-plus-circle me-2"></i>Kasa Hesabı Oluştur
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if(!$bankaVar)
                <div class="col-md-6">
                    <div class="card border-info bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i class="bi bi-bank display-4 text-info mb-3"></i>
                            <h5>Banka Hesabı Ekle</h5>
                            <p class="text-muted mb-3">Banka işlemlerinizi takip etmek için hesap oluşturun</p>
                            <a href="{{ route('cari-hesaplar.create', ['tip' => 'banka']) }}" class="btn btn-info">
                                <i class="bi bi-plus-circle me-2"></i>Banka Hesabı Oluştur
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Hesap Bazlı Detay --}}
        <div class="row">
            @foreach($kasaBankaHesaplari as $item)
                @php $hesap = $item['hesap']; @endphp
                <div class="col-md-6 mb-4">
                    <div class="card h-100 {{ $hesap->tip === 'kasa' ? 'border-warning' : 'border-info' }}">
                        <div class="card-header {{ $hesap->tip === 'kasa' ? 'bg-warning' : 'bg-info' }} text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-{{ $hesap->tip === 'kasa' ? 'safe' : 'bank' }} me-2"></i>
                                    {{ $hesap->ad }}
                                </h5>
                                <span class="badge {{ $hesap->tip === 'kasa' ? 'bg-light text-dark' : 'bg-white text-dark' }}">
                                    {{ $hesap->kod }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- Bakiye Bilgisi --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <small class="text-muted d-block">Güncel Bakiye</small>
                                            <h3 class="mb-0 {{ $hesap->bakiye >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format(abs($hesap->bakiye), 2) }}₺
                                            </h3>
                                        </div>
                                        <div class="text-end">
                                            <a href="{{ route('cari-hesaplar.show', $hesap) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>Detay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Dönem Hareketleri --}}
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center p-3 border rounded">
                                        <i class="bi bi-arrow-down-circle text-success fs-3"></i>
                                        <h6 class="text-muted mt-2 mb-1">Giriş</h6>
                                        <h4 class="text-success mb-0">
                                            {{ number_format($item['girisler'], 2) }}₺
                                        </h4>
                                        <small class="text-muted">Tahsilatlar</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-3 border rounded">
                                        <i class="bi bi-arrow-up-circle text-danger fs-3"></i>
                                        <h6 class="text-muted mt-2 mb-1">Çıkış</h6>
                                        <h4 class="text-danger mb-0">
                                            {{ number_format($item['cikislar'], 2) }}₺
                                        </h4>
                                        <small class="text-muted">Ödemeler</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Net Hareket --}}
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center p-2 {{ $item['net_hareket'] >= 0 ? 'bg-success-subtle' : 'bg-danger-subtle' }} rounded">
                                    <strong>Net Hareket:</strong>
                                    <strong class="{{ $item['net_hareket'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $item['net_hareket'] >= 0 ? '+' : '' }}{{ number_format($item['net_hareket'], 2) }}₺
                                    </strong>
                                </div>
                            </div>

                            {{-- İstatistikler --}}
                            <div class="mt-3 pt-3 border-top">
                                <div class="row text-center small">
                                    <div class="col-4">
                                        <div class="text-muted">Giriş/Çıkış</div>
                                        <strong>
                                            @if($item['cikislar'] > 0)
                                                {{ number_format(($item['girisler'] / $item['cikislar']), 2) }}x
                                            @else
                                                ∞
                                            @endif
                                        </strong>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted">Dönem</div>
                                        <strong>{{ \Carbon\Carbon::parse($baslangic)->diffInDays(\Carbon\Carbon::parse($bitis)) + 1 }} gün</strong>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted">Günlük Ort.</div>
                                        <strong>
                                            {{ number_format($item['net_hareket'] / max(1, \Carbon\Carbon::parse($baslangic)->diffInDays(\Carbon\Carbon::parse($bitis)) + 1), 2) }}₺
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Grafik Özeti --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart me-2"></i>
                    Hesaplar Karşılaştırması
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Hesap</th>
                                <th>Tip</th>
                                <th class="text-end">Giriş</th>
                                <th class="text-end">Çıkış</th>
                                <th class="text-end">Net</th>
                                <th class="text-end">Güncel Bakiye</th>
                                <th style="width: 200px;">Dağılım</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasaBankaHesaplari as $item)
                                @php
                                    $hesap = $item['hesap'];
                                    $toplamGiris = $kasaBankaHesaplari->sum('girisler');
                                    $girisPer = $toplamGiris > 0 ? ($item['girisler'] / $toplamGiris * 100) : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('cari-hesaplar.show', $hesap) }}" class="text-decoration-none">
                                            {{ $hesap->ad }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $hesap->tip === 'kasa' ? 'warning' : 'info' }}">
                                            {{ $hesap->tip_label }}
                                        </span>
                                    </td>
                                    <td class="text-end text-success">
                                        {{ number_format($item['girisler'], 2) }}₺
                                    </td>
                                    <td class="text-end text-danger">
                                        {{ number_format($item['cikislar'], 2) }}₺
                                    </td>
                                    <td class="text-end {{ $item['net_hareket'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($item['net_hareket'], 2) }}₺
                                    </td>
                                    <td class="text-end fw-bold">
                                        {{ number_format(abs($hesap->bakiye), 2) }}₺
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-success"
                                                 role="progressbar"
                                                 style="width: {{ $girisPer }}%"
                                                 title="Toplam girişlerin %{{ number_format($girisPer, 1) }}'i">
                                                %{{ number_format($girisPer, 1) }}
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
    @endif
</div>

@push('scripts')
<script>
    function exportExcel() {
        alert('Excel export özelliği yakında eklenecek!');
    }
</script>
@endpush

@push('styles')
<style>
    @media print {
        .btn, .card-header, nav, footer, .alert {
            display: none !important;
        }
        .card {
            page-break-inside: avoid;
        }
    }

    .bg-success-subtle {
        background-color: #d1e7dd !important;
    }

    .bg-danger-subtle {
        background-color: #f8d7da !important;
    }
</style>
@endpush
@endsection
