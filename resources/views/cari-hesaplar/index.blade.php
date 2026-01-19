@extends('layouts.app')

@section('title', 'Cari Hesaplar')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-journal-text me-2"></i>
                    Cari Hesaplar
                </h2>
                <a href="{{ route('cari-hesaplar.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Yeni Kasa/Banka
                </a>
            </div>
        </div>
    </div>

    {{-- Tab Menü --}}
    <ul class="nav nav-tabs mb-4" id="cariTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tip === 'musteri' ? 'active' : '' }}"
               href="{{ route('cari-hesaplar.index', ['tip' => 'musteri']) }}">
                <i class="bi bi-person-circle me-2"></i>
                Müşteri Carisi
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tip === 'sirket' ? 'active' : '' }}"
               href="{{ route('cari-hesaplar.index', ['tip' => 'sirket']) }}">
                <i class="bi bi-building me-2"></i>
                Şirket Carisi
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tip === 'kasa' ? 'active' : '' }}"
               href="{{ route('cari-hesaplar.index', ['tip' => 'kasa']) }}">
                <i class="bi bi-safe me-2"></i>
                Kasa
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tip === 'banka' ? 'active' : '' }}"
               href="{{ route('cari-hesaplar.index', ['tip' => 'banka']) }}">
                <i class="bi bi-bank me-2"></i>
                Banka
            </a>
        </li>
    </ul>

    {{-- İstatistik Kartları --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Toplam Alacak</h6>
                    <h3 class="mb-0 text-danger">
                        {{ number_format($istatistikler['toplam_borc'], 2) }}₺
                    </h3>
                    <small class="text-muted">Bizim alacağımız var</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Toplam Borç</h6>
                    <h3 class="mb-0 text-success">
                        {{ number_format($istatistikler['toplam_alacak'], 2) }}₺
                    </h3>
                    <small class="text-muted">Bizim borcumuz var</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Toplam Cari Hesap</h6>
                    <h3 class="mb-0 text-primary">
                        {{ $istatistikler['toplam_sayisi'] }}
                    </h3>
                    <small class="text-muted">Aktif hesap sayısı</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtreler --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('cari-hesaplar.index') }}">
                <input type="hidden" name="tip" value="{{ $tip }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Arama</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Kod veya ad ile ara..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bakiye Durumu</label>
                        <select name="bakiye_durumu" class="form-select">
                            <option value="">Tümü</option>
                            <option value="borclu" {{ request('bakiye_durumu') === 'borclu' ? 'selected' : '' }}>
                                Borçlular (Bizden alacaklı)
                            </option>
                            <option value="alacakli" {{ request('bakiye_durumu') === 'alacakli' ? 'selected' : '' }}>
                                Alacaklılar (Bize borçlu)
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-2"></i>Ara
                        </button>
                        <a href="{{ route('cari-hesaplar.index', ['tip' => $tip]) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Temizle
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Cari Hesaplar Listesi --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                @if($tip === 'musteri')
                    <i class="bi bi-person-circle me-2"></i>Müşteri Cari Hesapları
                @elseif($tip === 'sirket')
                    <i class="bi bi-building me-2"></i>Şirket Cari Hesapları
                @elseif($tip === 'kasa')
                    <i class="bi bi-safe me-2"></i>Kasa Hesapları
                @else
                    <i class="bi bi-bank me-2"></i>Banka Hesapları
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            @if($cariHesaplar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kod</th>
                                <th>Ad</th>
                                @if($tip === 'musteri' || $tip === 'sirket')
                                    <th>Vade Günü</th>
                                @endif
                                <th class="text-end">Bakiye</th>
                                <th>Durum</th>
                                <th class="text-end">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cariHesaplar as $cari)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $cari->kod }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('cari-hesaplar.show', $cari) }}"
                                           class="text-decoration-none">
                                            {{ $cari->ad }}
                                        </a>
                                        @if($cari->customer)
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $cari->customer->phone }}
                                            </small>
                                        @endif
                                    </td>
                                    @if($tip === 'musteri' || $tip === 'sirket')
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $cari->vade_gun }} gün
                                            </span>
                                        </td>
                                    @endif
                                    <td class="text-end">
                                        <strong class="fs-6 {{ $cari->bakiye > 0 ? 'text-danger' : ($cari->bakiye < 0 ? 'text-success' : '') }}">
                                            {{ number_format(abs($cari->bakiye), 2) }}₺
                                        </strong>
                                    </td>
                                    <td>
                                        @if($cari->bakiye > 0)
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                Borçlu
                                            </span>
                                        @elseif($cari->bakiye < 0)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Alacaklı
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-dash-circle me-1"></i>
                                                Dengede
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('cari-hesaplar.show', $cari) }}"
                                               class="btn btn-outline-primary"
                                               data-bs-toggle="tooltip"
                                               title="Ekstre Görüntüle">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($tip === 'musteri')
                                                <a href="{{ route('tahsilatlar.create', ['customer_id' => $cari->referans_id]) }}"
                                                   class="btn btn-outline-success"
                                                   data-bs-toggle="tooltip"
                                                   title="Tahsilat Yap">
                                                    <i class="bi bi-cash-coin"></i>
                                                </a>
                                            @elseif($tip === 'sirket')
                                                <a href="{{ route('sirket-odemeleri.create', ['insurance_company_id' => $cari->referans_id]) }}"
                                                   class="btn btn-outline-warning"
                                                   data-bs-toggle="tooltip"
                                                   title="Ödeme Yap">
                                                    <i class="bi bi-credit-card"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $cariHesaplar->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">Henüz cari hesap kaydı bulunmuyor.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tooltip'leri aktif et
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection
