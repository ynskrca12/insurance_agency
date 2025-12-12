@extends('layouts.app')

@section('title', 'Şirket Düzenle')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil me-2"></i>Şirket Düzenle: {{ $insuranceCompany->name }}
            </h1>
            <div>
                <a href="{{ route('insurance-companies.show', $insuranceCompany) }}" class="btn btn-info">
                    <i class="bi bi-eye me-2"></i>Detay
                </a>
                <a href="{{ route('insurance-companies.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('insurance-companies.update', $insuranceCompany) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Sol Kolon -->
                <div class="col-md-8">
                    <!-- Temel Bilgiler -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>Temel Bilgiler
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
                                           value="{{ old('name', $insuranceCompany->name) }}"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="code" class="form-label">
                                        Kod <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           id="code"
                                           name="code"
                                           value="{{ old('code', $insuranceCompany->code) }}"
                                           required
                                           maxlength="10">
                                    @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="text"
                                           class="form-control"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $insuranceCompany->phone) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">E-posta</label>
                                    <input type="email"
                                           class="form-control"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $insuranceCompany->email) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url"
                                           class="form-control"
                                           id="website"
                                           name="website"
                                           value="{{ old('website', $insuranceCompany->website) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Komisyon Oranları -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-percent me-2"></i>Varsayılan Komisyon Oranları (%)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="default_commission_kasko" class="form-label">Kasko</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_kasko"
                                               name="default_commission_kasko"
                                               value="{{ old('default_commission_kasko', $insuranceCompany->default_commission_kasko) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="default_commission_trafik" class="form-label">Trafik</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_trafik"
                                               name="default_commission_trafik"
                                               value="{{ old('default_commission_trafik', $insuranceCompany->default_commission_trafik) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="default_commission_konut" class="form-label">Konut</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_konut"
                                               name="default_commission_konut"
                                               value="{{ old('default_commission_konut', $insuranceCompany->default_commission_konut) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="default_commission_dask" class="form-label">DASK</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_dask"
                                               name="default_commission_dask"
                                               value="{{ old('default_commission_dask', $insuranceCompany->default_commission_dask) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="default_commission_saglik" class="form-label">Sağlık</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_saglik"
                                               name="default_commission_saglik"
                                               value="{{ old('default_commission_saglik', $insuranceCompany->default_commission_saglik) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="default_commission_hayat" class="form-label">Hayat</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_hayat"
                                               name="default_commission_hayat"
                                               value="{{ old('default_commission_hayat', $insuranceCompany->default_commission_hayat) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="default_commission_tss" class="form-label">TSS</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               id="default_commission_tss"
                                               name="default_commission_tss"
                                               value="{{ old('default_commission_tss', $insuranceCompany->default_commission_tss) }}"
                                               step="0.01"
                                               min="0"
                                               max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ Kolon -->
                <div class="col-md-4">
                    <!-- Logo -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-image me-2"></i>Logo
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            @if($insuranceCompany->logo)
                            <div id="currentLogo" class="mb-3">
                                <img src="{{ asset('storage/' . $insuranceCompany->logo) }}"
                                     alt="{{ $insuranceCompany->name }}"
                                     class="img-fluid rounded"
                                     style="max-height: 150px;">
                                <p class="text-muted small mt-2">Mevcut Logo</p>
                            </div>
                            @endif

                            <div id="logoPreview" class="mb-3" style="display: none;">
                                <img src="" alt="Logo Preview" class="img-fluid rounded" style="max-height: 150px;">
                                <p class="text-muted small mt-2">Yeni Logo Önizleme</p>
                            </div>

                            <input type="file"
                                   class="form-control"
                                   id="logo"
                                   name="logo"
                                   accept="image/*"
                                   onchange="previewLogo(this)">
                            <small class="text-muted">PNG, JPG, GIF, SVG - Max 2MB</small>
                        </div>
                    </div>

                    <!-- Durum -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="bi bi-toggle-on me-2"></i>Durum
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $insuranceCompany->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>

                            <div class="mt-3">
                                <label for="display_order" class="form-label">Sıralama</label>
                                <input type="number"
                                       class="form-control"
                                       id="display_order"
                                       name="display_order"
                                       value="{{ old('display_order', $insuranceCompany->display_order) }}"
                                       min="0">
                                <small class="text-muted">Küçük numara önce gösterilir</small>
                            </div>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Güncelle
                        </button>
                        <button type="button" class="btn btn-danger" onclick="deleteCompany()">
                            <i class="bi bi-trash me-2"></i>Sil
                        </button>
                        <a href="{{ route('insurance-companies.show', $insuranceCompany) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>İptal
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Delete Form -->
        <form id="deleteForm" method="POST" action="{{ route('insurance-companies.destroy', $insuranceCompany) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#logoPreview img').attr('src', e.target.result);
            $('#logoPreview').show();
            $('#currentLogo').hide();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteCompany() {
    if (confirm('Bu şirketi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
