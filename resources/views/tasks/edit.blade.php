@extends('layouts.app')

@section('title', 'Görev Düzenle')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil me-2"></i>Görev Düzenle
            </h1>
            <div>
                <a href="{{ route('tasks.show', $task) }}" class="btn btn-info">
                    <i class="bi bi-eye me-2"></i>Detay
                </a>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('tasks.update', $task) }}">
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
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Görev Başlığı <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $task->title) }}"
                                       required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Açıklama</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="4">{{ old('description', $task->description) }}</textarea>
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
                                        <option value="call" {{ old('category', $task->category) === 'call' ? 'selected' : '' }}>Arama</option>
                                        <option value="meeting" {{ old('category', $task->category) === 'meeting' ? 'selected' : '' }}>Toplantı</option>
                                        <option value="follow_up" {{ old('category', $task->category) === 'follow_up' ? 'selected' : '' }}>Takip</option>
                                        <option value="document" {{ old('category', $task->category) === 'document' ? 'selected' : '' }}>Evrak</option>
                                        <option value="renewal" {{ old('category', $task->category) === 'renewal' ? 'selected' : '' }}>Yenileme</option>
                                        <option value="payment" {{ old('category', $task->category) === 'payment' ? 'selected' : '' }}>Ödeme</option>
                                        <option value="quotation" {{ old('category', $task->category) === 'quotation' ? 'selected' : '' }}>Teklif</option>
                                        <option value="other" {{ old('category', $task->category) === 'other' ? 'selected' : '' }}>Diğer</option>
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="priority" class="form-label">
                                        Öncelik <span class="text-danger">*</span>
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
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-link-45deg me-2"></i>İlişkili Kayıtlar
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="customer_id" class="form-label">Müşteri</label>
                                    <select class="form-select" id="customer_id" name="customer_id">
                                        <option value="">Müşteri Seçiniz (Opsiyonel)</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $task->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="policy_id" class="form-label">Poliçe</label>
                                    <select class="form-select" id="policy_id" name="policy_id">
                                        <option value="">Poliçe Seçiniz (Opsiyonel)</option>
                                        @foreach($policies as $policy)
                                        <option value="{{ $policy->id }}" {{ old('policy_id', $task->policy_id) == $policy->id ? 'selected' : '' }}>
                                            {{ $policy->policy_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notlar -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-sticky me-2"></i>Notlar
                            </h5>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" name="notes" rows="3">{{ old('notes', $task->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sağ Kolon -->
                <div class="col-md-4">
                    <!-- Durum ve Atama -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="bi bi-person-check me-2"></i>Durum & Atama
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    Durum <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                    <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                                    <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                    <option value="cancelled" {{ old('status', $task->status) === 'cancelled' ? 'selected' : '' }}>İptal</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="assigned_to" class="form-label">
                                    Atanan Kişi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="assigned_to" name="assigned_to" required>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tarihler -->
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar3 me-2"></i>Tarihler
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">
                                    Vade Tarihi <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control"
                                       id="due_date"
                                       name="due_date"
                                       value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="due_time" class="form-label">Saat</label>
                                <input type="time"
                                       class="form-control"
                                       id="due_time"
                                       name="due_time"
                                       value="{{ old('due_time', $task->due_date->format('H:i')) }}">
                            </div>

                            <div class="mb-3">
                                <label for="reminder_date" class="form-label">Hatırlatıcı Tarihi</label>
                                <input type="date"
                                       class="form-control"
                                       id="reminder_date"
                                       name="reminder_date"
                                       value="{{ old('reminder_date', $task->reminder_date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Güncelle
                        </button>
                        <button type="button" class="btn btn-danger" onclick="deleteTask()">
                            <i class="bi bi-trash me-2"></i>Sil
                        </button>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">
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
@endsection

@push('scripts')
<script>
function deleteTask() {
    if (confirm('Bu görevi silmek istediğinizden emin misiniz?')) {
        document.getElementById('deleteForm').submit();
    }
}

$(document).ready(function() {
    // Müşteri seçilince poliçeleri yükle
    $('#customer_id').on('change', function() {
        const customerId = $(this).val();
        const policySelect = $('#policy_id');

        policySelect.empty().append('<option value="">Yükleniyor...</option>');

        if (customerId) {
            $.ajax({
                url: `/panel/customers/${customerId}/policies`,
                method: 'GET',
                success: function(data) {
                    policySelect.empty().append('<option value="">Poliçe Seçiniz (Opsiyonel)</option>');
                    data.forEach(function(policy) {
                        policySelect.append(`<option value="${policy.id}">${policy.policy_number}</option>`);
                    });
                },
                error: function() {
                    policySelect.empty().append('<option value="">Poliçe Seçiniz (Opsiyonel)</option>');
                }
            });
        } else {
            policySelect.empty().append('<option value="">Poliçe Seçiniz (Opsiyonel)</option>');
        }
    });
});
</script>
@endpush
