@extends('layouts.app')

@section('title', 'Cari Ekstre - ' . $cariHesap->ad)

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('cari-hesaplar.index', ['tip' => $cariHesap->tip]) }}"
                       class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                    <h2 class="mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        {{ $cariHesap->ad }}
                    </h2>
                    <small class="text-muted">{{ $cariHesap->kod }} - {{ $cariHesap->tip_label }}</small>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#hareketEkleModal">
                        <i class="bi bi-plus-circle me-2"></i>Manuel Hareket Ekle
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Yazdır
                    </button>
                    <form action="{{ route('cari-hesaplar.recalculate', $cariHesap) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-arrow-clockwise me-2"></i>Bakiye Yenile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bakiye Kartı --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card {{ $cariHesap->bakiye > 0 ? 'border-danger' : ($cariHesap->bakiye < 0 ? 'border-success' : 'border-secondary') }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Güncel Bakiye</h6>
                            <h2 class="mb-0 {{ $cariHesap->bakiye > 0 ? 'text-danger' : ($cariHesap->bakiye < 0 ? 'text-success' : '') }}">
                                {{ number_format(abs($cariHesap->bakiye), 2) }}₺
                            </h2>
                            <span class="badge {{ $cariHesap->bakiye > 0 ? 'bg-danger' : ($cariHesap->bakiye < 0 ? 'bg-success' : 'bg-secondary') }}">
                                {{ $cariHesap->bakiye_durumu }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Dönem Başı Bakiye</h6>
                            <h4 class="mb-0">{{ number_format(abs($donemBasiBakiye), 2) }}₺</h4>
                            <small class="text-muted">{{ $baslangic }}</small>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Dönem Borç</h6>
                            <h4 class="mb-0 text-danger">{{ number_format($donemBorclar, 2) }}₺</h4>
                            <small class="text-muted">{{ $baslangic }} - {{ $bitis }}</small>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-2">Dönem Alacak</h6>
                            <h4 class="mb-0 text-success">{{ number_format($donemAlacaklar, 2) }}₺</h4>
                            <small class="text-muted">{{ $baslangic }} - {{ $bitis }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Müşteri/Şirket Bilgisi --}}
    @if($cariHesap->customer)
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Müşteri Bilgileri</h6>
                        <p class="mb-1"><strong>Ad Soyad:</strong> {{ $cariHesap->customer->name }}</p>
                        <p class="mb-1"><strong>Telefon:</strong> {{ $cariHesap->customer->phone }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $cariHesap->customer->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Cari Ayarları</h6>
                        <p class="mb-1"><strong>Vade Günü:</strong> {{ $cariHesap->vade_gun }} gün</p>
                        <p class="mb-1"><strong>Kredi Limiti:</strong> {{ $cariHesap->kredi_limiti ? number_format($cariHesap->kredi_limiti, 2) . '₺' : '-' }}</p>
                        <p class="mb-0">
                            <a href="{{ route('customers.show', $cariHesap->customer) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-person me-2"></i>Müşteri Detayı
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($cariHesap->insuranceCompany)
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Şirket Bilgileri</h6>
                        <p class="mb-1"><strong>Şirket:</strong> {{ $cariHesap->insuranceCompany->name }}</p>
                        <p class="mb-1"><strong>Kod:</strong> {{ $cariHesap->insuranceCompany->code }}</p>
                        <p class="mb-0"><strong>Telefon:</strong> {{ $cariHesap->insuranceCompany->phone ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Cari Ayarları</h6>
                        <p class="mb-1"><strong>Vade Günü:</strong> {{ $cariHesap->vade_gun }} gün</p>
                        <p class="mb-0">
                            <a href="{{ route('sirket-odemeleri.create', ['insurance_company_id' => $cariHesap->insuranceCompany->id]) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-credit-card me-2"></i>Ödeme Yap
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tarih Filtresi --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('cari-hesaplar.show', $cariHesap) }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date" name="baslangic" class="form-control" value="{{ $baslangic }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date" name="bitis" class="form-control" value="{{ $bitis }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Cari Hareketler Tablosu --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Cari Hareketler
            </h5>
        </div>
        <div class="card-body p-0">
            @if($hareketler->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Tarih</th>
                                <th style="width: 80px;">İşlem</th>
                                <th>Açıklama</th>
                                <th style="width: 100px;">Ödeme Yöntemi</th>
                                <th style="width: 100px;">Vade</th>
                                <th class="text-end" style="width: 120px;">Borç</th>
                                <th class="text-end" style="width: 120px;">Alacak</th>
                                <th class="text-end" style="width: 120px;">Bakiye</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dönem Başı Satırı --}}
                            <tr class="table-secondary">
                                <td colspan="5"><strong>Dönem Başı Bakiye</strong></td>
                                <td class="text-end">-</td>
                                <td class="text-end">-</td>
                                <td class="text-end">
                                    <strong>{{ number_format(abs($donemBasiBakiye), 2) }}₺</strong>
                                </td>
                            </tr>

                            {{-- Hareketler --}}
                            @php $runningBalance = $donemBasiBakiye; @endphp
                            @foreach($hareketler as $hareket)
                                @php
                                    if ($hareket->islem_tipi === 'borc') {
                                        $runningBalance += $hareket->tutar;
                                    } else {
                                        $runningBalance -= $hareket->tutar;
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <small>{{ $hareket->islem_tarihi->format('d.m.Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $hareket->islem_tipi === 'borc' ? 'danger' : 'success' }}">
                                            {{ $hareket->islem_tipi_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $hareket->aciklama }}</small>
                                        @if($hareket->belge_no)
                                            <br>
                                            <span class="badge bg-secondary">{{ $hareket->belge_no }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $hareket->odeme_yontemi_label }}</small>
                                    </td>
                                    <td>
                                        @if($hareket->vade_tarihi)
                                            <small class="text-muted">{{ $hareket->vade_tarihi->format('d.m.Y') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($hareket->islem_tipi === 'borc')
                                            <span class="text-danger">{{ number_format($hareket->tutar, 2) }}₺</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($hareket->islem_tipi === 'alacak')
                                            <span class="text-success">{{ number_format($hareket->tutar, 2) }}₺</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <strong class="{{ $runningBalance > 0 ? 'text-danger' : ($runningBalance < 0 ? 'text-success' : '') }}">
                                            {{ number_format(abs($runningBalance), 2) }}₺
                                        </strong>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Toplam Satırı --}}
                            <tr class="table-secondary">
                                <td colspan="5"><strong>Dönem Toplamı</strong></td>
                                <td class="text-end">
                                    <strong class="text-danger">{{ number_format($donemBorclar, 2) }}₺</strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">{{ number_format($donemAlacaklar, 2) }}₺</strong>
                                </td>
                                <td class="text-end">
                                    <strong class="{{ $cariHesap->bakiye > 0 ? 'text-danger' : ($cariHesap->bakiye < 0 ? 'text-success' : '') }}">
                                        {{ number_format(abs($cariHesap->bakiye), 2) }}₺
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">Seçili tarih aralığında hareket bulunmuyor.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Manuel Hareket Ekleme Modal --}}
<div class="modal fade" id="hareketEkleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cari-hesaplar.add-hareket', $cariHesap) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Manuel Hareket Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">İşlem Tipi *</label>
                        <select name="islem_tipi" class="form-select" required>
                            <option value="borc">Borç</option>
                            <option value="alacak">Alacak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tutar *</label>
                        <input type="number" name="tutar" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">İşlem Tarihi *</label>
                        <input type="date" name="islem_tarihi" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vade Tarihi</label>
                        <input type="date" name="vade_tarihi" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ödeme Yöntemi</label>
                        <select name="odeme_yontemi" class="form-select">
                            <option value="">Seçiniz</option>
                            <option value="nakit">Nakit</option>
                            <option value="kredi_kart">Kredi Kartı</option>
                            <option value="banka_havale">Banka Havalesi</option>
                            <option value="cek">Çek</option>
                            <option value="sanal_pos">Sanal POS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Belge No</label>
                        <input type="text" name="belge_no" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama *</label>
                        <textarea name="aciklama" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn, .card-header, .modal, nav, footer {
            display: none !important;
        }
    }
</style>
@endpush
@endsection
