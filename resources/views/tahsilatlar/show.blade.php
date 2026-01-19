@extends('layouts.app')

@section('title', 'Tahsilat Detayı - ' . ($tahsilat->makbuz_no ?? '#' . $tahsilat->id))

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('tahsilatlar.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                    <h2 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>
                        Tahsilat Detayı
                    </h2>
                    <small class="text-muted">
                        Makbuz No: {{ $tahsilat->makbuz_no ?? '#' . $tahsilat->id }}
                    </small>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Yazdır
                    </button>
                    <a href="{{ route('tahsilatlar.edit', $tahsilat) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Düzenle
                    </a>
                    <button type="button"
                            class="btn btn-danger"
                            onclick="confirmDelete()">
                        <i class="bi bi-trash me-2"></i>Sil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Ana Bilgiler --}}
        <div class="col-lg-8">
            {{-- Tahsilat Bilgileri Kartı --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-cash-coin me-2"></i>
                        Tahsilat Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Müşteri Bilgileri</h6>
                            @if($tahsilat->musteriCari && $tahsilat->musteriCari->customer)
                                <div class="mb-2">
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    <strong>Ad Soyad:</strong>
                                    <a href="{{ route('customers.show', $tahsilat->musteriCari->customer) }}"
                                       class="text-decoration-none">
                                        {{ $tahsilat->musteriCari->customer->name }}
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-telephone text-primary me-2"></i>
                                    <strong>Telefon:</strong>
                                    {{ $tahsilat->musteriCari->customer->phone }}
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-journal-text text-primary me-2"></i>
                                    <strong>Cari Kod:</strong>
                                    <a href="{{ route('cari-hesaplar.show', $tahsilat->musteriCari) }}"
                                       class="text-decoration-none">
                                        {{ $tahsilat->musteriCari->kod }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Tahsilat Detayları</h6>
                            <div class="mb-2">
                                <i class="bi bi-currency-exchange text-success me-2"></i>
                                <strong>Tutar:</strong>
                                <span class="fs-4 text-success fw-bold">
                                    {{ number_format($tahsilat->tutar, 2) }}₺
                                </span>
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-calendar-check text-success me-2"></i>
                                <strong>Tahsilat Tarihi:</strong>
                                {{ $tahsilat->tahsilat_tarihi->format('d.m.Y') }}
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-clock text-success me-2"></i>
                                <strong>Kayıt Zamanı:</strong>
                                {{ $tahsilat->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <i class="bi bi-credit-card text-info me-2"></i>
                                <strong>Ödeme Yöntemi:</strong>
                                <span class="badge bg-primary">{{ $tahsilat->odeme_yontemi_label }}</span>
                            </div>
                            @if($tahsilat->kasaBanka)
                                <div class="mb-2">
                                    <i class="bi bi-{{ $tahsilat->kasaBanka->tip === 'kasa' ? 'safe' : 'bank' }} text-info me-2"></i>
                                    <strong>{{ $tahsilat->kasaBanka->tip === 'kasa' ? 'Kasa' : 'Banka' }}:</strong>
                                    <a href="{{ route('cari-hesaplar.show', $tahsilat->kasaBanka) }}"
                                       class="text-decoration-none">
                                        {{ $tahsilat->kasaBanka->ad }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <i class="bi bi-receipt text-info me-2"></i>
                                <strong>Makbuz No:</strong>
                                {{ $tahsilat->makbuz_no ?? '-' }}
                            </div>
                            @if($tahsilat->createdBy)
                                <div class="mb-2">
                                    <i class="bi bi-person-badge text-info me-2"></i>
                                    <strong>İşlemi Yapan:</strong>
                                    {{ $tahsilat->createdBy->name }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($tahsilat->aciklama)
                        <hr>
                        <div>
                            <i class="bi bi-chat-left-text text-muted me-2"></i>
                            <strong>Açıklama:</strong>
                            <p class="mt-2 mb-0">{{ $tahsilat->aciklama }}</p>
                        </div>
                    @endif

                    @if($tahsilat->policy)
                        <hr>
                        <div>
                            <i class="bi bi-file-earmark-text text-muted me-2"></i>
                            <strong>İlgili Poliçe:</strong>
                            <a href="{{ route('policies.show', $tahsilat->policy) }}"
                               class="text-decoration-none">
                                {{ $tahsilat->policy->policy_number }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Cari Hareketler --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-left-right me-2"></i>
                        Oluşturulan Cari Hareketler
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($tahsilat->cariHareketler && $tahsilat->cariHareketler->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Cari Hesap</th>
                                        <th>İşlem Tipi</th>
                                        <th class="text-end">Tutar</th>
                                        <th>Açıklama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tahsilat->cariHareketler as $hareket)
                                        <tr>
                                            <td>
                                                <a href="{{ route('cari-hesaplar.show', $hareket->cariHesap) }}"
                                                   class="text-decoration-none">
                                                    {{ $hareket->cariHesap->kod }} - {{ $hareket->cariHesap->ad }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $hareket->islem_tipi === 'borc' ? 'danger' : 'success' }}">
                                                    {{ $hareket->islem_tipi_label }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-{{ $hareket->islem_tipi === 'borc' ? 'danger' : 'success' }}">
                                                    {{ number_format($hareket->tutar, 2) }}₺
                                                </strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $hareket->aciklama }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <small>Henüz cari hareket oluşturulmamış</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Yan Panel --}}
        <div class="col-lg-4">
            {{-- Durum Kartı --}}
            <div class="card mb-3 border-success">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle-fill text-success display-1"></i>
                    <h5 class="mt-3 text-success">Tahsilat Tamamlandı</h5>
                    <p class="text-muted mb-0">
                        {{ $tahsilat->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            {{-- Hızlı İşlemler --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Hızlı İşlemler
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($tahsilat->musteriCari && $tahsilat->musteriCari->customer)
                            <a href="{{ route('tahsilatlar.create', ['customer_id' => $tahsilat->musteriCari->customer->id]) }}"
                               class="btn btn-outline-success">
                                <i class="bi bi-plus-circle me-2"></i>
                                Aynı Müşteriye Yeni Tahsilat
                            </a>
                            <a href="{{ route('cari-hesaplar.show', $tahsilat->musteriCari) }}"
                               class="btn btn-outline-primary">
                                <i class="bi bi-journal-text me-2"></i>
                                Müşteri Cari Ekstresi
                            </a>
                            <a href="{{ route('customers.show', $tahsilat->musteriCari->customer) }}"
                               class="btn btn-outline-info">
                                <i class="bi bi-person-circle me-2"></i>
                                Müşteri Detayı
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Silme Formu --}}
<form id="delete-form"
      action="{{ route('tahsilatlar.destroy', $tahsilat) }}"
      method="POST"
      class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function confirmDelete() {
        if (confirm('Bu tahsilatı silmek istediğinizden emin misiniz?\n\nBu işlem:\n- Tahsilat kaydını silecek\n- Oluşturulan cari kayıtları silecek\n- Müşteri ve kasa bakiyelerini güncelleyecek\n\nBu işlem geri alınamaz!')) {
            document.getElementById('delete-form').submit();
        }
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
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
@endsection
