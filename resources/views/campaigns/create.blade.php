@extends('layouts.app')

@section('title', 'Yeni Kampanya Oluştur')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-plus-circle me-2"></i>Yeni Kampanya Oluştur
            </h1>
            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>

        <form method="POST" action="{{ route('campaigns.store') }}" id="campaignForm">
            @csrf

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
                                        <option value="">Seçiniz</option>
                                        <option value="sms" {{ old('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                                        <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>E-posta</option>
                                        <option value="whatsapp" {{ old('type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="subjectField" style="display: none;">
                                    <label for="subject" class="form-label">Konu</label>
                                    <input type="text"
                                           class="form-control"
                                           id="subject"
                                           name="subject"
                                           value="{{ old('subject') }}"
                                           placeholder="E-posta konusu">
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
                                <small class="text-muted">
                                    <strong>Değişkenler:</strong> {NAME}, {PHONE}, {POLICY_NUMBER}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Hedef Kitle -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-people me-2"></i>Hedef Kitle
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    Hedef Kitle Tipi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="target_type" id="target_type" required>
                                    <option value="">Seçiniz</option>
                                    <option value="all" {{ old('target_type') === 'all' ? 'selected' : '' }}>Tüm Müşteriler</option>
                                    <option value="active_customers" {{ old('target_type') === 'active_customers' ? 'selected' : '' }}>Aktif Poliçesi Olanlar</option>
                                    <option value="policy_type" {{ old('target_type') === 'policy_type' ? 'selected' : '' }}>Poliçe Türüne Göre</option>
                                    <option value="city" {{ old('target_type') === 'city' ? 'selected' : '' }}>Şehre Göre</option>
                                    <option value="custom" {{ old('target_type') === 'custom' ? 'selected' : '' }}>Özel Seçim</option>
                                </select>
                            </div>

                            <!-- Poliçe Türü Filtresi -->
                            <div id="policyTypeFilter" style="display: none;">
                                <label class="form-label">Poliçe Türü</label>
                                <select class="form-select" name="target_filter[policy_type]">
                                    <option value="">Seçiniz</option>
                                    <option value="kasko">Kasko</option>
                                    <option value="trafik">Trafik</option>
                                    <option value="konut">Konut</option>
                                    <option value="dask">DASK</option>
                                    <option value="saglik">Sağlık</option>
                                    <option value="hayat">Hayat</option>
                                </select>
                            </div>

                            <!-- Şehir Filtresi -->
                            <div id="cityFilter" style="display: none;">
                                <label class="form-label">Şehir</label>
                                <input type="text" class="form-control" name="target_filter[city]" placeholder="Şehir adı">
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="previewBtn">
                                    <i class="bi bi-eye me-1"></i>Alıcıları Önizle
                                </button>
                                <span id="recipientCount" class="ms-3 text-muted"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ Kolon -->
                <div class="col-md-4">
                    <!-- Zamanlama -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-clock me-2"></i>Zamanlama
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
                                    <label for="scheduled_at" class="form-label">Gönderim Tarihi</label>
                                    <input type="datetime-local"
                                           class="form-control"
                                           id="scheduled_at"
                                           name="scheduled_at"
                                           value="{{ old('scheduled_at') }}">
                                    <small class="text-muted">Boş bırakırsanız taslak olarak kaydedilir</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Kampanyayı Oluştur
                        </button>
                        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>İptal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tip değiştiğinde konu alanını göster/gizle
    $('#type').on('change', function() {
        if ($(this).val() === 'email') {
            $('#subjectField').show();
            $('#subject').attr('required', true);
        } else {
            $('#subjectField').hide();
            $('#subject').attr('required', false);
        }
    });

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

        $('#policyTypeFilter, #cityFilter').hide();

        if (value === 'policy_type') {
            $('#policyTypeFilter').show();
        } else if (value === 'city') {
            $('#cityFilter').show();
        }
    });

    // Hemen gönder checkbox
    $('#send_now').on('change', function() {
        if ($(this).is(':checked')) {
            $('#scheduledFields').hide();
            $('#scheduled_at').attr('required', false);
        } else {
            $('#scheduledFields').show();
        }
    });

    // Alıcıları önizle
    $('#previewBtn').on('click', function() {
        const targetType = $('#target_type').val();
        const targetFilter = {};

        if (targetType === 'policy_type') {
            targetFilter.policy_type = $('select[name="target_filter[policy_type]"]').val();
        } else if (targetType === 'city') {
            targetFilter.city = $('input[name="target_filter[city]"]').val();
        }

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
                    <span class="badge bg-success">${response.count} alıcı</span>
                `);
            }
        });
    });
});
</script>
@endpush
