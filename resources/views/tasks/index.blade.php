@extends('layouts.app')

@section('title', 'Görevler')

@push('styles')
<style>
.page-header {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 1.3rem;
    margin-bottom: 1rem;
}
 /* Genel */
body {
    background-color: #f4f6f9;
}

.page-header h1 {
    font-size: 1.25rem;
    font-weight: 600;
}

.page-header p {
    font-size: 0.875rem;
}

/* Kart Yapısı */
.card {
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    box-shadow: none;
}

.card-body {
    padding: 1.25rem;
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

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-card .card-body {
        padding: 1.5rem;
    }

    .btn-secondary {
        border: 1px solid #dcdcdc;
        background: #f8f8f8;
        color: #333;
    }

    .dt-buttons .btn {
        margin-right: 0.5rem;
    }

    .row-overdue {
        background-color: #fff5f5 !important;
    }

    .badge-modern {
        font-weight: 500;
        font-size: 0.75rem;
        padding: 0.35em 0.6em;
        border-radius: 4px;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: #374151;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .avatar-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e5e7eb;
        color: #374151;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.25rem;
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
    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        font-size: 0.75rem;
        padding: 0.75rem 0;
    }

    .dt-buttons .btn {
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .task-title {
        font-weight: 600;
        color: #001f4d;
        font-size: 0.9375rem;
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
                <p class="text-muted mb-0 small" id="taskCount">
                    Toplam <strong>{{ $tasks->count() }}</strong> görev kaydı bulundu
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.kanban') }}" class="btn btn-info action-btn text-white">
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
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Bekliyor">Bekliyor</option>
                        <option value="Devam Ediyor">Devam Ediyor</option>
                        <option value="Tamamlandı">Tamamlandı</option>
                        <option value="İptal">İptal</option>
                    </select>
                </div>

                <!-- Öncelik -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Öncelik</label>
                    <select id="filterPriority" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Düşük">Düşük</option>
                        <option value="Normal">Normal</option>
                        <option value="Yüksek">Yüksek</option>
                        <option value="Acil">Acil</option>
                    </select>
                </div>

                <!-- Kategori -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Kategori</label>
                    <select id="filterCategory" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Arama">Arama</option>
                        <option value="Toplantı">Toplantı</option>
                        <option value="Takip">Takip</option>
                        <option value="Evrak">Evrak</option>
                        <option value="Yenileme">Yenileme</option>
                        <option value="Ödeme">Ödeme</option>
                        <option value="Teklif">Teklif</option>
                        <option value="Diğer">Diğer</option>
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Başlangıç</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Bitiş</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-12">
                    <button type="button" class="btn btn-secondary action-btn w-100" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="card-body">
            <table class="table table-hover" id="tasksTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Görev</th>
                        <th>Kategori</th>
                        <th>Müşteri</th>
                        <th>Atanan</th>
                        <th>Vade Tarihi</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th width="120" class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $index => $task)
                    @php
                        $isOverdue = $task->due_date < now() && !in_array($task->status, ['completed', 'cancelled']);
                    @endphp
                    <tr class="{{ $isOverdue ? 'row-overdue' : '' }}" data-overdue="{{ $isOverdue ? '1' : '0' }}">
                        <td></td>
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
                                <a href="{{ route('customers.show', $task->customer) }}" class="text-decoration-none customer-link">
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
                        <td data-sort="{{ $task->due_date->format('Y-m-d H:i:s') }}">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
        form.submit();
    }
}

$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#tasksTable', {
        order: [[5, 'asc']], // Vade tarihine göre sırala
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [8] }, // İşlemler
            { targets: 5, type: 'date' } // Vade tarihi
        ],
        createdRow: function(row, data, dataIndex) {
            // Gecikmiş satır sınıfını koru
            const tr = $(row);
            if (tr.attr('data-overdue') === '1') {
                tr.addClass('row-overdue');
            }
        }
    });

    // ✅ Filtreler
    $('#filterStatus, #filterPriority, #filterCategory, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const priority = $('#filterPriority').val();
        const category = $('#filterCategory').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(7).search(status);
        } else {
            table.column(7).search('');
        }

        // Öncelik filtresi
        if (priority) {
            table.column(6).search(priority);
        } else {
            table.column(6).search('');
        }

        // Kategori filtresi
        if (category) {
            table.column(2).search(category);
        } else {
            table.column(2).search('');
        }

        // Tarih aralığı filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[5]; // Vade tarihi sütunu
                    if (!dateStr || dateStr === '-') return true;

                    const dateParts = dateStr.match(/\d{2}\.\d{2}\.\d{4}/);
                    if (!dateParts) return true;

                    const parts = dateParts[0].split('.');
                    const rowDate = new Date(parts[2], parts[1] - 1, parts[0]);
                    const startDate = dateFrom ? new Date(dateFrom) : null;
                    const endDate = dateTo ? new Date(dateTo) : null;

                    if (startDate && rowDate < startDate) return false;
                    if (endDate && rowDate > endDate) return false;

                    return true;
                }
            );
        }

        table.draw();
    });

    // Sayfa değişince toplam sayıyı güncelle
    table.on('draw', function() {
        const info = table.page.info();
        $('#taskCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> görev`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#taskCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> görev`);
});

function clearFilters() {
    $('#filterStatus, #filterPriority, #filterCategory, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#tasksTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>
@endpush
