@extends('layouts.app')

@section('title', 'Görevler')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        background: #fafafa;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
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

    .input-group-text {
        border: 1px solid #dcdcdc;
        border-right: none;
        background: #fafafa;
        color: #6c757d;
        border-radius: 8px 0 0 8px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control:focus {
        border-left: none;
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

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead {
        background: #fafafa;
        border-bottom: 2px solid #e8e8e8;
    }

    .table-modern thead th {
        border: none;
        color: #495057;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        white-space: nowrap;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .table-modern tbody tr.row-overdue {
        background: #fff5f5;
        border-left: 3px solid #dc3545;
    }

    .task-title {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
        font-size: 0.9375rem;
    }

    .task-title:hover {
        color: #0d6efd;
    }

    .task-description {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.25rem;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.625rem;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.8125rem;
        color: #495057;
    }

    .avatar-circle {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        background: #e3f2fd;
        color: #1976d2;
        border: 2px solid #90caf9;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-name {
        font-size: 0.875rem;
        color: #495057;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .btn-icon {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
        border-color: #999;
    }

    .btn-icon.btn-view:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-icon.btn-edit:hover {
        background: #ffc107;
        border-color: #ffc107;
        color: #000000;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 5rem;
        color: #d0d0d0;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #9ca3af;
        margin-bottom: 1.5rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-row {
        animation: fadeIn 0.4s ease forwards;
    }

    @media (max-width: 768px) {
        .table-modern {
            font-size: 0.875rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .action-buttons {
            flex-wrap: wrap;
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
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-check2-square me-2"></i>Görevler
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $tasks->total() }} görev kaydı bulundu</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.kanban') }}" class="btn btn-info action-btn">
                    <i class="bi bi-kanban me-2"></i>Kanban
                </a>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary action-btn">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Görev
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Toplam</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['pending']) }}</div>
                <div class="stat-label">Bekliyor</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['in_progress']) }}</div>
                <div class="stat-label">Devam Ediyor</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['completed']) }}</div>
                <div class="stat-label">Tamamlandı</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($stats['overdue']) }}</div>
                <div class="stat-label">Gecikmiş</div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-dark">{{ number_format($stats['my_tasks']) }}</div>
                <div class="stat-label">Benim</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Arama -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Arama</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Görev ara..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Durum -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tümü</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>İptal</option>
                        </select>
                    </div>

                    <!-- Öncelik -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Öncelik</label>
                        <select name="priority" class="form-select">
                            <option value="">Tümü</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Düşük</option>
                            <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Yüksek</option>
                            <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Acil</option>
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Tümü</option>
                            <option value="call" {{ request('category') === 'call' ? 'selected' : '' }}>Arama</option>
                            <option value="meeting" {{ request('category') === 'meeting' ? 'selected' : '' }}>Toplantı</option>
                            <option value="follow_up" {{ request('category') === 'follow_up' ? 'selected' : '' }}>Takip</option>
                            <option value="document" {{ request('category') === 'document' ? 'selected' : '' }}>Evrak</option>
                            <option value="renewal" {{ request('category') === 'renewal' ? 'selected' : '' }}>Yenileme</option>
                            <option value="payment" {{ request('category') === 'payment' ? 'selected' : '' }}>Ödeme</option>
                            <option value="quotation" {{ request('category') === 'quotation' ? 'selected' : '' }}>Teklif</option>
                            <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Diğer</option>
                        </select>
                    </div>

                    <!-- Atanan Kişi -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Atanan</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">Tümü</option>
                            <option value="me" {{ request('assigned_to') === 'me' ? 'selected' : '' }}>Benim Görevlerim</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtrele Butonu -->
                    <div class="col-lg-1 col-md-12">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Görev</th>
                        <th>Kategori</th>
                        <th>Müşteri</th>
                        <th>Atanan</th>
                        <th>Vade Tarihi</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    @php
                        $isOverdue = $task->due_date < now() && !in_array($task->status, ['completed', 'cancelled']);
                    @endphp
                    <tr class="fade-in-row {{ $isOverdue ? 'row-overdue' : '' }}">
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="task-title">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                            <div class="task-description">{{ Str::limit($task->description, 60) }}</div>
                            @endif
                        </td>
                        <td>
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
                            <span class="category-badge">
                                <i class="bi bi-{{ $category['icon'] }}"></i>
                                <span>{{ $category['label'] }}</span>
                            </span>
                        </td>
                        <td>
                            @if($task->customer)
                                <a href="{{ route('customers.show', $task->customer) }}" class="text-decoration-none">
                                    {{ $task->customer->name }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="avatar-circle">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <span class="user-name">{{ Str::limit($task->assignedTo->name, 15) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $task->due_date->format('d.m.Y') }}</div>
                            @if($task->due_date->format('H:i') !== '00:00')
                                <small class="text-muted">{{ $task->due_date->format('H:i') }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $priorityConfig = [
                                    'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                    'normal' => ['color' => 'info', 'label' => 'Normal'],
                                    'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                    'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                                ];
                                $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                            @endphp
                            <span class="badge badge-modern bg-{{ $priority['color'] }}">
                                {{ $priority['label'] }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'in_progress' => ['color' => 'info', 'label' => 'Devam Ediyor'],
                                    'completed' => ['color' => 'success', 'label' => 'Tamamlandı'],
                                    'cancelled' => ['color' => 'secondary', 'label' => 'İptal'],
                                ];
                                $status = $statusConfig[$task->status] ?? ['color' => 'secondary', 'label' => $task->status];
                            @endphp
                            <span class="badge badge-modern bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!in_array($task->status, ['completed', 'cancelled']))
                                <a href="{{ route('tasks.edit', $task) }}"
                                   class="btn-icon btn-edit"
                                   title="Düzenle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        onclick="deleteTask({{ $task->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Görev Bulunamadı</h5>
                                <p>
                                    @if(request()->hasAny(['search', 'status', 'priority', 'category', 'assigned_to']))
                                        Arama kriterlerinize uygun görev bulunamadı.
                                    @else
                                        Henüz hiç görev bulunmuyor.
                                    @endif
                                </p>
                                @if(!request()->hasAny(['search', 'status', 'priority', 'category', 'assigned_to']))
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary action-btn">
                                    <i class="bi bi-plus-circle me-2"></i>İlk Görevi Oluştur
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->links() }}
    </div>
    @endif
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteTask(taskId) {
    if (confirm('⚠️ Bu görevi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/tasks/' + taskId;

        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        form.submit();
    }
}

$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="priority"], select[name="category"], select[name="assigned_to"]')
        .on('change', function() {
            $('#filterForm').submit();
        });

    // Arama input debounce
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val();

        if (value.length >= 3 || value.length === 0) {
            searchTimeout = setTimeout(function() {
                $('#filterForm').submit();
            }, 600);
        }
    });

    // Satır animasyonları
    let delay = 0;
    $('.fade-in-row').each(function() {
        $(this).css({
            'animation-delay': delay + 's',
            'opacity': '0'
        });
        delay += 0.05;
    });

    setTimeout(function() {
        $('.fade-in-row').css('opacity', '1');
    }, 50);
});
</script>
@endpush
