@extends('layouts.app')

@section('title', 'Görevler - Kanban')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .kanban-board {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kanban-column-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 250px);
    }

    .kanban-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .kanban-header.pending {
        background: #fff8e1;
        border-bottom-color: #ffe082;
    }

    .kanban-header.in_progress {
        background: #e3f2fd;
        border-bottom-color: #90caf9;
    }

    .kanban-header.completed {
        background: #e8f5e9;
        border-bottom-color: #a5d6a7;
    }

    .kanban-header.cancelled {
        background: #f5f5f5;
        border-bottom-color: #e0e0e0;
    }

    .kanban-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        color: #212529;
        margin: 0;
    }

    .kanban-count {
        background: #ffffff;
        color: #495057;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid #dcdcdc;
    }

    .kanban-column {
        padding: 1rem;
        overflow-y: auto;
        flex: 1;
        min-height: 0;
    }

    .kanban-column::-webkit-scrollbar {
        width: 6px;
    }

    .kanban-column::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 3px;
    }

    .kanban-column::-webkit-scrollbar-thumb {
        background: #d0d0d0;
        border-radius: 3px;
    }

    .kanban-column::-webkit-scrollbar-thumb:hover {
        background: #b0b0b0;
    }

    .kanban-card {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: move;
        transition: all 0.3s ease;
    }

    .kanban-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #b0b0b0;
    }

    .kanban-card.dragging {
        opacity: 0.4;
        transform: rotate(2deg);
    }

    .kanban-column.drag-over {
        background: #f8f9fa;
        border: 2px dashed #0d6efd;
        border-radius: 8px;
    }

    .task-title-link {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        display: block;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .task-title-link:hover {
        color: #0d6efd;
    }

    .task-description {
        color: #6c757d;
        font-size: 0.8125rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .task-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .priority-badge {
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .task-date {
        font-size: 0.8125rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .task-customer {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .task-assignee {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f0f0;
    }

    .avatar-circle {
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.75rem;
        background: #e3f2fd;
        color: #1976d2;
        border: 2px solid #90caf9;
    }

    .assignee-name {
        font-size: 0.8125rem;
        color: #495057;
        font-weight: 500;
    }

    .empty-column {
        text-align: center;
        padding: 3rem 1rem;
        color: #9ca3af;
    }

    .empty-column i {
        font-size: 3rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .empty-column p {
        margin: 0;
        font-size: 0.875rem;
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

    .toggle-switch {
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin-right: 1rem;
    }

    .form-check-input {
        cursor: pointer;
        width: 2.5rem;
        height: 1.25rem;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-label {
        cursor: pointer;
        margin: 0;
        font-size: 0.9375rem;
        font-weight: 500;
        color: #495057;
    }

    @media (max-width: 1400px) {
        .kanban-board {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .kanban-board {
            grid-template-columns: 1fr;
        }

        .kanban-column-card {
            height: auto;
            min-height: 400px;
        }
    }

    .notification-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        display: none;
        animation: slideIn 0.3s ease;
    }

    .notification-toast.success {
        border-left: 4px solid #28a745;
    }

    .notification-toast.error {
        border-left: 4px solid #dc3545;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 fw-bold text-dark">
                    <i class="bi bi-kanban me-2"></i>Kanban Görünümü
                </h1>
                <p class="text-muted mb-0 small">Görevleri sürükle-bırak ile yönetin</p>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="toggle-switch">
                    <input class="form-check-input"
                           type="checkbox"
                           id="myTasksToggle"
                           {{ request('my_tasks') === 'true' ? 'checked' : '' }}
                           onchange="toggleMyTasks()">
                    <label class="form-check-label" for="myTasksToggle">
                        Sadece Benim Görevlerim
                    </label>
                </div>
                <a href="{{ route('tasks.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-list me-2"></i>Liste Görünümü
                </a>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary action-btn">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Görev
                </a>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board">
        <!-- Bekliyor -->
        <div class="kanban-column-card">
            <div class="kanban-header pending">
                <h6 class="kanban-title">
                    <i class="bi bi-clock"></i>
                    <span>Bekliyor</span>
                </h6>
                <span class="kanban-count">{{ $tasks->get('pending', collect())->count() }}</span>
            </div>
            <div class="kanban-column" data-status="pending">
                @forelse($tasks->get('pending', collect()) as $task)
                <div class="kanban-card" data-task-id="{{ $task->id }}" draggable="true">
                    <a href="{{ route('tasks.show', $task) }}" class="task-title-link">
                        {{ $task->title }}
                    </a>

                    @if($task->description)
                    <div class="task-description">
                        {{ Str::limit($task->description, 70) }}
                    </div>
                    @endif

                    <div class="task-meta">
                        @php
                            $priorityConfig = [
                                'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                'normal' => ['color' => 'info', 'label' => 'Normal'],
                                'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                            ];
                            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                        @endphp
                        <span class="badge priority-badge bg-{{ $priority['color'] }}">
                            {{ $priority['label'] }}
                        </span>
                        <div class="task-date">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $task->due_date->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    @if($task->customer)
                    <div class="task-customer">
                        <i class="bi bi-person"></i>
                        <span>{{ Str::limit($task->customer->name, 25) }}</span>
                    </div>
                    @endif

                    <div class="task-assignee">
                        <div class="avatar-circle">
                            {{ substr($task->assignedTo->name, 0, 1) }}
                        </div>
                        <span class="assignee-name">{{ Str::limit($task->assignedTo->name, 20) }}</span>
                    </div>
                </div>
                @empty
                <div class="empty-column">
                    <i class="bi bi-inbox"></i>
                    <p>Bekleyen görev yok</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Devam Ediyor -->
        <div class="kanban-column-card">
            <div class="kanban-header in_progress">
                <h6 class="kanban-title">
                    <i class="bi bi-play-circle"></i>
                    <span>Devam Ediyor</span>
                </h6>
                <span class="kanban-count">{{ $tasks->get('in_progress', collect())->count() }}</span>
            </div>
            <div class="kanban-column" data-status="in_progress">
                @forelse($tasks->get('in_progress', collect()) as $task)
                <div class="kanban-card" data-task-id="{{ $task->id }}" draggable="true">
                    <a href="{{ route('tasks.show', $task) }}" class="task-title-link">
                        {{ $task->title }}
                    </a>

                    @if($task->description)
                    <div class="task-description">
                        {{ Str::limit($task->description, 70) }}
                    </div>
                    @endif

                    <div class="task-meta">
                        @php
                            $priorityConfig = [
                                'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                'normal' => ['color' => 'info', 'label' => 'Normal'],
                                'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                            ];
                            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                        @endphp
                        <span class="badge priority-badge bg-{{ $priority['color'] }}">
                            {{ $priority['label'] }}
                        </span>
                        <div class="task-date">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $task->due_date->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    @if($task->customer)
                    <div class="task-customer">
                        <i class="bi bi-person"></i>
                        <span>{{ Str::limit($task->customer->name, 25) }}</span>
                    </div>
                    @endif

                    <div class="task-assignee">
                        <div class="avatar-circle">
                            {{ substr($task->assignedTo->name, 0, 1) }}
                        </div>
                        <span class="assignee-name">{{ Str::limit($task->assignedTo->name, 20) }}</span>
                    </div>
                </div>
                @empty
                <div class="empty-column">
                    <i class="bi bi-inbox"></i>
                    <p>Devam eden görev yok</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tamamlandı -->
        <div class="kanban-column-card">
            <div class="kanban-header completed">
                <h6 class="kanban-title">
                    <i class="bi bi-check-circle"></i>
                    <span>Tamamlandı</span>
                </h6>
                <span class="kanban-count">{{ $tasks->get('completed', collect())->count() }}</span>
            </div>
            <div class="kanban-column" data-status="completed">
                @forelse($tasks->get('completed', collect()) as $task)
                <div class="kanban-card" data-task-id="{{ $task->id }}" draggable="true">
                    <a href="{{ route('tasks.show', $task) }}" class="task-title-link">
                        {{ $task->title }}
                    </a>

                    @if($task->description)
                    <div class="task-description">
                        {{ Str::limit($task->description, 70) }}
                    </div>
                    @endif

                    <div class="task-meta">
                        @php
                            $priorityConfig = [
                                'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                'normal' => ['color' => 'info', 'label' => 'Normal'],
                                'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                            ];
                            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                        @endphp
                        <span class="badge priority-badge bg-{{ $priority['color'] }}">
                            {{ $priority['label'] }}
                        </span>
                        <div class="task-date">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $task->due_date->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    @if($task->customer)
                    <div class="task-customer">
                        <i class="bi bi-person"></i>
                        <span>{{ Str::limit($task->customer->name, 25) }}</span>
                    </div>
                    @endif

                    <div class="task-assignee">
                        <div class="avatar-circle">
                            {{ substr($task->assignedTo->name, 0, 1) }}
                        </div>
                        <span class="assignee-name">{{ Str::limit($task->assignedTo->name, 20) }}</span>
                    </div>
                </div>
                @empty
                <div class="empty-column">
                    <i class="bi bi-inbox"></i>
                    <p>Tamamlanan görev yok</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- İptal -->
        <div class="kanban-column-card">
            <div class="kanban-header cancelled">
                <h6 class="kanban-title">
                    <i class="bi bi-x-circle"></i>
                    <span>İptal</span>
                </h6>
                <span class="kanban-count">{{ $tasks->get('cancelled', collect())->count() }}</span>
            </div>
            <div class="kanban-column" data-status="cancelled">
                @forelse($tasks->get('cancelled', collect()) as $task)
                <div class="kanban-card" data-task-id="{{ $task->id }}" draggable="true">
                    <a href="{{ route('tasks.show', $task) }}" class="task-title-link">
                        {{ $task->title }}
                    </a>

                    @if($task->description)
                    <div class="task-description">
                        {{ Str::limit($task->description, 70) }}
                    </div>
                    @endif

                    <div class="task-meta">
                        @php
                            $priorityConfig = [
                                'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                'normal' => ['color' => 'info', 'label' => 'Normal'],
                                'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                            ];
                            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                        @endphp
                        <span class="badge priority-badge bg-{{ $priority['color'] }}">
                            {{ $priority['label'] }}
                        </span>
                        <div class="task-date">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $task->due_date->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    @if($task->customer)
                    <div class="task-customer">
                        <i class="bi bi-person"></i>
                        <span>{{ Str::limit($task->customer->name, 25) }}</span>
                    </div>
                    @endif

                    <div class="task-assignee">
                        <div class="avatar-circle">
                            {{ substr($task->assignedTo->name, 0, 1) }}
                        </div>
                        <span class="assignee-name">{{ Str::limit($task->assignedTo->name, 20) }}</span>
                    </div>
                </div>
                @empty
                <div class="empty-column">
                    <i class="bi bi-inbox"></i>
                    <p>İptal edilen görev yok</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div class="notification-toast" id="notificationToast">
    <span id="notificationMessage"></span>
</div>
@endsection

@push('scripts')
<script>
function toggleMyTasks() {
    const isChecked = document.getElementById('myTasksToggle').checked;
    window.location.href = '{{ route("tasks.kanban") }}' + (isChecked ? '?my_tasks=true' : '');
}

function showNotification(message, type = 'success') {
    const toast = document.getElementById('notificationToast');
    const messageEl = document.getElementById('notificationMessage');

    messageEl.textContent = message;
    toast.className = 'notification-toast ' + type;
    toast.style.display = 'block';

    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}

// Drag and Drop - ORIJINAL FONKSIYON KORUNDU
let draggedElement = null;

document.querySelectorAll('.kanban-card').forEach(card => {
    card.addEventListener('dragstart', function(e) {
        draggedElement = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    });

    card.addEventListener('dragend', function(e) {
        this.classList.remove('dragging');
    });
});

document.querySelectorAll('.kanban-column').forEach(column => {
    column.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
        e.dataTransfer.dropEffect = 'move';
    });

    column.addEventListener('dragleave', function(e) {
        this.classList.remove('drag-over');
    });

    column.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');

        if (draggedElement) {
            const taskId = draggedElement.dataset.taskId;
            const newStatus = this.dataset.status;

            // AJAX ile durumu güncelle
            $.ajax({
                url: `/panel/tasks/${taskId}/update-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function(response) {
                    // Kartı yeni kolona taşı
                    column.appendChild(draggedElement);

                    // Sayaçları güncelle
                    updateColumnCounts();

                    // Boş durum mesajlarını kontrol et
                    checkEmptyStates();

                    // Bildirim göster
                    showNotification('Görev durumu başarıyla güncellendi!', 'success');
                },
                error: function() {
                    showNotification('Durum güncellenirken bir hata oluştu.', 'error');
                }
            });
        }
    });
});

function updateColumnCounts() {
    document.querySelectorAll('.kanban-column').forEach(column => {
        const count = column.querySelectorAll('.kanban-card').length;
        const badge = column.closest('.kanban-column-card').querySelector('.kanban-count');
        if (badge) {
            badge.textContent = count;
        }
    });
}

function checkEmptyStates() {
    document.querySelectorAll('.kanban-column').forEach(column => {
        const cards = column.querySelectorAll('.kanban-card');
        const emptyState = column.querySelector('.empty-column');

        if (cards.length === 0 && !emptyState) {
            // Boş durum mesajı ekle
            const emptyDiv = document.createElement('div');
            emptyDiv.className = 'empty-column';
            emptyDiv.innerHTML = '<i class="bi bi-inbox"></i><p>Görev yok</p>';
            column.appendChild(emptyDiv);
        } else if (cards.length > 0 && emptyState) {
            // Boş durum mesajını kaldır
            emptyState.remove();
        }
    });
}
</script>
@endpush
