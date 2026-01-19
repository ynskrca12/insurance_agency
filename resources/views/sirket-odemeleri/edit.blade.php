@extends('layouts.app')

@section('title', 'Ödeme Düzenle - ' . ($sirketOdeme->dekont_no ?? '#' . $sirketOdeme->id))

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('sirket-odemeleri.show', $sirketOdeme) }}"
                       class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                    <h2 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>
                        Şirket Ödemesi Düzenle
                    </h2>
                    <small class="text-muted">
                        Dekont No: {{ $sirketOdeme->dekont_no ?? '#' . $sirketOdeme->id }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Form Bölümü --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Ödeme Bilgilerini Düzenle
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sirket-odemeleri.update', $sirketOdeme) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Şirket Bilgisi (Değiştirilemez) --}}
                        <div class="alert alert-info mb-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle fs-4 me-3"></i>
                                <div>
                                    <strong>Sigorta Şirketi:</strong>
                                    {{ $sirketOdeme->sirketCari->insuranceCompany->name ?? 'Bilinmiyor' }}
                                    <br>
                                    <small>Şirket bilgisi değiştirilemez. Yeni ödeme oluşturmanız gerekir.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Ödeme Tutarı --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-currency-exchange me-2"></i>
                                Ödeme Tutarı (₺) *
                            </label>
                            <input type="number"
                                   name="tutar"
                                   step="0.01"
                                   min="0.01"
                                   class="form-control form-control-lg @error('tutar') is-invalid @enderror"
                                   value="{{ old('tutar', $sirketOdeme->tutar) }}"
                                   required>
                            @error('tutar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Tutarı değiştirirseniz cari kayıtlar yeniden oluşturulacak
                            </small>
                        </div>

                        {{-- Ödeme Tarihi --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-calendar-check me-2"></i>
                                Ödeme Tarihi *
                            </label>
                            <input type="date"
                                   name="odeme_tarihi"
                                   class="form-control @error('odeme_tarihi') is-invalid @enderror"
                                   value="{{ old('odeme_tarihi', $sirketOdeme->odeme_tarihi->format('Y-m-d')) }}"
                                   required>
                            @error('odeme_tarihi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ödeme Yöntemi --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-credit-card me-2"></i>
                                Ödeme Yöntemi *
                            </label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="odeme_yontemi"
                                               id="banka_havale"
                                               value="banka_havale"
                                               {{ old('odeme_yontemi', $sirketOdeme->odeme_yontemi) === 'banka_havale' ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label w-100 p-3 border rounded cursor-pointer" for="banka_havale">
                                            <i class="bi bi-bank fs-4 text-info d-block mb-2"></i>
                                            <strong>Banka Havalesi</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="odeme_yontemi"
                                               id="cek"
                                               value="cek"
                                               {{ old('odeme_yontemi', $sirketOdeme->odeme_yontemi) === 'cek' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 p-3 border rounded cursor-pointer" for="cek">
                                            <i class="bi bi-check2-square fs-4 text-warning d-block mb-2"></i>
                                            <strong>Çek</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="odeme_yontemi"
                                               id="nakit"
                                               value="nakit"
                                               {{ old('odeme_yontemi', $sirketOdeme->odeme_yontemi) === 'nakit' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 p-3 border rounded cursor-pointer" for="nakit">
                                            <i class="bi bi-cash-stack fs-4 text-success d-block mb-2"></i>
                                            <strong>Nakit</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('odeme_yontemi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kasa/Banka Hesabı --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-building me-2"></i>
                                Kasa/Banka Hesabı *
                            </label>
                            <select name="kasa_banka_id"
                                    class="form-select @error('kasa_banka_id') is-invalid @enderror"
                                    required>
                                <option value="">Hesap seçiniz...</option>
                                @foreach($kasaBankaHesaplari as $hesap)
                                    <option value="{{ $hesap->id }}"
                                            {{ old('kasa_banka_id', $sirketOdeme->kasa_banka_id) == $hesap->id ? 'selected' : '' }}>
                                        {{ $hesap->ad }}
                                        (Bakiye: {{ number_format(abs($hesap->bakiye), 2) }}₺)
                                    </option>
                                @endforeach
                            </select>
                            @error('kasa_banka_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dekont No --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-receipt me-2"></i>
                                Dekont/Fiş No
                            </label>
                            <input type="text"
                                   name="dekont_no"
                                   class="form-control @error('dekont_no') is-invalid @enderror"
                                   value="{{ old('dekont_no', $sirketOdeme->dekont_no) }}">
                            @error('dekont_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Açıklama --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-chat-left-text me-2"></i>
                                Açıklama
                            </label>
                            <textarea name="aciklama"
                                      class="form-control @error('aciklama') is-invalid @enderror"
                                      rows="3">{{ old('aciklama', $sirketOdeme->aciklama) }}</textarea>
                            @error('aciklama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Uyarı --}}
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Dikkat!</strong> Ödemeyi güncellerseniz:
                            <ul class="mb-0 mt-2">
                                <li>Mevcut cari kayıtlar silinecek</li>
                                <li>Yeni bilgilere göre cari kayıtlar oluşturulacak</li>
                                <li>Şirket ve kasa bakiyeleri güncellenecek</li>
                            </ul>
                        </div>

                        {{-- Butonlar --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sirket-odemeleri.show', $sirketOdeme) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>İptal
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bilgi Paneli --}}
        <div class="col-lg-4">
            {{-- Mevcut Bilgiler --}}
            <div class="card mb-3 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Mevcut Bilgiler
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Sigorta Şirketi:</small>
                        <div class="fw-bold">{{ $sirketOdeme->sirketCari->insuranceCompany->name ?? '-' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Tutar:</small>
                        <div class="fs-5 fw-bold text-warning">{{ number_format($sirketOdeme->tutar, 2) }}₺</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Tarih:</small>
                        <div>{{ $sirketOdeme->odeme_tarihi->format('d.m.Y') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Ödeme Yöntemi:</small>
                        <div>{{ $sirketOdeme->odeme_yontemi_label }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Oluşturulma:</small>
                        <div class="small">{{ $sirketOdeme->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- İlgili Poliçeler --}}
            @if($sirketOdeme->policy_ids && count($sirketOdeme->policy_ids) > 0)
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            İlgili Poliçeler
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2 small">
                            Bu ödeme {{ count($sirketOdeme->policy_ids) }} poliçe ile ilişkili
                        </p>
                        <small class="text-muted">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Poliçe ilişkileri düzenlemeden değiştirilemez
                        </small>
                    </div>
                </div>
            @endif

            {{-- Hızlı Linkler --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-link-45deg me-2"></i>
                        Hızlı Erişim
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sirket-odemeleri.show', $sirketOdeme) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye me-2"></i>Detay Görüntüle
                        </a>
                        @if($sirketOdeme->sirketCari)
                            <a href="{{ route('cari-hesaplar.show', $sirketOdeme->sirketCari) }}"
                               class="btn btn-sm btn-outline-info">
                                <i class="bi bi-journal-text me-2"></i>Şirket Cari Ekstresi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Ödeme yöntemi seçiminde görsel feedback
    document.addEventListener('DOMContentLoaded', function() {
        const checkedRadio = document.querySelector('input[name="odeme_yontemi"]:checked');
        if (checkedRadio) {
            checkedRadio.nextElementSibling.classList.add('border-primary', 'bg-light');
        }

        document.querySelectorAll('input[name="odeme_yontemi"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.form-check-label').forEach(label => {
                    label.classList.remove('border-primary', 'bg-light');
                });
                this.nextElementSibling.classList.add('border-primary', 'bg-light');
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .form-check-label:hover {
        background-color: #f8f9fa;
    }
    .form-check-input:checked + .form-check-label {
        border-color: #0d6efd !important;
        background-color: #e7f1ff !important;
    }
</style>
@endpush
@endsection
