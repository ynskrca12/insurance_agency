@extends('layouts.app')

@section('title', 'Yeni Şirket Ödemesi')

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
                        <i class="bi bi-bank me-2"></i>
                        Yeni Şirket Ödemesi
                    </h2>
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
                        Ödeme Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sirket-odemeleri.store') }}" method="POST" id="odemeForm">
                        @csrf

                        {{-- Şirket Seçimi --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-building me-2"></i>
                                Sigorta Şirketi Seçin *
                            </label>
                            <select name="insurance_company_id"
                                    id="companySelect"
                                    class="form-select form-select-lg @error('insurance_company_id') is-invalid @enderror"
                                    required>
                                <option value="">Şirket seçiniz...</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                            data-cari-kod="{{ $company->cariHesap->kod ?? '' }}"
                                            data-bakiye="{{ $company->cariHesap->bakiye ?? 0 }}"
                                            data-code="{{ $company->code }}"
                                            {{ old('insurance_company_id', request('insurance_company_id')) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                        @if($company->cariHesap && $company->cariHesap->bakiye < 0)
                                            (Borç: {{ number_format(abs($company->cariHesap->bakiye), 2) }}₺)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('insurance_company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                   placeholder="0.00"
                                   value="{{ old('tutar') }}"
                                   required>
                            @error('tutar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                   value="{{ old('odeme_tarihi', now()->format('Y-m-d')) }}"
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
                                               {{ old('odeme_yontemi', 'banka_havale') === 'banka_havale' ? 'checked' : '' }}
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
                                               {{ old('odeme_yontemi') === 'cek' ? 'checked' : '' }}>
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
                                               {{ old('odeme_yontemi') === 'nakit' ? 'checked' : '' }}>
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
                                    <option value="{{ $hesap->id }}" {{ old('kasa_banka_id') == $hesap->id ? 'selected' : '' }}>
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
                                   placeholder="DKT-2025-001"
                                   value="{{ old('dekont_no') }}">
                            @error('dekont_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Boş bırakılırsa otomatik numara verilir</small>
                        </div>

                        {{-- Poliçe İlişkilendirme --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                İlgili Poliçeler (Opsiyonel)
                            </label>
                            <div id="policiesContainer" style="display: none;">
                                <div class="list-group mb-2" id="policiesList">
                                    {{-- AJAX ile yüklenecek --}}
                                </div>
                                <small class="text-muted">Ödeme yapılacak poliçeleri seçebilirsiniz</small>
                            </div>
                            <div id="policiesLoading" style="display: none;">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <small class="text-muted">Poliçeler yükleniyor...</small>
                            </div>
                        </div>

                        {{-- Açıklama --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-chat-left-text me-2"></i>
                                Açıklama
                            </label>
                            <textarea name="aciklama"
                                      class="form-control @error('aciklama') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Ödeme hakkında notlar...">{{ old('aciklama') }}</textarea>
                            @error('aciklama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Butonlar --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sirket-odemeleri.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>İptal
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Ödemeyi Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bilgi Paneli --}}
        <div class="col-lg-4">
            {{-- Şirket Bilgi Kartı --}}
            <div class="card mb-3" id="companyInfoCard" style="display: none;">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        Şirket Bilgileri
                    </h6>
                </div>
                <div class="card-body">
                    <div id="companyInfo">
                        <div class="mb-2">
                            <small class="text-muted">Cari Kod:</small>
                            <div id="companyCariKod" class="fw-bold">-</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Şirket Kodu:</small>
                            <div id="companyCode">-</div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Mevcut Borç:</small>
                            <div id="companyBakiye" class="fs-4 fw-bold text-danger">0.00₺</div>
                        </div>
                        <a href="#" id="companyEkstreLink" class="btn btn-sm btn-outline-primary w-100" target="_blank">
                            <i class="bi bi-file-text me-2"></i>Cari Ekstre
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bekleyen Poliçeler Kartı --}}
            <div class="card mb-3" id="bekleyenPolicelerCard" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Bekleyen Poliçeler
                    </h6>
                </div>
                <div class="card-body" id="bekleyenPolicelerContent">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>

            {{-- Yardım Kartı --}}
            <div class="card border-warning">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Bilgi
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Şirket seçildikten sonra borç bilgisi görüntülenir
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Toplu ödeme yapılabilir (birden fazla poliçe)
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Ödeme sonrası otomatik cari kayıt oluşturulur
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Seçilen kasa/banka hesabından otomatik çıkış yapılır
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Şirket seçildiğinde bilgileri göster
    document.getElementById('companySelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            const cariKod = selectedOption.getAttribute('data-cari-kod');
            const bakiye = parseFloat(selectedOption.getAttribute('data-bakiye'));
            const code = selectedOption.getAttribute('data-code');

            // Bilgileri göster
            document.getElementById('companyCariKod').textContent = cariKod;
            document.getElementById('companyCode').textContent = code;
            document.getElementById('companyBakiye').textContent =
                new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(Math.abs(bakiye));

            // Ekstre linki
            document.getElementById('companyEkstreLink').href = '/cari-hesaplar/' + cariKod;

            // Kartı göster
            document.getElementById('companyInfoCard').style.display = 'block';

            // Bekleyen poliçeleri yükle (Opsiyonel - AJAX ile)
            loadPendingPolicies(this.value);
        } else {
            // Kartları gizle
            document.getElementById('companyInfoCard').style.display = 'none';
            document.getElementById('bekleyenPolicelerCard').style.display = 'none';
        }
    });

    // Bekleyen poliçeleri yükle (AJAX - opsiyonel)
    function loadPendingPolicies(companyId) {
        // Bu fonksiyon ileride implement edilebilir
        // Şimdilik basit bir mesaj göster
        document.getElementById('bekleyenPolicelerCard').style.display = 'block';
        document.getElementById('bekleyenPolicelerContent').innerHTML =
            '<p class="text-muted mb-0 small">Bu şirkete ait bekleyen poliçeler burada listelenecek</p>';
    }

    // Sayfa yüklendiğinde seçili şirket varsa bilgileri göster
    window.addEventListener('load', function() {
        const companySelect = document.getElementById('companySelect');
        if (companySelect.value) {
            companySelect.dispatchEvent(new Event('change'));
        }
    });

    // Ödeme yöntemi seçiminde görsel feedback
    document.querySelectorAll('input[name="odeme_yontemi"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.form-check-label').forEach(label => {
                label.classList.remove('border-primary', 'bg-light');
            });
            this.nextElementSibling.classList.add('border-primary', 'bg-light');
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
