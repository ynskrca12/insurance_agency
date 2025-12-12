@extends('layouts.app')

@section('title', 'Görev Detayı')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">{{ $task->title }}</h1>
        <p class="text-muted mb-0">
            <i class="bi bi-calendar3 me-1"></i>
            {{ $task->due_date->format('d.m.Y H:i') }}
        </p>
    </div>
    <div>
        @php
            $statusConfig = [
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                'in_progress' => ['color' => 'info', 'label' => 'Devam Ediyor'],
                'completed' => ['color' => 'success', 'label' => 'Tamamlandı'],
                'cancelled' => ['color' => 'secondary', 'label' => 'İptal'],
            ];
            $status = $statusConfig[$task->status] ?? ['color' => 'secondary', 'label' => $task->status];
        @endphp
        <span class="badge bg-{{ $status['color'] }} fs-6 me-2">
            {{ $status['label'] }}
        </span>

        @if(!in_array($task->status, ['completed', 'cancelled']))
        <div class="btn-group">
            @if($task->status === 'pending')
            <button type="button" class="btn btn-info" onclick="updateStatus('in_progress')">
                <i class="bi bi-play-circle me-1"></i>Başla
            </button>
            @endif
            @if($task->status === 'in_progress')
            <button type="button" class="btn btn-success" onclick="updateStatus('completed')">
                <i class="bi bi-check-circle me-1"></i>Tamamla
            </button>
            @endif
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>Düzenle
            </a>
        </div>
        @endif

        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Sol Kolon -->
    <div class="col-md-4">
        <!-- Atanan Kişi -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-person-check me-2"></i>Atanan Kişi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-circle bg-primary text-white me-3" style="width: 50px; height: 50px; font-size: 20px;">
                        {{ substr($task->assignedTo->name, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $task->assignedTo->name }}</h5>
                        <small class="text-muted">{{ $task->assignedTo->email }}</small>
                    </div>
                </div>
                <hr>
                <div>
                    <small class="text-muted">Atayan Kişi</small>
                    <p class="mb-0">{{ $task->assignedBy->name }}</p>
                </div>
            </div>
        </div>

        <!-- Kategori ve Öncelik -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-tags me-2"></i>Kategori & Öncelik
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Kategori</small>
                    <p class="mb-0">
                        @php
                            $categoryConfig = [
                                'call' => ['icon' => 'telephone', 'label' => 'Arama'],
                                'meeting' => ['icon' => 'people', 'label' => 'Toplantı'],
                                'follow_up' => ['icon' => 'arrow-repeat', 'label' => 'Takip'],
                                'document' => ['icon' => 'file-earmark-text', 'label' => 'Evrak'],
                                'renewal' => ['icon' => 'arrow-clockwise', 'label' => 'Yenileme'],
                                'payment' => ['icon' => 'cash', 'label' => 'Ödeme'],
                                'quotation' => ['icon' => 'file-earmark-plus', 'label' => 'Teklif'],
                                'other' => ['icon' => 'three-dots', 'label' => 'Diğer'],
                            ];
                            $category = $categoryConfig[$task->category] ?? ['icon' => 'circle', 'label' => $task->category];
                        @endphp
                        <i class="bi bi-{{ $category['icon'] }} me-2"></i>
                        <strong>{{ $category['label'] }}</strong>
                    </p>
                </div>
                <div>
                    <small class="text-muted">Öncelik</small>
                    <p class="mb-0">
                        @php
                            $priorityConfig = [
                                'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                'normal' => ['color' => 'info', 'label' => 'Normal'],
                                'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                            ];
                            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                        @endphp
                        <span class="badge bg-{{ $priority['color'] }}">
                            {{ $priority['label'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- İlişkili Kayıtlar -->
        @if($task->customer || $task->policy)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-link-45deg me-2"></i>İlişkili Kayıtlar
                </h6>
            </div>
            <div class="card-body">
                @if($task->customer)
                <div class="mb-3">
                    <small class="text-muted">Müşteri</small>
                    <p class="mb-0">
                        <a href="{{ route('customers.show', $task->customer) }}" class="text-decoration-none">
                            <strong>{{ $task->customer->name }}</strong>
                        </a>
                        <br>
                        <small>{{ $task->customer->phone }}</small>
                    </p>
                </div>
                @endif

                @if($task->policy)
                <div>
                    <small class="text-muted">Poliçe</small>
                    <p class="mb-0">
                        <a href="{{ route('policies.show', $task->policy) }}" class="text-decoration-none">
                            <strong>{{ $task->policy->policy_number }}</strong>
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Tarihler -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="bi bi-calendar3 me-2"></i>Tarihler
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Vade Tarihi</small>
                    <p class="mb-0"><strong>{{ $task->due_date->format('d.m.Y H:i') }}</strong></p>
                </div>

                @if($task->reminder_date)
                <div class="mb-3">
                    <small class="text-muted">Hatırlatıcı</small>
                    <p class="mb-0"><strong>{{ $task->reminder_date->format('d.m.Y') }}</strong></p>
                </div>
                @endif

                <div class="mb-3">
                    <small class="text-muted">Oluşturulma</small>
                    <p class="mb-0">{{ $task->created_at->format('d.m.Y H:i') }}</p>
                </div>

                @if($task->completed_at)
                <div>
                    <small class="text-muted">Tamamlanma</small>
                    <p class="mb-0">{{ $task->completed_at->format('d.m.Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sağ Kolon -->
    <div class="col-md-8">
        <!-- Açıklama -->
        @if($task->description)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-text me-2"></i>Açıklama
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-wrap;">{{ $task->description }}</p>
            </div>
        </div>
        @endif

        <!-- Notlar -->
        @if($task->notes)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-sticky me-2"></i>Notlar
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-wrap;">{{ $task->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Yorumlar -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-chat-left-text me-2"></i>Yorumlar
                    @if($task->comments->isNotEmpty())
                        <span class="badge bg-primary">{{ $task->comments->count() }}</span>
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <!-- Yorum Listesi -->
                @forelse($task->comments as $comment)
                <div class="d-flex mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                    <div class="avatar-circle bg-secondary text-white me-3">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 mt-1" style="white-space: pre-wrap;">{{ $comment->comment }}</p>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Henüz yorum yok.</p>
                @endforelse

                <!-- Yorum Ekleme Formu -->
                <form method="POST" action="{{ route('tasks.addComment', $task) }}" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <textarea class="form-control"
                                  name="comment"
                                  rows="2"
                                  placeholder="Yorum ekle..."
                                  required></textarea>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Durum Güncelleme Formu -->
<form id="statusForm" method="POST" action="{{ route('tasks.updateStatus', $task) }}" style="display: none;">
    @csrf
    <input type="hidden" name="status" id="newStatus">
</form>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
    flex-shrink: 0;
}
</style>
@endpush

@push('scripts')
<script>
function updateStatus(status) {
    if (confirm('Görev durumunu güncellemek istediğinizden emin misiniz?')) {
        document.getElementById('newStatus').value = status;
        document.getElementById('statusForm').submit();
    }
}
</script>
@endpush
