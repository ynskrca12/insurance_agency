@extends('layouts.app')

@section('title', 'Tahsilatlar')

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-cash-coin me-2"></i>
                    Tahsilatlar
                </h2>
                <a href="{{ route('tahsilatlar.create') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>
                    Yeni Tahsilat
                </a>
            </div>
        </div>
    </div>

    {{-- İstatistik Kartı --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-calendar-check me-2"></i>
                        Toplam Tahsilat
                    </h6>
                    <h3 class="mb-0 text-success">
                        {{ number_format($toplamTahsilat, 2) }}₺
                    </h3>
                    <small class="text-muted">Filtrelenmiş dönem</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-cash-stack me-2"></i>
                        Nakit Tahsilat
                    </h6>
                    <h4 class="mb-0 text-primary">
                        {{ number_format(
                            \App\Models\Tahsilat::where('tenant_id', auth()->id())
                                ->where('odeme_yontemi', 'nakit')
                                ->sum('tutar'),
                            2
                        ) }}₺
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-credit-card me-2"></i>
                        Kredi Kartı
                    </h6>
                    <h4 class="mb-0 text-info">
                        {{ number_format(
                            \App\Models\Tahsilat::where('tenant_id', auth()->id())
                                ->where('odeme_yontemi', 'kredi_kart')
                                ->sum('tutar'),
                            2
                        ) }}₺
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-bank me-2"></i>
                        Havale/EFT
                    </h6>
                    <h4 class="mb-0 text-warning">
                        {{ number_format(
                            \App\Models\Tahsilat::where('tenant_id', auth()->id())
                                ->where('odeme_yontemi', 'banka_havale')
                                ->sum('tutar'),
                            2
                        ) }}₺
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtreler --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tahsilatlar.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date"
                               name="baslangic"
                               class="form-control"
                               value="{{ request('baslangic', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date"
                               name="bitis"
                               class="form-control"
                               value="{{ request('bitis', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ödeme Yöntemi</label>
                        <select name="odeme_yontemi" class="form-select">
                            <option value="">Tümü</option>
                            <option value="nakit" {{ request('odeme_yontemi') === 'nakit' ? 'selected' : '' }}>
                                Nakit
                            </option>
                            <option value="kredi_kart" {{ request('odeme_yontemi') === 'kredi_kart' ? 'selected' : '' }}>
                                Kredi Kartı
                            </option>
                            <option value="banka_havale" {{ request('odeme_yontemi') === 'banka_havale' ? 'selected' : '' }}>
                                Banka Havalesi
                            </option>
                            <option value="cek" {{ request('odeme_yontemi') === 'cek' ? 'selected' : '' }}>
                                Çek
                            </option>
                            <option value="sanal_pos" {{ request('odeme_yontemi') === 'sanal_pos' ? 'selected' : '' }}>
                                Sanal POS
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                        <a href="{{ route('tahsilatlar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Temizle
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tahsilat Listesi --}}
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Tahsilat Kayıtları
            </h5>
        </div>
        <div class="card-body p-0">
            @if($tahsilatlar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Tarih</th>
                                <th style="width: 120px;">Makbuz No</th>
                                <th>Müşteri</th>
                                <th>Kasa/Banka</th>
                                <th style="width: 130px;">Ödeme Yöntemi</th>
                                <th class="text-end" style="width: 130px;">Tutar</th>
                                <th>Açıklama</th>
                                <th class="text-end" style="width: 100px;">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tahsilatlar as $tahsilat)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $tahsilat->tahsilat_tarihi->format('d.m.Y') }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            {{ $tahsilat->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('tahsilatlar.show', $tahsilat) }}"
                                           class="text-decoration-none">
                                            <strong class="text-primary">
                                                {{ $tahsilat->makbuz_no ?? '#' . $tahsilat->id }}
                                            </strong>
                                        </a>
                                    </td>
                                    <td>
                                        @if($tahsilat->musteriCari && $tahsilat->musteriCari->customer)
                                            <a href="{{ route('cari-hesaplar.show', $tahsilat->musteriCari) }}"
                                               class="text-decoration-none">
                                                {{ $tahsilat->musteriCari->customer->name }}
                                            </a>
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $tahsilat->musteriCari->customer->phone }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tahsilat->kasaBanka)
                                            <span class="badge bg-{{ $tahsilat->kasaBanka->tip === 'kasa' ? 'warning' : 'info' }}">
                                                <i class="bi bi-{{ $tahsilat->kasaBanka->tip === 'kasa' ? 'safe' : 'bank' }} me-1"></i>
                                                {{ $tahsilat->kasaBanka->ad }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $odemeYontemiIcons = [
                                                'nakit' => 'cash-stack',
                                                'kredi_kart' => 'credit-card',
                                                'banka_havale' => 'bank',
                                                'cek' => 'check2-square',
                                                'sanal_pos' => 'phone',
                                            ];
                                            $odemeYontemiBadges = [
                                                'nakit' => 'success',
                                                'kredi_kart' => 'primary',
                                                'banka_havale' => 'info',
                                                'cek' => 'warning',
                                                'sanal_pos' => 'secondary',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $odemeYontemiBadges[$tahsilat->odeme_yontemi] ?? 'secondary' }}">
                                            <i class="bi bi-{{ $odemeYontemiIcons[$tahsilat->odeme_yontemi] ?? 'question-circle' }} me-1"></i>
                                            {{ $tahsilat->odeme_yontemi_label }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success fs-6">
                                            {{ number_format($tahsilat->tutar, 2) }}₺
                                        </strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Str::limit($tahsilat->aciklama, 50) }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('tahsilatlar.show', $tahsilat) }}"
                                               class="btn btn-outline-primary"
                                               data-bs-toggle="tooltip"
                                               title="Detay">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('tahsilatlar.edit', $tahsilat) }}"
                                               class="btn btn-outline-warning"
                                               data-bs-toggle="tooltip"
                                               title="Düzenle">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Sil"
                                                    onclick="confirmDelete({{ $tahsilat->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        {{-- Silme Formu (Gizli) --}}
                                        <form id="delete-form-{{ $tahsilat->id }}"
                                              action="{{ route('tahsilatlar.destroy', $tahsilat) }}"
                                              method="POST"
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="5" class="text-end"><strong>Sayfa Toplamı:</strong></td>
                                <td class="text-end">
                                    <strong class="text-success fs-5">
                                        {{ number_format($tahsilatlar->sum('tutar'), 2) }}₺
                                    </strong>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $tahsilatlar->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-4">Henüz tahsilat kaydı bulunmuyor.</p>
                    <a href="{{ route('tahsilatlar.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>İlk Tahsilatı Oluştur
                    </a>
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

    // Silme onayı
    function confirmDelete(id) {
        if (confirm('Bu tahsilatı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection
