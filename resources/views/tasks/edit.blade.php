@extends('layouts.app')

@section('title', 'Görev Düzenle')

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

    .btn-info.action-btn {
        border-color: #0dcaf0;
    }

    .info-badge {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 0.875rem 1.125rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: #664d03;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
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

    .danger-zone {
        border: 1px solid #dc3545;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        background: #fff5f5;
    }

    .danger-zone-title {
        color: #dc3545;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .danger-zone-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .btn-delete {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .meta-info {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .meta-item {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .meta-item:last-child {
        margin-bottom: 0;
    }

    .meta-item strong {
        color: #495057;
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
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1 class="h3 mb-1 fw-bold text-dark">
                            <i class="bi bi-pencil me-2"></i>Görev Düzenle
                        </h1>
                        <p class="text-muted mb-0 small">Görev bilgilerini güncelleyin</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-info action-btn">
                            <i class="bi bi-eye me-2"></i>Detay
                        </a>
                        <a href="{{ route('tasks.index') }}" class="btn btn-light action-btn">
                            <i class="bi bi-arrow-left me-2"></i>Geri
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('tasks.update', $task) }}" id="taskForm">
                @csrf
                @method('PUT')

                <!-- Meta Bilgi -->
                <div class="meta-info">
                    <div class="meta-item">
                        <strong>Oluşturulma:</strong> {{ $task->created_at->format('d.m.Y H:i') }}
                        @if($task->createdBy)
                            • {{ $task->createdBy->name }}
                        @endif
                    </div>
                    @if($task->updated_at != $task->created_at)
                    <div class="meta-item">
                        <strong>Son Güncelleme:</strong> {{ $task->updated_at->format('d.m.Y H:i') }}
                        @if($task->updatedBy)
                            • {{ $task->updatedBy->name }}
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Değişiklik Uyarısı -->
                <div class="info-badge">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Yaptığınız değişiklikler kaydetmeden sayfadan ayrılırsanız kaybolacaktır.
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
                                    <label for="title" class="form-label">
                                        Görev Başlığı <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $task->title) }}"
                                           required
                                           placeholder="Görev başlığı">
                                    <small class="form-text">Görevin kısa ve açıklayıcı başlığı</small>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Görev Açıklaması</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="4"
                                              placeholder="Görev detaylarını yazın...">{{ old('description', $task->description) }}</textarea>
                                    <small class="form-text">Detaylı açıklama ekleyebilirsiniz</small>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">
                                            Kategori <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('category') is-invalid @enderror"
                                                id="category"
                                                name="category"
                                                required>
                                            <option value="call" {{ old('category', $task->category) === 'call' ? 'selected' : '' }}>📞 Arama</option>
                                            <option value="meeting" {{ old('category', $task->category) === 'meeting' ? 'selected' : '' }}>🤝 Toplantı</option>
                                            <option value="follow_up" {{ old('category', $task->category) === 'follow_up' ? 'selected' : '' }}>🔄 Takip</option>
                                            <option value="document" {{ old('category', $task->category) === 'document' ? 'selected' : '' }}>📄 Evrak</option>
                                            <option value="renewal" {{ old('category', $task->category) === 'renewal' ? 'selected' : '' }}>🔁 Yenileme</option>
                                            <option value="payment" {{ old('category', $task->category) === 'payment' ? 'selected' : '' }}>💰 Ödeme</option>
                                            <option value="quotation" {{ old('category', $task->category) === 'quotation' ? 'selected' : '' }}>📊 Teklif</option>
                                            <option value="other" {{ old('category', $task->category) === 'other' ? 'selected' : '' }}>📌 Diğer</option>
                                        </select>
                                        @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="priority" class="form-label">
                                            Öncelik Seviyesi <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('priority') is-invalid @enderror"
                                                id="priority"
                                                name="priority"
                                                required>
                                            <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Düşük</option>
                                            <option value="normal" {{ old('priority', $task->priority) === 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>Yüksek</option>
                                            <option value="urgent" {{ old('priority', $task->priority) === 'urgent' ? 'selected' : '' }}>Acil</option>
                                        </select>
                                        @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- İlişkili Kayıtlar -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="section-title">
                                    <i class="bi bi-link-45deg"></i>
                                    <span>İlişkili Kayıtlar</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customer_id" class="form-label">Müşteri</label>
                                        <select class="form-select @error('customer_id') is-invalid @enderror"
                                                id="customer_id"
                                                name="customer_id">
                                            <option value="">Müşteri seçiniz (opsiyonel)</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                    {{ old('customer_id', $task->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} - {{ $customer->phone }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text">Görev bir müşteri ile ilgiliyse seçin</small>
                                        @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="policy_id" class="form-label">Poliçe</label>
                                        <select class="form-select @error('policy_id') is-invalid @enderror"
                                                id="policy_id"
                                                name="policy_id">
                                            <option value="">Poliçe seçiniz (opsiyonel)</option>
                                            @foreach($policies as $policy)
                                            <option value="{{ $policy->id }}"
                                                    {{ old('policy_id', $task->policy_id) == $policy->id ? 'selected' : '' }}>
                                                {{ $policy->policy_number }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text">Görev bir poliçe ile ilgiliyse seçin</small>
                                        @error('policy_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                          name="notes"
                                          rows="3"
                                          placeholder="Görev hakkında ek notlarınız...">{{ old('notes', $task->notes) }}</textarea>
                                <small class="form-text">İsteğe bağlı - Görevle ilgili özel notlar</small>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        <div class="danger-zone">
                            <div class="danger-zone-title">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Tehlikeli Alan
                            </div>
                            <p class="danger-zone-text">
                                Görevi silmek kalıcı bir işlemdir ve geri alınamaz. Tüm görev verileri silinecektir.
                            </p>
                            <button type="button" class="btn btn-danger btn-delete" onclick="confirmDelete()">
                                <i class="bi bi-trash me-2"></i>Görevi Sil
                            </button>
                        </div>
                    </div>

                    <!-- Sağ Kolon -->
                    <div class="col-lg-4">
                        <!-- Durum ve Atama -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="section-title">
                                    <i class="bi bi-person-check"></i>
                                    <span>Durum & Atama</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">
                                        Görev Durumu <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                                        <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                        <option value="cancelled" {{ old('status', $task->status) === 'cancelled' ? 'selected' : '' }}>İptal</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="assigned_to" class="form-label">
                                        Atanan Kişi <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror"
                                            id="assigned_to"
                                            name="assigned_to"
                                            required>
                                        <option value="">Kişi seçiniz</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                                {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text">Görevi yapacak kişi</small>
                                    @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tarihler -->
                        <div class="form-card card">
                            <div class="card-header">
                                <h5 class="section-title">
                                    <i class="bi bi-calendar3"></i>
                                    <span>Tarih & Zaman</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">
                                        Bitiş Tarihi <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control @error('due_date') is-invalid @enderror"
                                           id="due_date"
                                           name="due_date"
                                           value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                                           required>
                                    @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="due_time" class="form-label">Bitiş Saati</label>
                                    <input type="time"
                                           class="form-control @error('due_time') is-invalid @enderror"
                                           id="due_time"
                                           name="due_time"
                                           value="{{ old('due_time', $task->due_date->format('H:i')) }}">
                                    <small class="form-text">İsteğe bağlı - Belirli bir saat varsa</small>
                                    @error('due_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="reminder_date" class="form-label">Hatırlatıcı Tarihi</label>
                                    <input type="date"
                                           class="form-control @error('reminder_date') is-invalid @enderror"
                                           id="reminder_date"
                                           name="reminder_date"
                                           value="{{ old('reminder_date', $task->reminder_date?->format('Y-m-d')) }}">
                                    <small class="form-text">İsteğe bağlı - Önceden hatırlatma</small>
                                    @error('reminder_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <i class="bi bi-check-circle me-2"></i>Değişiklikleri Kaydet
                            </button>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-light action-btn">
                                <i class="bi bi-x-circle me-2"></i>İptal
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Delete Form -->
            <form id="deleteForm" method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('⚠️ DİKKAT!\n\nBu görevi silmek istediğinizden emin misiniz?\n\n• Bu işlem geri alınamaz!\n• Tüm görev verileri silinecektir.\n\nDevam etmek istiyor musunuz?')) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        document.getElementById('deleteForm').submit();
    }
}

$(document).ready(function() {
    // Müşteri seçilince poliçeleri yükle
    $('#customer_id').on('change', function() {
        const customerId = $(this).val();
        const policySelect = $('#policy_id');
        const currentPolicyId = '{{ $task->policy_id }}';

        policySelect.empty().append('<option value="">Yükleniyor...</option>').prop('disabled', true);

        if (customerId) {
            $.ajax({
                url: `/panel/customers/${customerId}/policies`,
                method: 'GET',
                success: function(data) {
                    policySelect.empty().append('<option value="">Poliçe seçiniz (opsiyonel)</option>');
                    data.forEach(function(policy) {
                        const selected = policy.id == currentPolicyId ? 'selected' : '';
                        policySelect.append(`<option value="${policy.id}" ${selected}>${policy.policy_number}</option>`);
                    });
                    policySelect.prop('disabled', false);
                },
                error: function() {
                    policySelect.empty().append('<option value="">Poliçe seçiniz (opsiyonel)</option>');
                    policySelect.prop('disabled', false);
                }
            });
        } else {
            policySelect.empty().append('<option value="">Poliçe seçiniz (opsiyonel)</option>');
            policySelect.prop('disabled', false);
        }
    });

    // Form submit animasyonu
    $('#taskForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Kaydediliyor...');
    });

    // Unsaved changes warning
    let formChanged = false;

    $('#taskForm :input').on('change input', function() {
        formChanged = true;
    });

    $(window).on('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            return 'Kaydedilmemiş değişiklikleriniz var. Sayfadan ayrılmak istediğinizden emin misiniz?';
        }
    });

    $('#taskForm').on('submit', function() {
        formChanged = false;
    });

    // Input focus'ta invalid class'ını kaldır
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
