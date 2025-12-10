@extends('layouts.app')

@section('title', 'Yeni Poliçe Ekle')

@push('styles')
<style>
    .form-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .form-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .form-card .card-body {
        padding: 1.75rem;
    }

    .section-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #6c757d;
        font-size: 1.25rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-label .text-danger {
        font-weight: 600;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    .form-control:read-only,
    .form-control[readonly] {
        background-color: #f8f9fa;
        border-color: #e0e0e0;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .btn-primary.action-btn {
        border-color: #0d6efd;
    }

    .btn-primary.action-btn:hover {
        border-color: #0b5ed7;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.375rem;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
        display: block;
    }

    .info-badge {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .calculated-field {
        background: #f0f7ff;
        border-color: #b3d9ff;
        font-weight: 600;
        color: #0066cc;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 6px;
        font-size: 0.8125rem;
        color: #0066cc;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .form-card .card-body {
            padding: 1.25rem;
        }

        .form-header {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-10 col-lg-11 mx-auto">
            <!-- Header -->
            <div class="form-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 fw-bold text-dark">
                            <i class="bi bi-file-earmark-plus me-2"></i>Yeni Poliçe Ekle
                        </h1>
                        <p class="text-muted mb-0 small">Poliçe bilgilerini eksiksiz doldurun</p>
                    </div>
                    <a href="{{ route('policies.index') }}" class="btn btn-light action-btn">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('policies.store') }}" id="policyForm">
                @csrf

                <!-- Zorunlu Alan Bilgisi -->
                <div class="info-badge">
                    <i class="bi bi-info-circle me-2"></i>
                    <span class="text-danger fw-semibold">*</span> işaretli alanlar zorunludur.
                </div>

                <!-- Temel Bilgiler -->
                <div class="form-card card">
                    <div class="card-header">
                        <h5 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            <span>Temel Bilgiler</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Müşteri -->
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">
                                    Müşteri Seçimi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('customer_id') is-invalid @enderror"
                                        id="customer_id"
                                        name="customer_id"
                                        required>
                                    <option value="">Müşteri seçiniz</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                            {{ old('customer_id', $selectedCustomer?->id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} - {{ $customer->phone }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text">Poliçe sahibi müşteriyi seçin</small>
                                @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sigorta Şirketi -->
                            <div class="col-md-6">
                                <label for="insurance_company_id" class="form-label">
                                    Sigorta Şirketi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('insurance_company_id') is-invalid @enderror"
                                        id="insurance_company_id"
                                        name="insurance_company_id"
                                        required>
                                    <option value="">Sigorta şirketi seçiniz</option>
                                    @foreach($insuranceCompanies as $company)
                                    <option value="{{ $company->id }}"
                                            data-kasko="{{ $company->default_commission_kasko }}"
                                            data-trafik="{{ $company->default_commission_trafik }}"
                                            data-konut="{{ $company->default_commission_konut }}"
                                            data-dask="{{ $company->default_commission_dask }}"
                                            data-saglik="{{ $company->default_commission_saglik }}"
                                            data-hayat="{{ $company->default_commission_hayat }}"
                                            data-tss="{{ $company->default_commission_tss }}"
                                            {{ old('insurance_company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('insurance_company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Poliçe Numarası -->
                            <div class="col-md-6">
                                <label for="policy_number" class="form-label">
                                    Poliçe Numarası <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('policy_number') is-invalid @enderror"
                                       id="policy_number"
                                       name="policy_number"
                                       value="{{ old('policy_number') }}"
                                       placeholder="Örn: POL-2025-001234"
                                       required>
                                <small class="form-text">Sigorta şirketinin verdiği poliçe numarası</small>
                                @error('policy_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Poliçe Türü -->
                            <div class="col-md-6">
                                <label for="policy_type" class="form-label">
                                    Poliçe Türü <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('policy_type') is-invalid @enderror"
                                        id="policy_type"
                                        name="policy_type"
                                        required>
                                    <option value="">Poliçe türü seçiniz</option>
                                    <option value="kasko" {{ old('policy_type') === 'kasko' ? 'selected' : '' }}>Kasko Sigortası</option>
                                    <option value="trafik" {{ old('policy_type') === 'trafik' ? 'selected' : '' }}>Trafik Sigortası</option>
                                    <option value="konut" {{ old('policy_type') === 'konut' ? 'selected' : '' }}>Konut Sigortası</option>
                                    <option value="dask" {{ old('policy_type') === 'dask' ? 'selected' : '' }}>DASK</option>
                                    <option value="saglik" {{ old('policy_type') === 'saglik' ? 'selected' : '' }}>Sağlık Sigortası</option>
                                    <option value="hayat" {{ old('policy_type') === 'hayat' ? 'selected' : '' }}>Hayat Sigortası</option>
                                    <option value="tss" {{ old('policy_type') === 'tss' ? 'selected' : '' }}>Tamamlayıcı Sağlık</option>
                                </select>
                                @error('policy_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Başlangıç Tarihi -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">
                                    Başlangıç Tarihi <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       id="start_date"
                                       name="start_date"
                                       value="{{ old('start_date', now()->format('Y-m-d')) }}"
                                       required>
                                <small class="form-text">Poliçenin yürürlüğe giriş tarihi</small>
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bitiş Tarihi -->
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">
                                    Bitiş Tarihi <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       id="end_date"
                                       name="end_date"
                                       value="{{ old('end_date', now()->addYear()->format('Y-m-d')) }}"
                                       required>
                                <small class="form-text">Poliçenin bitiş tarihi (genellikle 1 yıl sonra)</small>
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Araç Bilgileri (Dinamik) -->
                <div class="form-card card" id="vehicleSection" style="display: none;">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="section-title">
                                <i class="bi bi-car-front"></i>
                                <span>Araç Bilgileri</span>
                            </h5>
                            <span class="section-badge">
                                <i class="bi bi-car-front-fill"></i>
                                Kasko/Trafik
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="vehicle_plate" class="form-label">
                                    Plaka <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('vehicle_plate') is-invalid @enderror"
                                       id="vehicle_plate"
                                       name="vehicle_plate"
                                       value="{{ old('vehicle_plate') }}"
                                       placeholder="34 ABC 1234">
                                @error('vehicle_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="vehicle_brand" class="form-label">Marka</label>
                                <input type="text"
                                       class="form-control"
                                       id="vehicle_brand"
                                       name="vehicle_brand"
                                       value="{{ old('vehicle_brand') }}"
                                       placeholder="Örn: Toyota">
                            </div>

                            <div class="col-md-3">
                                <label for="vehicle_model" class="form-label">Model</label>
                                <input type="text"
                                       class="form-control"
                                       id="vehicle_model"
                                       name="vehicle_model"
                                       value="{{ old('vehicle_model') }}"
                                       placeholder="Örn: Corolla">
                            </div>

                            <div class="col-md-3">
                                <label for="vehicle_year" class="form-label">Model Yılı</label>
                                <input type="number"
                                       class="form-control"
                                       id="vehicle_year"
                                       name="vehicle_year"
                                       value="{{ old('vehicle_year', date('Y')) }}"
                                       min="1900"
                                       max="{{ date('Y') + 1 }}"
                                       placeholder="{{ date('Y') }}">
                            </div>

                            <div class="col-md-12">
                                <label for="vehicle_chassis_no" class="form-label">Şasi Numarası</label>
                                <input type="text"
                                       class="form-control"
                                       id="vehicle_chassis_no"
                                       name="vehicle_chassis_no"
                                       value="{{ old('vehicle_chassis_no') }}"
                                       placeholder="17 haneli şasi numarası">
                                <small class="form-text">Araç ruhsatında yazan şasi numarası</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konut Bilgileri (Dinamik) -->
                <div class="form-card card" id="propertySection" style="display: none;">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="section-title">
                                <i class="bi bi-house"></i>
                                <span>Konut Bilgileri</span>
                            </h5>
                            <span class="section-badge">
                                <i class="bi bi-house-fill"></i>
                                Konut/DASK
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="property_address" class="form-label">
                                    Konut Adresi <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('property_address') is-invalid @enderror"
                                          id="property_address"
                                          name="property_address"
                                          rows="3"
                                          placeholder="Mahalle, sokak, cadde, bina no, daire no">{{ old('property_address') }}</textarea>
                                <small class="form-text">Sigortalı konutun tam adresi</small>
                                @error('property_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="property_area" class="form-label">Brüt Alan (m²)</label>
                                <input type="number"
                                       class="form-control"
                                       id="property_area"
                                       name="property_area"
                                       value="{{ old('property_area') }}"
                                       step="0.01"
                                       placeholder="Örn: 120.50">
                                <small class="form-text">Konutun brüt kullanım alanı</small>
                            </div>

                            <div class="col-md-6">
                                <label for="property_floor" class="form-label">Kat Numarası</label>
                                <input type="number"
                                       class="form-control"
                                       id="property_floor"
                                       name="property_floor"
                                       value="{{ old('property_floor') }}"
                                       placeholder="Örn: 3">
                                <small class="form-text">Konutun bulunduğu kat</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ödeme Bilgileri -->
                <div class="form-card card">
                    <div class="card-header">
                        <h5 class="section-title">
                            <i class="bi bi-cash-stack"></i>
                            <span>Ödeme ve Komisyon Bilgileri</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Prim Tutarı -->
                            <div class="col-md-4">
                                <label for="premium_amount" class="form-label">
                                    Prim Tutarı (₺) <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control @error('premium_amount') is-invalid @enderror"
                                       id="premium_amount"
                                       name="premium_amount"
                                       value="{{ old('premium_amount') }}"
                                       step="0.01"
                                       placeholder="0.00"
                                       required>
                                <small class="form-text">Toplam prim bedeli</small>
                                @error('premium_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Komisyon Oranı -->
                            <div class="col-md-4">
                                <label for="commission_rate" class="form-label">
                                    Komisyon Oranı (%)
                                </label>
                                <input type="number"
                                       class="form-control calculated-field"
                                       id="commission_rate"
                                       name="commission_rate"
                                       value="{{ old('commission_rate') }}"
                                       step="0.01"
                                       readonly>
                                <small class="form-text">
                                    <i class="bi bi-calculator me-1"></i>Otomatik hesaplanır
                                </small>
                            </div>

                            <!-- Komisyon Tutarı -->
                            <div class="col-md-4">
                                <label class="form-label">Komisyon Tutarı (₺)</label>
                                <input type="text"
                                       class="form-control calculated-field"
                                       id="commission_amount_display"
                                       readonly
                                       value="0.00">
                                <small class="form-text">
                                    <i class="bi bi-calculator me-1"></i>Otomatik hesaplanır
                                </small>
                            </div>

                            <!-- Ödeme Tipi -->
                            <div class="col-md-6">
                                <label for="payment_type" class="form-label">
                                    Ödeme Şekli <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('payment_type') is-invalid @enderror"
                                        id="payment_type"
                                        name="payment_type"
                                        required>
                                    <option value="cash" {{ old('payment_type', 'cash') === 'cash' ? 'selected' : '' }}>
                                        Peşin Ödeme
                                    </option>
                                    <option value="installment" {{ old('payment_type') === 'installment' ? 'selected' : '' }}>
                                        Taksitli Ödeme
                                    </option>
                                </select>
                                @error('payment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Taksit Sayısı -->
                            <div class="col-md-6" id="installmentCountDiv" style="display: none;">
                                <label for="installment_count" class="form-label">
                                    Taksit Sayısı
                                </label>
                                <select class="form-select" id="installment_count" name="installment_count">
                                    <option value="2">2 Taksit</option>
                                    <option value="3">3 Taksit</option>
                                    <option value="4">4 Taksit</option>
                                    <option value="6" selected>6 Taksit</option>
                                    <option value="9">9 Taksit</option>
                                    <option value="12">12 Taksit</option>
                                </select>
                                <small class="form-text">Ödeme kaç taksit olarak yapılacak</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notlar -->
                <div class="form-card card">
                    <div class="card-header">
                        <h5 class="section-title">
                            <i class="bi bi-sticky"></i>
                            <span>Ek Notlar</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control"
                                  id="notes"
                                  name="notes"
                                  rows="4"
                                  placeholder="Poliçe ile ilgili önemli notlar, özel şartlar veya hatırlatmalar...">{{ old('notes') }}</textarea>
                        <small class="form-text">Bu notlar sadece sizin ve ekibiniz tarafından görülebilir</small>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Tüm bilgiler güvenli bir şekilde saklanmaktadır
                    </small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('policies.index') }}" class="btn btn-light action-btn">
                            <i class="bi bi-x-circle me-2"></i>İptal
                        </a>
                        <button type="submit" class="btn btn-primary action-btn">
                            <i class="bi bi-check-circle me-2"></i>Poliçeyi Kaydet
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Poliçe türüne göre dinamik bölümleri göster/gizle
    $('#policy_type').on('change', function() {
        const type = $(this).val();

        // Tüm dinamik bölümleri gizle ve zorunluluğu kaldır
        $('#vehicleSection, #propertySection').hide();
        $('#vehicle_plate, #property_address').attr('required', false);

        // Araç poliçeleri için
        if (type === 'kasko' || type === 'trafik') {
            $('#vehicleSection').slideDown(300);
            $('#vehicle_plate').attr('required', true);
        }

        // Konut poliçeleri için
        if (type === 'konut' || type === 'dask') {
            $('#propertySection').slideDown(300);
            $('#property_address').attr('required', true);
        }

        // Komisyon oranını güncelle
        updateCommissionRate();
    });

    // Ödeme tipine göre taksit sayısını göster/gizle
    $('#payment_type').on('change', function() {
        if ($(this).val() === 'installment') {
            $('#installmentCountDiv').slideDown(300);
        } else {
            $('#installmentCountDiv').slideUp(300);
            $('#installment_count').val('1');
        }
    });

    // Komisyon oranını otomatik güncelle
    function updateCommissionRate() {
        const companyId = $('#insurance_company_id').val();
        const policyType = $('#policy_type').val();

        if (companyId && policyType) {
            const company = $('#insurance_company_id option:selected');
            const rate = company.data(policyType);

            if (rate !== undefined && rate !== null) {
                $('#commission_rate').val(rate);
                calculateCommission();
            } else {
                $('#commission_rate').val('0');
                $('#commission_amount_display').val('0.00');
            }
        }
    }

    // Komisyon tutarını hesapla
    function calculateCommission() {
        const premium = parseFloat($('#premium_amount').val()) || 0;
        const rate = parseFloat($('#commission_rate').val()) || 0;
        const commission = (premium * rate) / 100;

        $('#commission_amount_display').val(commission.toFixed(2));
    }

    // Event listeners
    $('#insurance_company_id, #policy_type').on('change', updateCommissionRate);
    $('#premium_amount, #commission_rate').on('input', calculateCommission);

    // Başlangıç tarihine göre bitiş tarihini otomatik ayarla
    $('#start_date').on('change', function() {
        const startDate = new Date($(this).val());
        if (!isNaN(startDate)) {
            const endDate = new Date(startDate);
            endDate.setFullYear(endDate.getFullYear() + 1);
            endDate.setDate(endDate.getDate() - 1); // 1 gün eksilt (tam 1 yıl için)

            $('#end_date').val(endDate.toISOString().split('T')[0]);
        }
    });

    // Plaka formatı - büyük harf
    $('#vehicle_plate').on('input', function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
    });

    // Şasi numarası formatı - büyük harf ve rakam
    $('#vehicle_chassis_no').on('input', function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
    });

    // Form validasyonu
    $('#policyForm').on('submit', function(e) {
        const policyType = $('#policy_type').val();
        let isValid = true;
        let errorMessage = '';

        // Poliçe türü kontrolü
        if (!policyType) {
            isValid = false;
            errorMessage = 'Lütfen poliçe türünü seçiniz.';
            $('#policy_type').addClass('is-invalid').focus();
        }

        // Araç poliçesi kontrolü
        if ((policyType === 'kasko' || policyType === 'trafik') && !$('#vehicle_plate').val().trim()) {
            isValid = false;
            errorMessage = 'Lütfen plaka bilgisini giriniz.';
            $('#vehicle_plate').addClass('is-invalid').focus();
        }

        // Konut poliçesi kontrolü
        if ((policyType === 'konut' || policyType === 'dask') && !$('#property_address').val().trim()) {
            isValid = false;
            errorMessage = 'Lütfen konut adres bilgisini giriniz.';
            $('#property_address').addClass('is-invalid').focus();
        }

        // Prim tutarı kontrolü
        const premiumAmount = parseFloat($('#premium_amount').val());
        if (!premiumAmount || premiumAmount <= 0) {
            isValid = false;
            errorMessage = 'Lütfen geçerli bir prim tutarı giriniz.';
            $('#premium_amount').addClass('is-invalid').focus();
        }

        // Tarih kontrolü
        const startDate = new Date($('#start_date').val());
        const endDate = new Date($('#end_date').val());
        if (endDate <= startDate) {
            isValid = false;
            errorMessage = 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır.';
            $('#end_date').addClass('is-invalid').focus();
        }

        if (!isValid) {
            e.preventDefault();

            // Modern alert
            const alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                     style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Hata!</strong> ${errorMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('body').append(alertHtml);

            setTimeout(function() {
                $('.alert').fadeOut(300, function() { $(this).remove(); });
            }, 5000);

            return false;
        }

        // Form gönderiliyor animasyonu
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Kaydediliyor...');
    });

    // Input focus'ta invalid class'ını kaldır
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });

    // Sayfa yüklendiğinde ödeme tipini kontrol et
    if ($('#payment_type').val() === 'installment') {
        $('#installmentCountDiv').show();
    }

    // İlk yüklemede poliçe türü varsa ilgili bölümü göster
    const initialPolicyType = $('#policy_type').val();
    if (initialPolicyType) {
        $('#policy_type').trigger('change');
    }

    // İlk alana focus
    $('#customer_id').focus();
});
</script>
@endpush
