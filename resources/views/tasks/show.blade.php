@extends('layouts.app')

@section('title', 'Görev Detayı')

@push('styles')
<style>
    .detail-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .info-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1rem 1.25rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: #6c757d;
        font-size: 1.125rem;
    }

    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.8125rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #212529;
        font-weight: 600;
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

    .btn-primary.action-btn,
    .btn-info.action-btn,
    .btn-success.action-btn,
    .btn-warning.action-btn {
        border-color: transparent;
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 8px;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .assignee-box {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .avatar-circle {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
        background: #e3f2fd;
        color: #1976d2;
        border: 3px solid #90caf9;
        flex-shrink: 0;
    }

    .avatar-circle.small {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 1rem;
        border-width: 2px;
    }

    .assignee-info h5 {
        margin-bottom: 0.25rem;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .assignee-info small {
        color: #6c757d;
    }

    .category-display {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .category-display i {
        font-size: 1.125rem;
        color: #495057;
    }

    .description-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        line-height: 1.7;
        color: #212529;
        white-space: pre-wrap;
    }

    .notes-box {
        background: #fff8e1;
        border: 1px solid #ffe082;
        border-radius: 10px;
        padding: 1.25rem;
        line-height: 1.6;
        color: #212529;
        white-space: pre-wrap;
    }

    .comment-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1.25rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .comment-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .comment-content {
        flex: 1;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .comment-author {
        font-weight: 600;
        color: #212529;
    }

    .comment-time {
        font-size: 0.8125rem;
        color: #6c757d;
    }

    .comment-text {
        color: #495057;
        line-height: 1.6;
        margin: 0;
        white-space: pre-wrap;
    }

    .comment-form {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .comment-form textarea {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.75rem;
        resize: vertical;
    }

    .comment-form textarea:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .comment-form .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    .count-badge {
        background: #0d6efd;
        color: #ffffff;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .assignee-box {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div class="flex-grow-1">
                <h1 class="h3 mb-2 fw-bold text-dark">{{ $task->title }}</h1>
                <p class="text-muted mb-0 small">
                    <i class="bi bi-calendar3 me-1"></i>
                    Vade: {{ $task->due_date->format('d.m.Y H:i') }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'pending' => ['color' => 'warning', 'label' => 'Bekliyor', 'icon' => 'clock'],
                        'in_progress' => ['color' => 'info', 'label' => 'Devam Ediyor', 'icon' => 'play-circle'],
                        'completed' => ['color' => 'success', 'label' => 'Tamamlandı', 'icon' => 'check-circle'],
                        'cancelled' => ['color' => 'secondary', 'label' => 'İptal', 'icon' => 'x-circle'],
                    ];
                    $status = $statusConfig[$task->status] ?? ['color' => 'secondary', 'label' => $task->status, 'icon' => 'circle'];
                @endphp
                <span class="badge badge-modern bg-{{ $status['color'] }}">
                    <i class="bi bi-{{ $status['icon'] }}"></i>
                    {{ $status['label'] }}
                </span>

                @if(!in_array($task->status, ['completed', 'cancelled']))
                <div class="btn-group">
                    @if($task->status === 'pending')
                    <button type="button" class="btn btn-info action-btn" onclick="updateStatus('in_progress')">
                        <i class="bi bi-play-circle me-1"></i>Başla
                    </button>
                    @endif
                    @if($task->status === 'in_progress')
                    <button type="button" class="btn btn-success action-btn" onclick="updateStatus('completed')">
                        <i class="bi bi-check-circle me-1"></i>Tamamla
                    </button>
                    @endif
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning action-btn">
                        <i class="bi bi-pencil me-1"></i>Düzenle
                    </a>
                </div>
                @endif

                <a href="{{ route('tasks.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Sidebar -->
        <div class="col-lg-4">
            <!-- Atanan Kişi -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-person-check"></i>
                        <span>Atanan Kişi</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="assignee-box">
                        <div class="avatar-circle">
                            {{ substr($task->assignedTo->name, 0, 1) }}
                        </div>
                        <div class="assignee-info">
                            <h5>{{ $task->assignedTo->name }}</h5>
                            <small>{{ $task->assignedTo->email }}</small>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Atayan Kişi</div>
                        <div class="info-value">{{ $task->assignedBy->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Kategori ve Öncelik -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-tags"></i>
                        <span>Kategori & Öncelik</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Kategori</div>
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
                        <div class="category-display">
                            <i class="bi bi-{{ $category['icon'] }}"></i>
                            <span class="fw-semibold">{{ $category['label'] }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Öncelik Seviyesi</div>
                        @php
                            $priorityConfig = [
                                'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                'normal' => ['color' => 'info', 'label' => 'Normal'],
                                'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                            ];
                            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                        @endphp
                        <span class="badge bg-{{ $priority['color'] }}" style="padding: 0.5rem 1rem; font-size: 0.9375rem;">
                            {{ $priority['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- İlişkili Kayıtlar -->
            @if($task->customer || $task->policy)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-link-45deg"></i>
                        <span>İlişkili Kayıtlar</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($task->customer)
                    <div class="info-item">
                        <div class="info-label">Müşteri</div>
                        <div class="info-value">
                            <a href="{{ route('customers.show', $task->customer) }}" class="text-decoration-none text-primary">
                                {{ $task->customer->name }}
                            </a>
                        </div>
                        <small class="text-muted">{{ $task->customer->phone }}</small>
                    </div>
                    @endif

                    @if($task->policy)
                    <div class="info-item">
                        <div class="info-label">Poliçe</div>
                        <div class="info-value">
                            <a href="{{ route('policies.show', $task->policy) }}" class="text-decoration-none text-primary">
                                {{ $task->policy->policy_number }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Tarihler -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-calendar3"></i>
                        <span>Tarih Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Vade Tarihi</div>
                        <div class="info-value">{{ $task->due_date->format('d.m.Y H:i') }}</div>
                    </div>

                    @if($task->reminder_date)
                    <div class="info-item">
                        <div class="info-label">Hatırlatıcı</div>
                        <div class="info-value">{{ $task->reminder_date->format('d.m.Y') }}</div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">Oluşturulma</div>
                        <div class="info-value">{{ $task->created_at->format('d.m.Y H:i') }}</div>
                    </div>

                    @if($task->completed_at)
                    <div class="info-item">
                        <div class="info-label">Tamamlanma</div>
                        <div class="info-value text-success">{{ $task->completed_at->format('d.m.Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Açıklama -->
            @if($task->description)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-file-text"></i>
                        <span>Görev Açıklaması</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="description-box">{{ $task->description }}</div>
                </div>
            </div>
            @endif

            <!-- Notlar -->
            @if($task->notes)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-sticky"></i>
                        <span>Ek Notlar</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="notes-box">{{ $task->notes }}</div>
                </div>
            </div>
            @endif

            <!-- Yorumlar -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Yorumlar</span>
                        @if($task->comments->isNotEmpty())
                            <span class="count-badge">{{ $task->comments->count() }}</span>
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Yorum Listesi -->
                    @forelse($task->comments as $comment)
                    <div class="comment-item">
                        <div class="avatar-circle small">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-author">{{ $comment->user->name }}</span>
                                <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="comment-text">{{ $comment->comment }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="bi bi-chat-left"></i>
                        <p>Henüz yorum eklenmemiş</p>
                    </div>
                    @endforelse

                    <!-- Yorum Ekleme Formu -->
                    <div class="comment-form">
                        <form method="POST" action="{{ route('tasks.addComment', $task) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control"
                                          name="comment"
                                          rows="3"
                                          placeholder="Yorumunuzu yazın..."
                                          required></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-2"></i>Yorum Ekle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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

@push('scripts')
<script>
function updateStatus(status) {
    const statusLabels = {
        'in_progress': 'Devam Ediyor',
        'completed': 'Tamamlandı'
    };

    const label = statusLabels[status] || status;

    if (confirm(`Görev durumunu "${label}" olarak güncellemek istediğinizden emin misiniz?`)) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        document.getElementById('newStatus').value = status;
        document.getElementById('statusForm').submit();
    }
}
</script>
@endpush
