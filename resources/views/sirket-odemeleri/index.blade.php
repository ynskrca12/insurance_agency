@extends('layouts.app')

@section('title', 'Şirket Ödemeleri')

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-bank me-2"></i>
                    Şirket Ödemeleri
                </h2>
                <a href="{{ route('sirket-odemeleri.create') }}" class="btn btn-warning btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>
                    Yeni Ödeme
                </a>
            </div>
        </div>
    </div>

    {{-- İstatistik Kartı --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-calendar-check me-2"></i>
                        Toplam Ödeme
                    </h6>
                    <h3 class="mb-0 text-warning">
                        {{ number_format($toplamOdeme, 2) }}₺
                    </h3>
                    <small class="text-muted">Filtrelenmiş dönem</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Bekleyen Borç
                    </h6>
                    <h4 class="mb-0 text-danger">
                        {{ number_format(
                            \App\Models\CariHesap::where('tenant_id', auth()->id())
                                ->where('tip', 'sirket')
                                ->where('bakiye', '<', 0)
                                ->sum('bakiye') * -1,
                            2
                        ) }}₺
                    </h4>
                    <small class="text-muted">Şirketlere borç</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-bank me-2"></i>
                        Havale/EFT
                    </h6>
                    <h4 class="mb-0 text-primary">
                        {{ number_format(
                            \App\Models\SirketOdeme::where('tenant_id', auth()->id())
                                ->where('odeme_yontemi', 'banka_havale')
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
                        <i class="bi bi-building me-2"></i>
                        Aktif Şirket
                    </h6>
                    <h4 class="mb-0 text-info">
                        {{ \App\Models\CariHesap::where('tenant_id', auth()->id())
                            ->where('tip', 'sirket')
                            ->count() }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtreler --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sirket-odemeleri.index') }}">
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
                        <label class="form-label">Sigorta Şirketi</label>
                        <select name="insurance_company_id" class="form-select">
                            <option value="">Tümü</option>
                            @foreach(\App\Models\InsuranceCompany::active()->orderBy('name')->get() as $company)
                                <option value="{{ $company->id }}"
                                        {{ request('insurance_company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                        <a href="{{ route('sirket-odemeleri.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Temizle
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Ödeme Listesi --}}
    <div class="card">
        <div class="card-header bg-warning">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Ödeme Kayıtları
            </h5>
        </div>
        <div class="card-body p-0">
            @if($odemeler->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Tarih</th>
                                <th style="width: 120px;">Dekont No</th>
                                <th>Sigorta Şirketi</th>
                                <th>Kasa/Banka</th>
                                <th style="width: 130px;">Ödeme Yöntemi</th>
                                <th class="text-end" style="width: 130px;">Tutar</th>
                                <th>Açıklama</th>
                                <th class="text-end" style="width: 100px;">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($odemeler as $odeme)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $odeme->odeme_tarihi->format('d.m.Y') }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            {{ $odeme->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('sirket-odemeleri.show', $odeme) }}"
                                           class="text-decoration-none">
                                            <strong class="text-primary">
                                                {{ $odeme->dekont_no ?? '#' . $odeme->id }}
                                            </strong>
                                        </a>
                                    </td>
                                    <td>
                                        @if($odeme->sirketCari && $odeme->sirketCari->insuranceCompany)
                                            <a href="{{ route('cari-hesaplar.show', $odeme->sirketCari) }}"
                                               class="text-decoration-none">
                                                <div class="d-flex align-items-center">
                                                    @if($odeme->sirketCari->insuranceCompany->logo)
                                                        <img src="{{ $odeme->sirketCari->insuranceCompany->logo_url }}"
                                                             alt="{{ $odeme->sirketCari->insuranceCompany->name }}"
                                                             class="rounded me-2"
                                                             style="width: 30px; height: 30px; object-fit: contain;">
                                                    @endif
                                                    <div>
                                                        {{ $odeme->sirketCari->insuranceCompany->name }}
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $odeme->sirketCari->kod }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($odeme->kasaBanka)
                                            <span class="badge bg-{{ $odeme->kasaBanka->tip === 'kasa' ? 'warning' : 'info' }}">
                                                <i class="bi bi-{{ $odeme->kasaBanka->tip === 'kasa' ? 'safe' : 'bank' }} me-1"></i>
                                                {{ $odeme->kasaBanka->ad }}
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
                                        <span class="badge bg-{{ $odemeYontemiBadges[$odeme->odeme_yontemi] ?? 'secondary' }}">
                                            <i class="bi bi-{{ $odemeYontemiIcons[$odeme->odeme_yontemi] ?? 'question-circle' }} me-1"></i>
                                            {{ $odeme->odeme_yontemi_label }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-warning fs-6">
                                            {{ number_format($odeme->tutar, 2) }}₺
                                        </strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Str::limit($odeme->aciklama, 50) }}
                                        </small>
                                        @if($odeme->policy_ids && count($odeme->policy_ids) > 0)
                                            <br>
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-file-earmark-text me-1"></i>
                                                {{ count($odeme->policy_ids) }} Poliçe
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('sirket-odemeleri.show', $odeme) }}"
                                               class="btn btn-outline-primary"
                                               data-bs-toggle="tooltip"
                                               title="Detay">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('sirket-odemeleri.edit', $odeme) }}"
                                               class="btn btn-outline-warning"
                                               data-bs-toggle="tooltip"
                                               title="Düzenle">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Sil"
                                                    onclick="confirmDelete({{ $odeme->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        {{-- Silme Formu (Gizli) --}}
                                        <form id="delete-form-{{ $odeme->id }}"
                                              action="{{ route('sirket-odemeleri.destroy', $odeme) }}"
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
                                    <strong class="text-warning fs-5">
                                        {{ number_format($odemeler->sum('tutar'), 2) }}₺
                                    </strong>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $odemeler->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-4">Henüz şirket ödemesi kaydı bulunmuyor.</p>
                    <a href="{{ route('sirket-odemeleri.create') }}" class="btn btn-warning">
                        <i class="bi bi-plus-circle me-2"></i>İlk Ödemeyi Oluştur
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
        if (confirm('Bu ödemeyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection
