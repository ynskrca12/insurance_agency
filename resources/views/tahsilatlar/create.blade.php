@extends('layouts.app')

@section('title', 'Yeni Tahsilat')

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
                        <i class="bi bi-cash-coin me-2"></i>
                        Yeni Tahsilat
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Form Bölümü --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Tahsilat Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tahsilatlar.store') }}" method="POST" id="tahsilatForm">
                        @csrf

                        {{-- Müşteri Seçimi --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-person-circle me-2"></i>
                                Müşteri Seçin *
                            </label>
                            <select name="customer_id"
                                    id="customerSelect"
                                    class="form-select form-select-lg @error('customer_id') is-invalid @enderror"
                                    required>
                                <option value="">Müşteri seçiniz...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                            data-cari-kod="{{ $customer->cariHesap->kod ?? '' }}"
                                            data-bakiye="{{ $customer->cariHesap->bakiye ?? 0 }}"
                                            data-phone="{{ $customer->phone }}"
                                            {{ old('customer_id', request('customer_id')) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} - {{ $customer->phone }}
                                        @if($customer->cariHesap)
                                            (Bakiye: {{ number_format(abs($customer->cariHesap->bakiye), 2) }}₺)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                   placeholder="0.00"
                                   value="{{ old('tutar') }}"
                                   required>
                            @error('tutar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                   value="{{ old('tahsilat_tarihi', now()->format('Y-m-d')) }}"
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
                                               {{ old('odeme_yontemi', 'nakit') === 'nakit' ? 'checked' : '' }}
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
                                               {{ old('odeme_yontemi') === 'kredi_kart' ? 'checked' : '' }}>
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
                                               {{ old('odeme_yontemi') === 'banka_havale' ? 'checked' : '' }}>
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
                                               id="sanal_pos"
                                               value="sanal_pos"
                                               {{ old('odeme_yontemi') === 'sanal_pos' ? 'checked' : '' }}>
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
                                    <option value="{{ $hesap->id }}" {{ old('kasa_banka_id') == $hesap->id ? 'selected' : '' }}>
                                        <i class="bi bi-{{ $hesap->tip === 'kasa' ? 'safe' : 'bank' }}"></i>
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
                                   placeholder="MKB-2025-001"
                                   value="{{ old('makbuz_no') }}">
                            @error('makbuz_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Boş bırakılırsa otomatik numara verilir</small>
                        </div>

                        {{-- Poliçe İlişkilendirme (Opsiyonel) --}}
                        <div class="mb-3" id="policySection" style="display: none;">
                            <label class="form-label">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                İlgili Poliçe (Opsiyonel)
                            </label>
                            <select name="policy_id" id="policySelect" class="form-select">
                                <option value="">Tüm borç için tahsilat</option>
                            </select>
                            <small class="text-muted">Poliçe seçilirse sadece o poliçeye tahsilat yapılır</small>

                            {{-- Poliçe Detay Kartı --}}
                            <div id="policyDetailCard" class="card mt-3" style="display: none;">
                                <div class="card-body p-3 bg-light">
                                    <div class="row g-2 small">
                                        <div class="col-md-6">
                                            <strong>Toplam Tutar:</strong>
                                            <span id="policyToplamTutar" class="text-primary">0.00₺</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Ödenen:</strong>
                                            <span id="policyOdenenTutar" class="text-success">0.00₺</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Kalan:</strong>
                                            <span id="policyKalanTutar" class="text-danger fw-bold">0.00₺</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Sigorta Şirketi:</strong>
                                            <span id="policyCompany">-</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 w-100" id="fillKalanBtn">
                                        <i class="bi bi-arrow-down-circle me-1"></i>
                                        Kalan Tutarı Tahsilat Alanına Aktar
                                    </button>
                                </div>
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
                                      placeholder="Tahsilat hakkında notlar...">{{ old('aciklama') }}</textarea>
                            @error('aciklama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Butonlar --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tahsilatlar.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>İptal
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Tahsilatı Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bilgi Paneli --}}
        <div class="col-lg-4">
            {{-- Müşteri Bilgi Kartı --}}
            <div class="card mb-3" id="customerInfoCard" style="display: none;">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Müşteri Bilgileri
                    </h6>
                </div>
                <div class="card-body">
                    <div id="customerInfo">
                        <div class="mb-2">
                            <small class="text-muted">Cari Kod:</small>
                            <div id="customerCariKod" class="fw-bold">-</div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Telefon:</small>
                            <div id="customerPhone">-</div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Mevcut Borç:</small>
                            <div id="customerBakiye" class="fs-4 fw-bold text-danger">0.00₺</div>
                        </div>
                        <a href="#" id="customerEkstreLink" class="btn btn-sm btn-outline-primary w-100" target="_blank">
                            <i class="bi bi-file-text me-2"></i>Cari Ekstre
                        </a>
                    </div>
                </div>
            </div>

            {{-- Yardım Kartı --}}
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Bilgi
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Müşteri seçildikten sonra mevcut borç bilgisi görüntülenir
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Kısmi ödemeler yapılabilir
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Tahsilat sonrası otomatik cari kayıt oluşturulur
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Seçilen kasa/banka hesabına otomatik giriş yapılır
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Poliçe Dökümü Kartı --}}
            <div class="card mb-3" id="policyListCard" style="display: none;">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-list-check me-2"></i>
                        Açık Poliçeler
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Poliçe No</th>
                                    <th class="text-end">Kalan</th>
                                </tr>
                            </thead>
                            <tbody id="policyListBody">
                                <!-- AJAX ile doldurulacak -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Müşteri seçildiğinde bilgileri göster
    document.getElementById('customerSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            const cariKod = selectedOption.getAttribute('data-cari-kod');
            const bakiye = parseFloat(selectedOption.getAttribute('data-bakiye'));
            const phone = selectedOption.getAttribute('data-phone');

            // Bilgileri göster
            document.getElementById('customerCariKod').textContent = cariKod;
            document.getElementById('customerPhone').textContent = phone;
            document.getElementById('customerBakiye').textContent =
                new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(Math.abs(bakiye));

            // Ekstre linki
            document.getElementById('customerEkstreLink').href = '/cari-hesaplar/' + cariKod;

            // Kartı göster
            document.getElementById('customerInfoCard').style.display = 'block';
        } else {
            // Kartı gizle
            document.getElementById('customerInfoCard').style.display = 'none';
        }
    });

    // Sayfa yüklendiğinde seçili müşteri varsa bilgileri göster
    window.addEventListener('load', function() {
        const customerSelect = document.getElementById('customerSelect');
        if (customerSelect.value) {
            customerSelect.dispatchEvent(new Event('change'));
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

<script>
    let customerPolicies = [];

    // Müşteri seçildiğinde bilgileri göster VE poliçeleri yükle
    document.getElementById('customerSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const customerId = this.value;

        if (customerId) {
            const cariKod = selectedOption.getAttribute('data-cari-kod');
            const bakiye = parseFloat(selectedOption.getAttribute('data-bakiye'));
            const phone = selectedOption.getAttribute('data-phone');

            // Bilgileri göster
            document.getElementById('customerCariKod').textContent = cariKod;
            document.getElementById('customerPhone').textContent = phone;
            document.getElementById('customerBakiye').textContent =
                new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(Math.abs(bakiye));

            // Ekstre linki
            document.getElementById('customerEkstreLink').href = '/cari-hesaplar/' + cariKod;

            // Kartı göster
            document.getElementById('customerInfoCard').style.display = 'block';

            // Poliçeleri yükle
            loadCustomerPolicies(customerId);
        } else {
            // Kartı gizle
            document.getElementById('customerInfoCard').style.display = 'none';
            document.getElementById('policySection').style.display = 'none';
            document.getElementById('policyDetailCard').style.display = 'none';
        }
    });

    // Müşteriye ait poliçeleri AJAX ile yükle
    function loadCustomerPolicies(customerId) {
        const policySelect = document.getElementById('policySelect');
        const policySection = document.getElementById('policySection');

        // Loading göster
        policySelect.innerHTML = '<option value="">Poliçeler yükleniyor...</option>';
        policySection.style.display = 'block';

        fetch(`/tahsilatlar/customer-policies/${customerId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.policies.length > 0) {
                    customerPolicies = data.policies;

                    // Poliçeleri dropdown'a ekle
                    policySelect.innerHTML = '<option value="">Tüm borç için tahsilat (Toplam: ' +
                        data.policies.reduce((sum, p) => sum + parseFloat(p.kalan_tutar), 0).toFixed(2) + '₺)</option>';

                    data.policies.forEach(policy => {
                        // Sadece kalan tutarı olan poliçeleri göster
                        if (parseFloat(policy.kalan_tutar) > 0) {
                            const option = document.createElement('option');
                            option.value = policy.id;
                            option.textContent = `${policy.policy_number} - ${policy.insurance_type} (Kalan: ${policy.kalan_tutar_formatted})`;
                            option.dataset.policy = JSON.stringify(policy);
                            policySelect.appendChild(option);
                        }
                    });

                    policySection.style.display = 'block';
                } else {
                    policySelect.innerHTML = '<option value="">Bu müşterinin açık borcu yok</option>';
                    policySection.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Poliçeler yüklenirken hata:', error);
                policySelect.innerHTML = '<option value="">Poliçeler yüklenemedi</option>';
            });
    }

    // Poliçe listesini yan panelde göster
    function updatePolicyList() {
        const policyListBody = document.getElementById('policyListBody');
        const policyListCard = document.getElementById('policyListCard');

        if (customerPolicies.length > 0) {
            policyListBody.innerHTML = '';
            let hasOpenPolicies = false;

            customerPolicies.forEach(policy => {
                if (parseFloat(policy.kalan_tutar) > 0) {
                    hasOpenPolicies = true;
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="small">${policy.policy_number}</td>
                        <td class="text-end small fw-bold text-danger">${policy.kalan_tutar_formatted}</td>
                    `;
                    policyListBody.appendChild(row);
                }
            });

            if (hasOpenPolicies) {
                policyListCard.style.display = 'block';
            } else {
                policyListCard.style.display = 'none';
            }
        } else {
            policyListCard.style.display = 'none';
        }
    }

    updatePolicyList();

    // Poliçe seçildiğinde detayları göster
    document.getElementById('policySelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const policyDetailCard = document.getElementById('policyDetailCard');

        if (this.value && selectedOption.dataset.policy) {
            const policy = JSON.parse(selectedOption.dataset.policy);

            // Detayları göster
            document.getElementById('policyToplamTutar').textContent =
                parseFloat(policy.toplam_tutar).toLocaleString('tr-TR', {minimumFractionDigits: 2}) + '₺';
            document.getElementById('policyOdenenTutar').textContent =
                parseFloat(policy.odenen_tutar).toLocaleString('tr-TR', {minimumFractionDigits: 2}) + '₺';
            document.getElementById('policyKalanTutar').textContent =
                parseFloat(policy.kalan_tutar).toLocaleString('tr-TR', {minimumFractionDigits: 2}) + '₺';
            document.getElementById('policyCompany').textContent = policy.insurance_company;

            policyDetailCard.style.display = 'block';
        } else {
            policyDetailCard.style.display = 'none';
        }
    });

    // Kalan tutarı tahsilat alanına aktar butonu
    document.getElementById('fillKalanBtn').addEventListener('click', function() {
        const policySelect = document.getElementById('policySelect');
        const selectedOption = policySelect.options[policySelect.selectedIndex];

        if (policySelect.value && selectedOption.dataset.policy) {
            const policy = JSON.parse(selectedOption.dataset.policy);
            document.querySelector('input[name="tutar"]').value = parseFloat(policy.kalan_tutar).toFixed(2);

            // Görsel feedback
            this.innerHTML = '<i class="bi bi-check-circle me-1"></i> Aktarıldı!';
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-success');

            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-arrow-down-circle me-1"></i> Kalan Tutarı Tahsilat Alanına Aktar';
                this.classList.remove('btn-success');
                this.classList.add('btn-outline-primary');
            }, 1500);
        }
    });

    // Sayfa yüklendiğinde seçili müşteri varsa bilgileri göster
    window.addEventListener('load', function() {
        const customerSelect = document.getElementById('customerSelect');
        if (customerSelect.value) {
            customerSelect.dispatchEvent(new Event('change'));
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
