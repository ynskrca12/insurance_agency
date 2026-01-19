@extends('layouts.app')

@section('title', 'Ödeme Detayı - ' . ($sirketOdeme->dekont_no ?? '#' . $sirketOdeme->id))

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('sirket-odemeleri.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                    <h2 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>
                        Şirket Ödemesi Detayı
                    </h2>
                    <small class="text-muted">
                        Dekont No: {{ $sirketOdeme->dekont_no ?? '#' . $sirketOdeme->id }}
                    </small>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Yazdır
                    </button>
                    <a href="{{ route('sirket-odemeleri.edit', $sirketOdeme) }}" class="btn btn-warning">
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
            {{-- Ödeme Bilgileri Kartı --}}
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        <i class="bi bi-bank me-2"></i>
                        Ödeme Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Sigorta Şirketi Bilgileri</h6>
                            @if($sirketOdeme->sirketCari && $sirketOdeme->sirketCari->insuranceCompany)
                                @php $company = $sirketOdeme->sirketCari->insuranceCompany; @endphp
                                <div class="d-flex align-items-center mb-3">
                                    @if($company->logo)
                                        <img src="{{ $company->logo_url }}"
                                             alt="{{ $company->name }}"
                                             class="rounded me-3"
                                             style="width: 60px; height: 60px; object-fit: contain;">
                                    @endif
                                    <div>
                                        <h5 class="mb-1">{{ $company->name }}</h5>
                                        <small class="text-muted">{{ $company->code }}</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-telephone text-primary me-2"></i>
                                    <strong>Telefon:</strong>
                                    {{ $company->phone ?? '-' }}
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-journal-text text-primary me-2"></i>
                                    <strong>Cari Kod:</strong>
                                    <a href="{{ route('cari-hesaplar.show', $sirketOdeme->sirketCari) }}"
                                       class="text-decoration-none">
                                        {{ $sirketOdeme->sirketCari->kod }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Ödeme Detayları</h6>
                            <div class="mb-2">
                                <i class="bi bi-currency-exchange text-warning me-2"></i>
                                <strong>Tutar:</strong>
                                <span class="fs-4 text-warning fw-bold">
                                    {{ number_format($sirketOdeme->tutar, 2) }}₺
                                </span>
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-calendar-check text-warning me-2"></i>
                                <strong>Ödeme Tarihi:</strong>
                                {{ $sirketOdeme->odeme_tarihi->format('d.m.Y') }}
                            </div>
                            <div class="mb-2">
                                <i class="bi bi-clock text-warning me-2"></i>
                                <strong>Kayıt Zamanı:</strong>
                                {{ $sirketOdeme->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <i class="bi bi-credit-card text-info me-2"></i>
                                <strong>Ödeme Yöntemi:</strong>
                                <span class="badge bg-primary">{{ $sirketOdeme->odeme_yontemi_label }}</span>
                            </div>
                            @if($sirketOdeme->kasaBanka)
                                <div class="mb-2">
                                    <i class="bi bi-{{ $sirketOdeme->kasaBanka->tip === 'kasa' ? 'safe' : 'bank' }} text-info me-2"></i>
                                    <strong>{{ $sirketOdeme->kasaBanka->tip === 'kasa' ? 'Kasa' : 'Banka' }}:</strong>
                                    <a href="{{ route('cari-hesaplar.show', $sirketOdeme->kasaBanka) }}"
                                       class="text-decoration-none">
                                        {{ $sirketOdeme->kasaBanka->ad }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <i class="bi bi-receipt text-info me-2"></i>
                                <strong>Dekont No:</strong>
                                {{ $sirketOdeme->dekont_no ?? '-' }}
                            </div>
                            @if($sirketOdeme->createdBy)
                                <div class="mb-2">
                                    <i class="bi bi-person-badge text-info me-2"></i>
                                    <strong>İşlemi Yapan:</strong>
                                    {{ $sirketOdeme->createdBy->name }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($sirketOdeme->aciklama)
                        <hr>
                        <div>
                            <i class="bi bi-chat-left-text text-muted me-2"></i>
                            <strong>Açıklama:</strong>
                            <p class="mt-2 mb-0">{{ $sirketOdeme->aciklama }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- İlgili Poliçeler --}}
            @if($policies->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            İlgili Poliçeler ({{ $policies->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Poliçe No</th>
                                        <th>Müşteri</th>
                                        <th>Poliçe Türü</th>
                                        <th class="text-end">Prim</th>
                                        <th>Başlangıç</th>
                                        <th>Bitiş</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($policies as $policy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('policies.show', $policy) }}"
                                                   class="text-decoration-none">
                                                    {{ $policy->policy_number }}
                                                </a>
                                            </td>
                                            <td>{{ $policy->customer->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $policy->policy_type_label }}</span>
                                            </td>
                                            <td class="text-end">{{ number_format($policy->premium_amount, 2) }}₺</td>
                                            <td>{{ $policy->start_date->format('d.m.Y') }}</td>
                                            <td>{{ $policy->end_date->format('d.m.Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Toplam Prim:</strong></td>
                                        <td class="text-end">
                                            <strong>{{ number_format($policies->sum('premium_amount'), 2) }}₺</strong>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Cari Hareketler --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-left-right me-2"></i>
                        Oluşturulan Cari Hareketler
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($sirketOdeme->cariHareketler && $sirketOdeme->cariHareketler->count() > 0)
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
                                    @foreach($sirketOdeme->cariHareketler as $hareket)
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
            <div class="card mb-3 border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle-fill text-warning display-1"></i>
                    <h5 class="mt-3 text-warning">Ödeme Tamamlandı</h5>
                    <p class="text-muted mb-0">
                        {{ $sirketOdeme->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            {{-- Şirket Cari Durumu --}}
            @if($sirketOdeme->sirketCari)
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Güncel Cari Durum
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Cari Kod:</small>
                            <div class="fw-bold">{{ $sirketOdeme->sirketCari->kod }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Güncel Bakiye:</small>
                            <div class="fs-4 fw-bold {{ $sirketOdeme->sirketCari->bakiye < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format(abs($sirketOdeme->sirketCari->bakiye), 2) }}₺
                            </div>
                            <small class="text-muted">{{ $sirketOdeme->sirketCari->bakiye_durumu }}</small>
                        </div>
                    </div>
                </div>
            @endif

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
                        @if($sirketOdeme->sirketCari && $sirketOdeme->sirketCari->insuranceCompany)
                            <a href="{{ route('sirket-odemeleri.create', ['insurance_company_id' => $sirketOdeme->sirketCari->insuranceCompany->id]) }}"
                               class="btn btn-outline-warning">
                                <i class="bi bi-plus-circle me-2"></i>
                                Aynı Şirkete Yeni Ödeme
                            </a>
                            <a href="{{ route('cari-hesaplar.show', $sirketOdeme->sirketCari) }}"
                               class="btn btn-outline-primary">
                                <i class="bi bi-journal-text me-2"></i>
                                Şirket Cari Ekstresi
                            </a>
                        @endif
                        @if($sirketOdeme->kasaBanka)
                            <a href="{{ route('cari-hesaplar.show', $sirketOdeme->kasaBanka) }}"
                               class="btn btn-outline-info">
                                <i class="bi bi-bank me-2"></i>
                                Kasa/Banka Hareketleri
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
      action="{{ route('sirket-odemeleri.destroy', $sirketOdeme) }}"
      method="POST"
      class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function confirmDelete() {
        if (confirm('Bu ödemeyi silmek istediğinizden emin misiniz?\n\nBu işlem:\n- Ödeme kaydını silecek\n- Oluşturulan cari kayıtları silecek\n- Şirket ve kasa bakiyelerini güncelleyecek\n\nBu işlem geri alınamaz!')) {
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
