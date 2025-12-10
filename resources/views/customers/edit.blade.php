@extends('layouts.app')

@section('title', 'Müşteri Düzenle - ' . $customer->name)

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
        overflow: hidden;
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f5f5f5;
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

    .btn-danger.action-btn {
        border-color: #dc3545;
    }

    .btn-danger.action-btn:hover {
        border-color: #bb2d3b;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.375rem;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
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

    .danger-zone {
        background: #fff5f5;
        border: 1px solid #fee;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .danger-zone-title {
        color: #dc3545;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .customer-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: #fafafa;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
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
        <div class="col-xl-8 col-lg-10 mx-auto">
            <!-- Header -->
            <div class="form-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <h1 class="h3 mb-1 fw-bold text-dark">
                            <i class="bi bi-pencil me-2"></i>Müşteri Düzenle
                        </h1>
                        <p class="text-muted mb-0 small">{{ $customer->name }} bilgilerini güncelleyin</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-info action-btn">
                            <i class="bi bi-eye me-2"></i>Detay
                        </a>
                        <a href="{{ route('customers.index') }}" class="btn btn-light action-btn">
                            <i class="bi bi-arrow-left me-2"></i>Geri
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <form method="POST" action="{{ route('customers.update', $customer) }}" id="customerForm">
                    @csrf
                    @method('PUT')

                    <!-- Müşteri Bilgi Badge -->
                    <div class="form-section">
                        <div class="info-badge">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <i class="bi bi-info-circle me-2"></i>
                                    <span class="text-danger fw-semibold">*</span> işaretli alanlar zorunludur.
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="customer-badge">
                                        <i class="bi bi-hash"></i>
                                        <span>Müşteri No: {{ $customer->id }}</span>
                                    </div>
                                    <div class="customer-badge">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>{{ $customer->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Temel Bilgiler -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-person"></i>
                            <span>Temel Bilgiler</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Ad Soyad <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $customer->name) }}"
                                       placeholder="Örn: Ahmet Yılmaz"
                                       required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">
                                    Müşteri Durumu <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>
                                        Aktif Müşteri
                                    </option>
                                    <option value="potential" {{ old('status', $customer->status) === 'potential' ? 'selected' : '' }}>
                                        Potansiyel Müşteri
                                    </option>
                                    <option value="passive" {{ old('status', $customer->status) === 'passive' ? 'selected' : '' }}>
                                        Pasif Müşteri
                                    </option>
                                    <option value="lost" {{ old('status', $customer->status) === 'lost' ? 'selected' : '' }}>
                                        Kayıp Müşteri
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    Telefon <span class="text-danger">*</span>
                                </label>
                                <input type="tel"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $customer->phone) }}"
                                       placeholder="5XX XXX XX XX"
                                       required>
                                <small class="form-text">10 veya 11 haneli telefon numarası</small>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone_secondary" class="form-label">
                                    İkinci Telefon
                                </label>
                                <input type="tel"
                                       class="form-control @error('phone_secondary') is-invalid @enderror"
                                       id="phone_secondary"
                                       name="phone_secondary"
                                       value="{{ old('phone_secondary', $customer->phone_secondary) }}"
                                       placeholder="5XX XXX XX XX">
                                @error('phone_secondary')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    E-posta Adresi
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $customer->email) }}"
                                       placeholder="ornek@email.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="id_number" class="form-label">
                                    TC Kimlik Numarası
                                </label>
                                <input type="text"
                                       class="form-control @error('id_number') is-invalid @enderror"
                                       id="id_number"
                                       name="id_number"
                                       value="{{ old('id_number', $customer->id_number) }}"
                                       placeholder="XXXXXXXXXXX"
                                       maxlength="11">
                                <small class="form-text">11 haneli TC kimlik numarası</small>
                                @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">
                                    Doğum Tarihi
                                </label>
                                <input type="date"
                                       class="form-control @error('birth_date') is-invalid @enderror"
                                       id="birth_date"
                                       name="birth_date"
                                       value="{{ old('birth_date', $customer->birth_date?->format('Y-m-d')) }}">
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- İş Bilgileri -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-briefcase"></i>
                            <span>İş Bilgileri</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="occupation" class="form-label">
                                    Meslek
                                </label>
                                <input type="text"
                                       class="form-control @error('occupation') is-invalid @enderror"
                                       id="occupation"
                                       name="occupation"
                                       value="{{ old('occupation', $customer->occupation) }}"
                                       placeholder="Örn: Öğretmen, Mühendis">
                                @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="workplace" class="form-label">
                                    İş Yeri
                                </label>
                                <input type="text"
                                       class="form-control @error('workplace') is-invalid @enderror"
                                       id="workplace"
                                       name="workplace"
                                       value="{{ old('workplace', $customer->workplace) }}"
                                       placeholder="Çalıştığı kurum veya şirket">
                                @error('workplace')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Adres Bilgileri -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-geo-alt"></i>
                            <span>Adres Bilgileri</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="address" class="form-label">
                                    Açık Adres
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          name="address"
                                          rows="3"
                                          placeholder="Mahalle, sokak, cadde, bina no vb.">{{ old('address', $customer->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label for="city" class="form-label">
                                    İl
                                </label>
                                <input type="text"
                                       class="form-control @error('city') is-invalid @enderror"
                                       id="city"
                                       name="city"
                                       value="{{ old('city', $customer->city) }}"
                                       placeholder="Örn: İstanbul">
                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="district" class="form-label">
                                    İlçe
                                </label>
                                <input type="text"
                                       class="form-control @error('district') is-invalid @enderror"
                                       id="district"
                                       name="district"
                                       value="{{ old('district', $customer->district) }}"
                                       placeholder="Örn: Kadıköy">
                                @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="postal_code" class="form-label">
                                    Posta Kodu
                                </label>
                                <input type="text"
                                       class="form-control @error('postal_code') is-invalid @enderror"
                                       id="postal_code"
                                       name="postal_code"
                                       value="{{ old('postal_code', $customer->postal_code) }}"
                                       placeholder="34XXX"
                                       maxlength="5">
                                @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Notlar -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="bi bi-sticky"></i>
                            <span>Ek Notlar</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="notes" class="form-label">
                                    Müşteri Hakkında Notlar
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes"
                                          name="notes"
                                          rows="4"
                                          placeholder="Müşteri ile ilgili önemli notlar, özel talepler veya hatırlatmalar...">{{ old('notes', $customer->notes) }}</textarea>
                                <small class="form-text">Bu notlar sadece sizin ve ekibiniz tarafından görülebilir</small>
                                @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-section bg-light">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <small class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                Son güncelleme: {{ $customer->updated_at->diffForHumans() }}
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-light action-btn">
                                    <i class="bi bi-x-circle me-2"></i>İptal
                                </a>
                                <button type="submit" class="btn btn-primary action-btn">
                                    <i class="bi bi-check-circle me-2"></i>Değişiklikleri Kaydet
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="form-section">
                        <div class="danger-zone">
                            <div class="danger-zone-title">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>Tehlikeli Bölge</span>
                            </div>
                            <p class="text-muted mb-3 small">
                                Müşteriyi silerseniz bu işlem geri alınamaz. Müşteriye ait tüm veriler kalıcı olarak silinecektir.
                            </p>
                            <button type="button"
                                    class="btn btn-danger action-btn"
                                    onclick="deleteCustomer()">
                                <i class="bi bi-trash me-2"></i>Müşteriyi Kalıcı Olarak Sil
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Delete Form (Hidden) -->
                <form id="deleteForm" method="POST" action="{{ route('customers.destroy', $customer) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteCustomer() {
    // Modern confirmation dialog
    const confirmDelete = confirm(
        '⚠️ DİKKAT!\n\n' +
        'Bu müşteriyi kalıcı olarak silmek istediğinizden emin misiniz?\n\n' +
        '• Müşteriye ait tüm bilgiler silinecektir\n' +
        '• Müşterinin poliçeleri varsa işlem başarısız olacaktır\n' +
        '• Bu işlem geri alınamaz!\n\n' +
        'Devam etmek istiyor musunuz?'
    );

    if (confirmDelete) {
        const doubleConfirm = confirm(
            '⛔ SON UYARI!\n\n' +
            'Müşteri: {{ $customer->name }}\n\n' +
            'Bu müşteriyi silmek için son kez onaylayın.'
        );

        if (doubleConfirm) {
            // Loading state
            $('body').append(`
                <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                     style="background: rgba(0,0,0,0.5); z-index: 9999;">
                    <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
                </div>
            `);

            document.getElementById('deleteForm').submit();
        }
    }
}

$(document).ready(function() {
    // Telefon formatı - sadece rakam
    $('#phone, #phone_secondary').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 11) {
            value = value.slice(0, 11);
        }
        $(this).val(value);
    });

    // TC Kimlik No formatı - sadece rakam
    $('#id_number').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 11) {
            value = value.slice(0, 11);
        }
        $(this).val(value);
    });

    // Posta kodu formatı - sadece rakam
    $('#postal_code').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 5) {
            value = value.slice(0, 5);
        }
        $(this).val(value);
    });

    // Form submit öncesi validasyon
    $('#customerForm').on('submit', function(e) {
        let isValid = true;
        let errorMessage = '';

        // Ad Soyad kontrolü
        const name = $('#name').val().trim();
        if (name.length < 3) {
            isValid = false;
            errorMessage = 'Lütfen geçerli bir ad soyad giriniz (en az 3 karakter).';
            $('#name').addClass('is-invalid').focus();
        }

        // Telefon kontrolü
        const phone = $('#phone').val().replace(/\D/g, '');
        if (phone.length < 10) {
            isValid = false;
            errorMessage = 'Lütfen geçerli bir telefon numarası giriniz (10-11 hane).';
            $('#phone').addClass('is-invalid').focus();
        }

        // Durum kontrolü
        const status = $('#status').val();
        if (!status) {
            isValid = false;
            errorMessage = 'Lütfen müşteri durumunu seçiniz.';
            $('#status').addClass('is-invalid').focus();
        }

        // TC Kimlik kontrolü (eğer girilmişse)
        const idNumber = $('#id_number').val().replace(/\D/g, '');
        if (idNumber.length > 0 && idNumber.length !== 11) {
            isValid = false;
            errorMessage = 'TC Kimlik numarası 11 haneli olmalıdır.';
            $('#id_number').addClass('is-invalid').focus();
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

            // 5 saniye sonra otomatik kapat
            setTimeout(function() {
                $('.alert').fadeOut(300, function() { $(this).remove(); });
            }, 5000);

            return false;
        }

        // Form gönderiliyor animasyonu
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Güncelleniyor...');
    });

    // Input focus'ta invalid class'ını kaldır
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });

    // Değişiklik algılama
    let formChanged = false;
    $('#customerForm input, #customerForm select, #customerForm textarea').on('change', function() {
        formChanged = true;
    });

    // Sayfa kapatılmadan önce uyarı
    $(window).on('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            return 'Kaydedilmemiş değişiklikleriniz var. Sayfayı kapatmak istediğinizden emin misiniz?';
        }
    });

    // Form submit edildiğinde uyarıyı kapat
    $('#customerForm').on('submit', function() {
        formChanged = false;
    });
});
</script>
@endpush
