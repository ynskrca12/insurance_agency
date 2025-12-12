@extends('layouts.app')

@section('title', 'Görevler')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-check2-square me-2"></i>Görevler
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $tasks->total() }} görev</p>
    </div>
    <div>
        <a href="{{ route('tasks.kanban') }}" class="btn btn-info">
            <i class="bi bi-kanban me-2"></i>Kanban Görünümü
        </a>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Yeni Görev
        </a>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-3">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-primary">{{ number_format($stats['total']) }}</h3>
                <small class="text-muted">Toplam</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-warning">{{ number_format($stats['pending']) }}</h3>
                <small class="text-muted">Bekliyor</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-info">{{ number_format($stats['in_progress']) }}</h3>
                <small class="text-muted">Devam Ediyor</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-success">{{ number_format($stats['completed']) }}</h3>
                <small class="text-muted">Tamamlandı</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-danger">{{ number_format($stats['overdue']) }}</h3>
                <small class="text-muted">Gecikmiş</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-dark">{{ number_format($stats['my_tasks']) }}</h3>
                <small class="text-muted">Benim</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('tasks.index') }}" id="filterForm">
            <div class="row g-3">
                <!-- Arama -->
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0"
                               name="search"
                               placeholder="Görev ara..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Durum -->
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>İptal</option>
                    </select>
                </div>

                <!-- Öncelik -->
                <div class="col-md-2">
                    <select name="priority" class="form-select">
                        <option value="">Tüm Öncelikler</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Düşük</option>
                        <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Yüksek</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Acil</option>
                    </select>
                </div>

                <!-- Kategori -->
                <div class="col-md-2">
                    <select name="category" class="form-select">
                        <option value="">Tüm Kategoriler</option>
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
                <div class="col-md-2">
                    <select name="assigned_to" class="form-select">
                        <option value="">Tüm Kullanıcılar</option>
                        <option value="me" {{ request('assigned_to') === 'me' ? 'selected' : '' }}>Benim Görevlerim</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tarih Filtresi -->
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tablo -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Görev</th>
                        <th>Kategori</th>
                        <th>Müşteri</th>
                        <th>Atanan</th>
                        <th>Vade</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    @php
                        $isOverdue = $task->due_date < now() && !in_array($task->status, ['completed', 'cancelled']);
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                        <td class="ps-4">
                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none text-dark">
                                <strong>{{ $task->title }}</strong>
                            </a>
                            @if($task->description)
                            <br>
                            <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
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
                            <i class="bi bi-{{ $category['icon'] }} me-1"></i>
                            <small>{{ $category['label'] }}</small>
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
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary text-white me-2">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <small>{{ $task->assignedTo->name }}</small>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $task->due_date->format('d.m.Y') }}</strong>
                            @if($task->due_date->format('H:i') !== '00:00')
                                <br><small class="text-muted">{{ $task->due_date->format('H:i') }}</small>
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
                            <span class="badge bg-{{ $priority['color'] }}">
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
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="btn btn-outline-info"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!in_array($task->status, ['completed', 'cancelled']))
                                <a href="{{ route('tasks.edit', $task) }}"
                                   class="btn btn-outline-warning"
                                   title="Düzenle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                <button type="button"
                                        class="btn btn-outline-danger"
                                        onclick="deleteTask({{ $task->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-3 mt-2">Henüz görev bulunmuyor.</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>İlk Görevi Oluştur
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($tasks->hasPages())
<div class="mt-3">
    {{ $tasks->links() }}
</div>
@endif

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}
</style>
@endpush

@push('scripts')
<script>
function deleteTask(taskId) {
    if (confirm('Bu görevi silmek istediğinizden emin misiniz?')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/tasks/' + taskId;
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
            }, 500);
        }
    });
});
</script>
@endpush
