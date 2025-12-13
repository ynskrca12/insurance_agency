@extends('layouts.app')

@section('title', 'Yeni Sigorta Şirketi')

@push('styles')
<style>
    .page-header {
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
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .form-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .card-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: #6c757d;
        font-size: 1.25rem;
    }

    .form-card .card-body {
        padding: 1.5rem;
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

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #dcdcdc;
        border-left: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.625rem 1rem;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control {
        border-radius: 8px 0 0 8px;
    }

    .helper-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
        display: block;
    }

    .logo-preview-container {
        background: #f8f9fa;
        border: 2px dashed #dcdcdc;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1rem;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .logo-preview-container:hover {
        border-color: #999;
        background: #f0f0f0;
    }

    .logo-preview-container.has-image {
        border-style: solid;
        border-color: #28a745;
        background: #ffffff;
    }

    .logo-preview-image {
        max-height: 180px;
        max-width: 100%;
        border-radius: 8px;
    }

    .logo-placeholder {
        color: #9ca3af;
    }

    .logo-placeholder i {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
        border: 2px solid #dcdcdc;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #495057;
        padding-left: 0.5rem;
        font-size: 1rem;
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

    .btn-submit {
        border-radius: 8px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .commission-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .commission-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h1 class="h3 mb-0 fw-bold text-dark">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Sigorta Şirketi
                    </h1>
                    <a href="{{ route('insurance-companies.index') }}" class="btn btn-light action-btn">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('insurance-companies.store') }}" enctype="multipart/form-data" id="companyForm">
                @csrf

                <div class="row g-4">
                    <!-- Sol Kolon -->
                    <div class="col-lg-8">
                        <!-- Temel Bilgiler -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="bi bi-info-circle"></i>
                                    <span>Temel Bilgiler</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="name" class="form-label">
                                            Şirket Adı <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required
                                               placeholder="Örn: Axa Sigorta A.Ş.">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="code" class="form-label">
                                            Şirket Kodu <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control @error('code') is-invalid @enderror"
                                               id="code"
                                               name="code"
                                               value="{{ old('code') }}"
                                               required
                                               maxlength="10"
                                               placeholder="AXA"
                                               style="text-transform: uppercase;">
                                        @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="helper-text">Kısa kod: AXA, HDI, ALC</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone" class="form-label">Telefon</label>
                                        <input type="text"
                                               class="form-control"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="0212 123 45 67">
                                        <small class="helper-text">Müşteri hizmetleri numarası</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label">E-posta</label>
                                        <input type="email"
                                               class="form-control"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="info@example.com">
                                        <small class="helper-text">İletişim e-posta adresi</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="url"
                                               class="form-control"
                                               id="website"
                                               name="website"
                                               value="{{ old('website') }}"
                                               placeholder="https://www.example.com">
                                        <small class="helper-text">Şirket web sitesi</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Komisyon Oranları -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="bi bi-percent"></i>
                                    <span>Varsayılan Komisyon Oranları</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="commission-grid">
                                    <div>
                                        <label for="default_commission_kasko" class="form-label">Kasko</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_kasko"
                                                   name="default_commission_kasko"
                                                   value="{{ old('default_commission_kasko', 20) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="default_commission_trafik" class="form-label">Trafik</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_trafik"
                                                   name="default_commission_trafik"
                                                   value="{{ old('default_commission_trafik', 15) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="default_commission_konut" class="form-label">Konut</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_konut"
                                                   name="default_commission_konut"
                                                   value="{{ old('default_commission_konut', 18) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="default_commission_dask" class="form-label">DASK</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_dask"
                                                   name="default_commission_dask"
                                                   value="{{ old('default_commission_dask', 18) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="default_commission_saglik" class="form-label">Sağlık</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_saglik"
                                                   name="default_commission_saglik"
                                                   value="{{ old('default_commission_saglik', 12) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="default_commission_hayat" class="form-label">Hayat</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_hayat"
                                                   name="default_commission_hayat"
                                                   value="{{ old('default_commission_hayat', 25) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="default_commission_tss" class="form-label">Tamamlayıcı Sağlık</label>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   id="default_commission_tss"
                                                   name="default_commission_tss"
                                                   value="{{ old('default_commission_tss', 15) }}"
                                                   step="0.01"
                                                   min="0"
                                                   max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <small class="helper-text mt-3">Bu oranlar yeni poliçeler için varsayılan olarak kullanılacaktır.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Sağ Kolon -->
                    <div class="col-lg-4">
                        <!-- Logo -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="bi bi-image"></i>
                                    <span>Şirket Logosu</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="logoPreviewContainer" class="logo-preview-container">
                                    <div class="logo-placeholder" id="logoPlaceholder">
                                        <i class="bi bi-image"></i>
                                        <p class="mb-0">Logo yüklemek için tıklayın</p>
                                    </div>
                                    <img id="logoPreviewImage" class="logo-preview-image" style="display: none;">
                                </div>
                                <input type="file"
                                       class="form-control"
                                       id="logo"
                                       name="logo"
                                       accept="image/*"
                                       onchange="previewLogo(this)">
                                <small class="helper-text">PNG, JPG, GIF, SVG - Maksimum 2MB</small>
                            </div>
                        </div>

                        <!-- Durum ve Ayarlar -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="bi bi-gear"></i>
                                    <span>Durum ve Ayarlar</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="is_active"
                                               name="is_active"
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Aktif Durum
                                        </label>
                                    </div>
                                    <small class="helper-text">Pasif şirketler listede gösterilmez</small>
                                </div>

                                <div>
                                    <label for="display_order" class="form-label">Görüntüleme Sırası</label>
                                    <input type="number"
                                           class="form-control"
                                           id="display_order"
                                           name="display_order"
                                           value="{{ old('display_order', 0) }}"
                                           min="0">
                                    <small class="helper-text">Küçük numara önce gösterilir</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-check-circle me-2"></i>Şirketi Kaydet
                            </button>
                            <a href="{{ route('insurance-companies.index') }}" class="btn btn-light action-btn">
                                <i class="bi bi-x-circle me-2"></i>İptal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    const container = document.getElementById('logoPreviewContainer');
    const placeholder = document.getElementById('logoPlaceholder');
    const image = document.getElementById('logoPreviewImage');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            image.src = e.target.result;
            image.style.display = 'block';
            placeholder.style.display = 'none';
            container.classList.add('has-image');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    // Code input'u uppercase yap
    $('#code').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Form submit animasyonu
    $('#companyForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Kaydediliyor...');
    });

    // Input focus'ta invalid class'ı kaldır
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
