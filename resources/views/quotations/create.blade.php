@extends('layouts.app')

@section('title', 'Yeni Teklif Oluştur')

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

    .info-badge {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: #6c757d;
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

    .company-item {
        background: #fafafa;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .company-item:hover {
        background: #f5f5f5;
        border-color: #d0d0d0;
    }

    .company-item-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e8e8e8;
    }

    .company-item-number {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .remove-item-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 2rem;
        height: 2rem;
        border-radius: 6px;
        border: 1px solid #dc3545;
        background: #ffffff;
        color: #dc3545;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-item-btn:hover {
        background: #dc3545;
        color: #ffffff;
        transform: scale(1.1);
    }

    .form-check-input {
        width: 2.5rem;
        height: 1.25rem;
        border: 1px solid #dcdcdc;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
    }

    .add-company-btn {
        border: 2px dashed #b0b0b0;
        background: #ffffff;
        color: #6c757d;
        border-radius: 10px;
        padding: 1rem;
        width: 100%;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .add-company-btn:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        .form-card .card-body {
            padding: 1.25rem;
        }

        .company-item {
            padding: 1.25rem;
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
                            <i class="bi bi-file-earmark-plus me-2"></i>Yeni Teklif Oluştur
                        </h1>
                        <p class="text-muted mb-0 small">Müşteri için karşılaştırmalı teklif hazırlayın</p>
                    </div>
                    <a href="{{ route('quotations.index') }}" class="btn btn-light action-btn">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('quotations.store') }}" id="quotationForm">
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
                                <small class="form-text">Teklif hazırlanacak müşteriyi seçin</small>
                                @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teklif Türü -->
                            <div class="col-md-3">
                                <label for="quotation_type" class="form-label">
                                    Teklif Türü <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('quotation_type') is-invalid @enderror"
                                        id="quotation_type"
                                        name="quotation_type"
                                        required>
                                    <option value="">Tür seçiniz</option>
                                    <option value="kasko" {{ old('quotation_type') === 'kasko' ? 'selected' : '' }}>Kasko</option>
                                    <option value="trafik" {{ old('quotation_type') === 'trafik' ? 'selected' : '' }}>Trafik</option>
                                    <option value="konut" {{ old('quotation_type') === 'konut' ? 'selected' : '' }}>Konut</option>
                                    <option value="dask" {{ old('quotation_type') === 'dask' ? 'selected' : '' }}>DASK</option>
                                    <option value="saglik" {{ old('quotation_type') === 'saglik' ? 'selected' : '' }}>Sağlık</option>
                                    <option value="hayat" {{ old('quotation_type') === 'hayat' ? 'selected' : '' }}>Hayat</option>
                                    <option value="tss" {{ old('quotation_type') === 'tss' ? 'selected' : '' }}>TSS</option>
                                </select>
                                @error('quotation_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Geçerlilik Tarihi -->
                            <div class="col-md-3">
                                <label for="valid_until" class="form-label">
                                    Geçerlilik Tarihi <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control @error('valid_until') is-invalid @enderror"
                                       id="valid_until"
                                       name="valid_until"
                                       value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}"
                                       required>
                                <small class="form-text">Teklifin geçerli olacağı son tarih</small>
                                @error('valid_until')
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
                                <label class="form-label">Plaka</label>
                                <input type="text"
                                       class="form-control"
                                       name="vehicle_info[plate]"
                                       placeholder="34 ABC 1234"
                                       value="{{ old('vehicle_info.plate') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Marka</label>
                                <input type="text"
                                       class="form-control"
                                       name="vehicle_info[brand]"
                                       placeholder="Örn: Toyota"
                                       value="{{ old('vehicle_info.brand') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Model</label>
                                <input type="text"
                                       class="form-control"
                                       name="vehicle_info[model]"
                                       placeholder="Örn: Corolla"
                                       value="{{ old('vehicle_info.model') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Model Yılı</label>
                                <input type="number"
                                       class="form-control"
                                       name="vehicle_info[year]"
                                       value="{{ old('vehicle_info.year', date('Y')) }}"
                                       min="1900"
                                       max="{{ date('Y') + 1 }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Şasi Numarası</label>
                                <input type="text"
                                       class="form-control"
                                       name="vehicle_info[chassis]"
                                       placeholder="17 haneli şasi numarası"
                                       value="{{ old('vehicle_info.chassis') }}">
                                <small class="form-text">İsteğe bağlı - Detaylı teklif için gerekli</small>
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
                                <label class="form-label">Konut Adresi</label>
                                <textarea class="form-control"
                                          name="property_info[address]"
                                          rows="3"
                                          placeholder="Mahalle, sokak, cadde, bina no, daire no">{{ old('property_info.address') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Brüt Alan (m²)</label>
                                <input type="number"
                                       class="form-control"
                                       name="property_info[area]"
                                       step="0.01"
                                       placeholder="Örn: 120.50"
                                       value="{{ old('property_info.area') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kat Numarası</label>
                                <input type="number"
                                       class="form-control"
                                       name="property_info[floor]"
                                       placeholder="Örn: 3"
                                       value="{{ old('property_info.floor') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Şirket Teklifleri -->
                <div class="form-card card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="section-title">
                                <i class="bi bi-building"></i>
                                <span>Sigorta Şirketi Teklifleri</span>
                            </h5>
                            <button type="button" class="btn btn-primary btn-sm action-btn" onclick="addCompanyItem()">
                                <i class="bi bi-plus-circle me-2"></i>Şirket Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="companyItemsContainer">
                            <!-- Şirket item'ları buraya eklenecek -->
                        </div>

                        <button type="button" class="add-company-btn" onclick="addCompanyItem()">
                            <i class="bi bi-plus-circle me-2"></i>
                            Yeni Şirket Teklifi Ekle
                        </button>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        En az bir şirket teklifi eklemelisiniz
                    </small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('quotations.index') }}" class="btn btn-light action-btn">
                            <i class="bi bi-x-circle me-2"></i>İptal
                        </a>
                        <button type="submit" class="btn btn-primary action-btn">
                            <i class="bi bi-check-circle me-2"></i>Teklif Oluştur
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Şirket Item Template -->
<template id="companyItemTemplate">
    <div class="company-item">
        <div class="company-item-header">
            <div class="company-item-number">
                <i class="bi bi-building"></i>
                <span>Şirket Teklifi <span class="item-number"></span></span>
            </div>
        </div>

        <button type="button" class="remove-item-btn" onclick="removeCompanyItem(this)" title="Kaldır">
            <i class="bi bi-x"></i>
        </button>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">
                    Sigorta Şirketi <span class="text-danger">*</span>
                </label>
                <select class="form-select" name="items[INDEX][company_id]" required>
                    <option value="">Şirket seçiniz</option>
                    @foreach($insuranceCompanies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Prim Tutarı (₺) <span class="text-danger">*</span>
                </label>
                <input type="number"
                       class="form-control"
                       name="items[INDEX][premium_amount]"
                       step="0.01"
                       placeholder="0.00"
                       required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Teminat Özeti</label>
                <input type="text"
                       class="form-control"
                       name="items[INDEX][coverage_summary]"
                       placeholder="Örn: Kasko + IMM + Araç Çalınması">
            </div>

            <div class="col-md-1">
                <label class="form-label">Önerilen</label>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input"
                           type="checkbox"
                           name="items[INDEX][is_recommended]"
                           value="1"
                           title="Bu teklifi müşteriye önerilenler arasında işaretle">
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
let itemIndex = 0;

// Teklif türüne göre bölümleri göster/gizle
$('#quotation_type').on('change', function() {
    const type = $(this).val();

    $('#vehicleSection, #propertySection').hide();

    if (type === 'kasko' || type === 'trafik') {
        $('#vehicleSection').slideDown(300);
    }

    if (type === 'konut' || type === 'dask') {
        $('#propertySection').slideDown(300);
    }
});

// Şirket item ekle
function addCompanyItem() {
    const template = document.getElementById('companyItemTemplate');
    const clone = template.content.cloneNode(true);

    // INDEX placeholder'ını değiştir
    const div = clone.querySelector('.company-item');
    div.innerHTML = div.innerHTML.replace(/INDEX/g, itemIndex);

    // Item numarasını güncelle
    div.querySelector('.item-number').textContent = '#' + (itemIndex + 1);

    document.getElementById('companyItemsContainer').appendChild(clone);

    itemIndex++;
    updateItemNumbers();
}

// Şirket item kaldır
function removeCompanyItem(button) {
    const item = button.closest('.company-item');
    item.style.opacity = '0';
    item.style.transform = 'scale(0.95)';

    setTimeout(() => {
        item.remove();
        updateItemNumbers();
    }, 200);
}

// Item numaralarını güncelle
function updateItemNumbers() {
    const items = document.querySelectorAll('.company-item');
    items.forEach((item, index) => {
        const numberSpan = item.querySelector('.item-number');
        if (numberSpan) {
            numberSpan.textContent = '#' + (index + 1);
        }
    });
}

// Sayfa yüklendiğinde ilk item'ı ekle
$(document).ready(function() {
    addCompanyItem();

    // İlk alana focus
    $('#customer_id').focus();

    // Plaka formatı - büyük harf
    $(document).on('input', 'input[name="vehicle_info[plate]"]', function() {
        let value = $(this).val().toUpperCase();
        $(this).val(value);
    });
});

// Form validasyonu
$('#quotationForm').on('submit', function(e) {
    const itemCount = $('.company-item').length;

    if (itemCount === 0) {
        e.preventDefault();

        // Modern alert
        const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Hata!</strong> En az bir şirket teklifi eklemelisiniz.
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
             .html('<span class="spinner-border spinner-border-sm me-2"></span>Oluşturuluyor...');
});

// Input focus'ta invalid class'ını kaldır
$('.form-control, .form-select').on('focus', function() {
    $(this).removeClass('is-invalid');
});
</script>
@endpush
