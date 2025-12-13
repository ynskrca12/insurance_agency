@extends('layouts.app')

@section('title', 'Yeni Kampanya Oluştur')

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
        color: #9ca3af;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
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

    .helper-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
    }

    .variables-info {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: #0066cc;
    }

    .variables-info strong {
        font-weight: 600;
    }

    .submit-btn {
        border-radius: 8px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
        border: 2px solid #dcdcdc;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #495057;
        padding-left: 0.5rem;
    }

    .recipient-count {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #e8f5e9;
        border: 1px solid #a5d6a7;
        border-radius: 8px;
        font-weight: 600;
        color: #2e7d32;
    }

    .recipient-count i {
        font-size: 1.125rem;
    }

    .preview-btn {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .form-card .card-body {
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
                            <i class="bi bi-plus-circle me-2"></i>Yeni Kampanya Oluştur
                        </h1>
                        <p class="text-muted mb-0 small">Müşterilerinize toplu mesaj gönderin</p>
                    </div>
                    <a href="{{ route('campaigns.index') }}" class="btn btn-light action-btn">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('campaigns.store') }}" id="campaignForm">
                @csrf

                <!-- Zorunlu Alan Bilgisi -->
                <div class="info-badge">
                    <i class="bi bi-info-circle me-2"></i>
                    <span class="text-danger fw-semibold">*</span> işaretli alanlar zorunludur.
                </div>

                <div class="row g-4">
                    <!-- Sol Kolon -->
                    <div class="col-lg-8">
                        <!-- Temel Bilgiler -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="section-title">
                                    <i class="bi bi-info-circle"></i>
                                    <span>Temel Bilgiler</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Kampanya Adı <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           placeholder="Örn: Ocak Ayı Yenileme Hatırlatması">
                                    <small class="helper-text">Kampanyanızı tanımlayıcı bir isim verin</small>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="type" class="form-label">
                                            Kampanya Tipi <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('type') is-invalid @enderror"
                                                id="type"
                                                name="type"
                                                required>
                                            <option value="">Tip seçiniz</option>
                                            <option value="sms" {{ old('type') === 'sms' ? 'selected' : '' }}>📱 SMS</option>
                                            <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>📧 E-posta</option>
                                            <option value="whatsapp" {{ old('type') === 'whatsapp' ? 'selected' : '' }}>💬 WhatsApp</option>
                                        </select>
                                        @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6" id="subjectField" style="display: none;">
                                        <label for="subject" class="form-label">
                                            E-posta Konusu <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               id="subject"
                                               name="subject"
                                               value="{{ old('subject') }}"
                                               placeholder="E-posta konu başlığı">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="template_id" class="form-label">Şablon Seç (Opsiyonel)</label>
                                    <select class="form-select" id="template_id">
                                        <option value="">Özel mesaj yazın veya şablon seçin</option>
                                        @foreach($templates as $template)
                                        <option value="{{ $template->id }}"
                                                data-type="{{ $template->type }}"
                                                data-subject="{{ $template->subject }}"
                                                data-content="{{ $template->content }}">
                                            {{ $template->name }} ({{ strtoupper($template->type) }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="helper-text">Hazır şablon kullanarak hızlıca başlayın</small>
                                </div>

                                <div class="mt-3">
                                    <label for="message" class="form-label">
                                        Mesaj İçeriği <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              id="message"
                                              name="message"
                                              rows="8"
                                              required
                                              placeholder="Mesaj içeriğini buraya yazın...">{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="variables-info">
                                        <strong>Kullanabileceğiniz Değişkenler:</strong> {NAME} (Müşteri Adı), {PHONE} (Telefon), {POLICY_NUMBER} (Poliçe No)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hedef Kitle -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="section-title">
                                    <i class="bi bi-people"></i>
                                    <span>Hedef Kitle Seçimi</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="target_type" class="form-label">
                                        Hedef Kitle Tipi <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="target_type" id="target_type" required>
                                        <option value="">Hedef kitle seçiniz</option>
                                        <option value="all" {{ old('target_type') === 'all' ? 'selected' : '' }}>👥 Tüm Müşteriler</option>
                                        <option value="active_customers" {{ old('target_type') === 'active_customers' ? 'selected' : '' }}>✅ Aktif Poliçesi Olanlar</option>
                                        <option value="policy_type" {{ old('target_type') === 'policy_type' ? 'selected' : '' }}>📋 Poliçe Türüne Göre</option>
                                        <option value="city" {{ old('target_type') === 'city' ? 'selected' : '' }}>📍 Şehre Göre</option>
                                        <option value="custom" {{ old('target_type') === 'custom' ? 'selected' : '' }}>🎯 Özel Seçim</option>
                                    </select>
                                    <small class="helper-text">Kampanyanızın kime ulaşacağını belirleyin</small>
                                </div>

                                <!-- Poliçe Türü Filtresi -->
                                <div id="policyTypeFilter" style="display: none;">
                                    <label class="form-label">Poliçe Türü</label>
                                    <select class="form-select" name="target_filter[policy_type]">
                                        <option value="">Poliçe türü seçiniz</option>
                                        <option value="kasko">🚗 Kasko</option>
                                        <option value="trafik">🚙 Trafik</option>
                                        <option value="konut">🏠 Konut</option>
                                        <option value="dask">🏘️ DASK</option>
                                        <option value="saglik">🏥 Sağlık</option>
                                        <option value="hayat">❤️ Hayat</option>
                                    </select>
                                </div>

                                <!-- Şehir Filtresi -->
                                <div id="cityFilter" style="display: none;">
                                    <label class="form-label">Şehir</label>
                                    <input type="text"
                                           class="form-control"
                                           name="target_filter[city]"
                                           placeholder="Örn: İstanbul">
                                </div>

                                <div class="mt-3 d-flex align-items-center gap-3">
                                    <button type="button" class="btn btn-outline-primary preview-btn" id="previewBtn">
                                        <i class="bi bi-eye me-2"></i>Alıcıları Önizle
                                    </button>
                                    <div id="recipientCount"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sağ Kolon -->
                    <div class="col-lg-4">
                        <!-- Zamanlama -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="section-title">
                                    <i class="bi bi-clock"></i>
                                    <span>Zamanlama</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="send_now"
                                           name="send_now"
                                           value="1">
                                    <label class="form-check-label" for="send_now">
                                        Hemen Gönder
                                    </label>
                                </div>

                                <div id="scheduledFields">
                                    <div class="mb-3">
                                        <label for="scheduled_at" class="form-label">Gönderim Tarihi & Saati</label>
                                        <input type="datetime-local"
                                               class="form-control"
                                               id="scheduled_at"
                                               name="scheduled_at"
                                               value="{{ old('scheduled_at') }}">
                                        <small class="helper-text">Boş bırakırsanız taslak olarak kaydedilir</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <i class="bi bi-check-circle me-2"></i>Kampanyayı Oluştur
                            </button>
                            <a href="{{ route('campaigns.index') }}" class="btn btn-light action-btn">
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
$(document).ready(function() {
    // Tip değiştiğinde konu alanını göster/gizle
    $('#type').on('change', function() {
        if ($(this).val() === 'email') {
            $('#subjectField').slideDown(300);
            $('#subject').attr('required', true);
        } else {
            $('#subjectField').slideUp(300);
            $('#subject').attr('required', false);
        }
    });

    // Sayfa yüklendiğinde kontrol et
    if ($('#type').val() === 'email') {
        $('#subjectField').show();
        $('#subject').attr('required', true);
    }

    // Şablon seçildiğinde içeriği doldur
    $('#template_id').on('change', function() {
        const option = $(this).find(':selected');
        if (option.val()) {
            $('#type').val(option.data('type')).trigger('change');
            $('#subject').val(option.data('subject'));
            $('#message').val(option.data('content'));
        }
    });

    // Hedef kitle değiştiğinde filtreleri göster/gizle
    $('#target_type').on('change', function() {
        const value = $(this).val();

        $('#policyTypeFilter, #cityFilter').slideUp(300);

        if (value === 'policy_type') {
            $('#policyTypeFilter').slideDown(300);
        } else if (value === 'city') {
            $('#cityFilter').slideDown(300);
        }
    });

    // Sayfa yüklendiğinde kontrol et
    const initialTargetType = $('#target_type').val();
    if (initialTargetType === 'policy_type') {
        $('#policyTypeFilter').show();
    } else if (initialTargetType === 'city') {
        $('#cityFilter').show();
    }

    // Hemen gönder checkbox
    $('#send_now').on('change', function() {
        if ($(this).is(':checked')) {
            $('#scheduledFields').slideUp(300);
            $('#scheduled_at').attr('required', false);
        } else {
            $('#scheduledFields').slideDown(300);
        }
    });

    // Alıcıları önizle
    $('#previewBtn').on('click', function() {
        const targetType = $('#target_type').val();

        if (!targetType) {
            alert('Lütfen önce hedef kitle tipi seçiniz!');
            return;
        }

        const targetFilter = {};

        if (targetType === 'policy_type') {
            targetFilter.policy_type = $('select[name="target_filter[policy_type]"]').val();
        } else if (targetType === 'city') {
            targetFilter.city = $('input[name="target_filter[city]"]').val();
        }

        // Loading state
        const btn = $(this);
        const originalHtml = btn.html();
        btn.prop('disabled', true)
           .html('<span class="spinner-border spinner-border-sm me-2"></span>Yükleniyor...');

        $.ajax({
            url: '{{ route("campaigns.previewRecipients") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                target_type: targetType,
                target_filter: targetFilter
            },
            success: function(response) {
                $('#recipientCount').html(`
                    <div class="recipient-count">
                        <i class="bi bi-people-fill"></i>
                        <span>${response.count} Alıcı</span>
                    </div>
                `);
            },
            error: function() {
                alert('Alıcılar yüklenirken bir hata oluştu.');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // Form submit animasyonu
    $('#campaignForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Oluşturuluyor...');
    });

    // Input focus'ta invalid class'ını kaldır
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });

    // İlk alana focus
    $('#name').focus();
});
</script>
@endpush
