@extends('layouts.app')

@section('title', 'Görevler - Kanban')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-kanban me-2"></i>Kanban Görünümü
        </h1>
    </div>
    <div>
        <div class="form-check form-switch d-inline-block me-3">
            <input class="form-check-input"
                   type="checkbox"
                   id="myTasksToggle"
                   {{ request('my_tasks') === 'true' ? 'checked' : '' }}
                   onchange="toggleMyTasks()">
            <label class="form-check-label" for="myTasksToggle">
                Sadece Benim Görevlerim
            </label>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
            <i class="bi bi-list me-2"></i>Liste Görünümü
        </a>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Yeni Görev
        </a>
    </div>
</div>

<!-- Kanban Board -->
<div class="row g-3">
    <!-- Bekliyor -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="bi bi-clock me-2"></i>Bekliyor
                    <span class="badge bg-dark float-end">{{ $tasks->get('pending', collect())->count() }}</span>
                </h6>
            </div>
            <div class="card-body kanban-column" data-status="pending">
                @foreach($tasks->get('pending', collect()) as $task)
                <div class="kanban-card mb-2" data-task-id="{{ $task->id }}" draggable="true">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
                                    {{ $task->title }}
                                </a>
                            </h6>
                            @if($task->description)
                            <p class="card-text small text-muted mb-2">
                                {{ Str::limit($task->description, 60) }}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $priorityConfig = [
                                            'low' => 'secondary',
                                            'normal' => 'info',
                                            'high' => 'warning',
                                            'urgent' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityConfig[$task->priority] ?? 'secondary' }} badge-sm">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $task->due_date->format('d.m') }}
                                </small>
                            </div>
                            @if($task->customer)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i>
                                    {{ $task->customer->name }}
                                </small>
                            </div>
                            @endif
                            <div class="mt-2">
                                <div class="avatar-circle bg-primary text-white" style="width: 24px; height: 24px; font-size: 12px; display: inline-flex;">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <small class="ms-1">{{ $task->assignedTo->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($tasks->get('pending', collect())->isEmpty())
                <p class="text-muted text-center small">Görev yok</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Devam Ediyor -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-play-circle me-2"></i>Devam Ediyor
                    <span class="badge bg-dark float-end">{{ $tasks->get('in_progress', collect())->count() }}</span>
                </h6>
            </div>
            <div class="card-body kanban-column" data-status="in_progress">
                @foreach($tasks->get('in_progress', collect()) as $task)
                <div class="kanban-card mb-2" data-task-id="{{ $task->id }}" draggable="true">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
                                    {{ $task->title }}
                                </a>
                            </h6>
                            @if($task->description)
                            <p class="card-text small text-muted mb-2">
                                {{ Str::limit($task->description, 60) }}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $priorityConfig = [
                                            'low' => 'secondary',
                                            'normal' => 'info',
                                            'high' => 'warning',
                                            'urgent' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityConfig[$task->priority] ?? 'secondary' }} badge-sm">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $task->due_date->format('d.m') }}
                                </small>
                            </div>
                            @if($task->customer)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i>
                                    {{ $task->customer->name }}
                                </small>
                            </div>
                            @endif
                            <div class="mt-2">
                                <div class="avatar-circle bg-primary text-white" style="width: 24px; height: 24px; font-size: 12px; display: inline-flex;">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <small class="ms-1">{{ $task->assignedTo->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($tasks->get('in_progress', collect())->isEmpty())
                <p class="text-muted text-center small">Görev yok</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Tamamlandı -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-check-circle me-2"></i>Tamamlandı
                    <span class="badge bg-dark float-end">{{ $tasks->get('completed', collect())->count() }}</span>
                </h6>
            </div>
            <div class="card-body kanban-column" data-status="completed">
                @foreach($tasks->get('completed', collect()) as $task)
                <div class="kanban-card mb-2" data-task-id="{{ $task->id }}" draggable="true">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
                                    {{ $task->title }}
                                </a>
                            </h6>
                            @if($task->description)
                            <p class="card-text small text-muted mb-2">
                                {{ Str::limit($task->description, 60) }}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $priorityConfig = [
                                            'low' => 'secondary',
                                            'normal' => 'info',
                                            'high' => 'warning',
                                            'urgent' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityConfig[$task->priority] ?? 'secondary' }} badge-sm">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $task->due_date->format('d.m') }}
                                </small>
                            </div>
                            @if($task->customer)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i>
                                    {{ $task->customer->name }}
                                </small>
                            </div>
                            @endif
                            <div class="mt-2">
                                <div class="avatar-circle bg-primary text-white" style="width: 24px; height: 24px; font-size: 12px; display: inline-flex;">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <small class="ms-1">{{ $task->assignedTo->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($tasks->get('completed', collect())->isEmpty())
                <p class="text-muted text-center small">Görev yok</p>
                @endif
            </div>
        </div>
    </div>

    <!-- İptal -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-x-circle me-2"></i>İptal
                    <span class="badge bg-dark float-end">{{ $tasks->get('cancelled', collect())->count() }}</span>
                </h6>
            </div>
            <div class="card-body kanban-column" data-status="cancelled">
                @foreach($tasks->get('cancelled', collect()) as $task)
                <div class="kanban-card mb-2" data-task-id="{{ $task->id }}" draggable="true">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
                                    {{ $task->title }}
                                </a>
                            </h6>
                            @if($task->description)
                            <p class="card-text small text-muted mb-2">
                                {{ Str::limit($task->description, 60) }}
                            </p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $priorityConfig = [
                                            'low' => 'secondary',
                                            'normal' => 'info',
                                            'high' => 'warning',
                                            'urgent' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityConfig[$task->priority] ?? 'secondary' }} badge-sm">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $task->due_date->format('d.m') }}
                                </small>
                            </div>
                            @if($task->customer)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i>
                                    {{ $task->customer->name }}
                                </small>
                            </div>
                            @endif
                            <div class="mt-2">
                                <div class="avatar-circle bg-primary text-white" style="width: 24px; height: 24px; font-size: 12px; display: inline-flex;">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <small class="ms-1">{{ $task->assignedTo->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($tasks->get('cancelled', collect())->isEmpty())
                <p class="text-muted text-center small">Görev yok</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.kanban-column {
    min-height: 500px;
    max-height: 70vh;
    overflow-y: auto;
}

.kanban-card {
    cursor: move;
    transition: all 0.2s;
}

.kanban-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.kanban-card.dragging {
    opacity: 0.5;
}

.kanban-column.drag-over {
    background: #f8f9fa;
    border: 2px dashed #0d6efd;
}

.avatar-circle {
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
function toggleMyTasks() {
    const isChecked = document.getElementById('myTasksToggle').checked;
    window.location.href = '{{ route("tasks.kanban") }}' + (isChecked ? '?my_tasks=true' : '');
}

// Drag and Drop
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
                    this.appendChild(draggedElement);

                    // Sayaçları güncelle
                    updateColumnCounts();

                    // Bildirim göster
                    alert('Görev durumu güncellendi!');
                }.bind(this),
                error: function() {
                    alert('Durum güncellenirken bir hata oluştu.');
                }
            });
        }
    });
});

function updateColumnCounts() {
    document.querySelectorAll('.kanban-column').forEach(column => {
        const count = column.querySelectorAll('.kanban-card').length;
        const badge = column.closest('.card').querySelector('.badge');
        if (badge) {
            badge.textContent = count;
        }
    });
}
</script>
@endpush
