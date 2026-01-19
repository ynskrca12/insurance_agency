@extends('layouts.app')

@section('title', 'Tahsilat Düzenle - ' . ($tahsilat->makbuz_no ?? '#' . $tahsilat->id))

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('tahsilatlar.show', $tahsilat) }}"
                       class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                    <h2 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>
                        Tahsilat Düzenle
                    </h2>
                    <small class="text-muted">
                        Makbuz No: {{ $tahsilat->makbuz_no ?? '#' . $tahsilat->id }}
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
                        Tahsilat Bilgilerini Düzenle
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tahsilatlar.update', $tahsilat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Müşteri Bilgisi (Değiştirilemez) --}}
                        <div class="alert alert-info mb-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle fs-4 me-3"></i>
                                <div>
                                    <strong>Müşteri:</strong>
                                    {{ $tahsilat->musteriCari->customer->name ?? 'Bilinmiyor' }}
                                    <br>
                                    <small>Müşteri bilgisi değiştirilemez. Yeni tahsilat oluşturmanız gerekir.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Tahsilat Tutarı --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-currency-exchange me-2"></i>
                                Tahsilat Tutarı (₺) *
                            </label>
                            <input type="number"
                                   name="tutar"
                                   step="0.01"
                                   min="0.01"
                                   class="form-control form-control-lg @error('tutar') is-invalid @enderror"
                                   value="{{ old('tutar', $tahsilat->tutar) }}"
                                   required>
                            @error('tutar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Tutarı değiştirirseniz cari kayıtlar yeniden oluşturulacak
                            </small>
                        </div>

                        {{-- Tahsilat Tarihi --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-calendar-check me-2"></i>
                                Tahsilat Tarihi *
                            </label>
                            <input type="date"
                                   name="tahsilat_tarihi"
                                   class="form-control @error('tahsilat_tarihi') is-invalid @enderror"
                                   value="{{ old('tahsilat_tarihi', $tahsilat->tahsilat_tarihi->format('Y-m-d')) }}"
                                   required>
                            @error('tahsilat_tarihi')
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
                                               id="nakit"
                                               value="nakit"
                                               {{ old('odeme_yontemi', $tahsilat->odeme_yontemi) === 'nakit' ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label w-100 p-3 border rounded cursor-pointer" for="nakit">
                                            <i class="bi bi-cash-stack fs-4 text-success d-block mb-2"></i>
                                            <strong>Nakit</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="odeme_yontemi"
                                               id="kredi_kart"
                                               value="kredi_kart"
                                               {{ old('odeme_yontemi', $tahsilat->odeme_yontemi) === 'kredi_kart' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 p-3 border rounded cursor-pointer" for="kredi_kart">
                                            <i class="bi bi-credit-card fs-4 text-primary d-block mb-2"></i>
                                            <strong>Kredi Kartı</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="odeme_yontemi"
                                               id="banka_havale"
                                               value="banka_havale"
                                               {{ old('odeme_yontemi', $tahsilat->odeme_yontemi) === 'banka_havale' ? 'checked' : '' }}>
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
                                               {{ old('odeme_yontemi', $tahsilat->odeme_yontemi) === 'cek' ? 'checked' : '' }}>
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
                                               id="sanal_pos"
                                               value="sanal_pos"
                                               {{ old('odeme_yontemi', $tahsilat->odeme_yontemi) === 'sanal_pos' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 p-3 border rounded cursor-pointer" for="sanal_pos">
                                            <i class="bi bi-phone fs-4 text-secondary d-block mb-2"></i>
                                            <strong>Sanal POS</strong>
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
                                            {{ old('kasa_banka_id', $tahsilat->kasa_banka_id) == $hesap->id ? 'selected' : '' }}>
                                        {{ $hesap->ad }}
                                        (Bakiye: {{ number_format(abs($hesap->bakiye), 2) }}₺)
                                    </option>
                                @endforeach
                            </select>
                            @error('kasa_banka_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Makbuz No --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-receipt me-2"></i>
                                Makbuz No
                            </label>
                            <input type="text"
                                   name="makbuz_no"
                                   class="form-control @error('makbuz_no') is-invalid @enderror"
                                   value="{{ old('makbuz_no', $tahsilat->makbuz_no) }}">
                            @error('makbuz_no')
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
                                      rows="3">{{ old('aciklama', $tahsilat->aciklama) }}</textarea>
                            @error('aciklama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Uyarı --}}
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Dikkat!</strong> Tahsilatı güncellerseniz:
                            <ul class="mb-0 mt-2">
                                <li>Mevcut cari kayıtlar silinecek</li>
                                <li>Yeni bilgilere göre cari kayıtlar oluşturulacak</li>
                                <li>Müşteri ve kasa bakiyeleri güncellenecek</li>
                            </ul>
                        </div>

                        {{-- Butonlar --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tahsilatlar.show', $tahsilat) }}" class="btn btn-secondary">
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
                        <small class="text-muted">Müşteri:</small>
                        <div class="fw-bold">{{ $tahsilat->musteriCari->customer->name ?? '-' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Tutar:</small>
                        <div class="fs-5 fw-bold text-success">{{ number_format($tahsilat->tutar, 2) }}₺</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Tarih:</small>
                        <div>{{ $tahsilat->tahsilat_tarihi->format('d.m.Y') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Ödeme Yöntemi:</small>
                        <div>{{ $tahsilat->odeme_yontemi_label }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Oluşturulma:</small>
                        <div class="small">{{ $tahsilat->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>

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
                        <a href="{{ route('tahsilatlar.show', $tahsilat) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye me-2"></i>Detay Görüntüle
                        </a>
                        @if($tahsilat->musteriCari)
                            <a href="{{ route('cari-hesaplar.show', $tahsilat->musteriCari) }}"
                               class="btn btn-sm btn-outline-info">
                                <i class="bi bi-journal-text me-2"></i>Müşteri Cari Ekstresi
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
