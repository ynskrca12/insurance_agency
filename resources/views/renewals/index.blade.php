@extends('layouts.app')

@section('title', 'Poliçe Yenilemeleri')

@push('styles')
<style>
    .table-danger {
        background-color: #f8d7da !important;
    }
    .table-warning {
        background-color: #fff3cd !important;
    }
.dataTables_length, .dataTables_filter {
        padding: 1rem 1.25rem;
    }

    .dataTables_info, .dataTables_paginate {
        padding: 1rem 1.25rem;
    }
    .dt-buttons {
        margin-bottom: 1rem;
    }
    .dt-buttons .btn {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
    }
    .btn-secondary {
        border: 1px solid #dcdcdc;
        background: #f8f8f8;
        color: #333;
    }
    .btn-secondary:hover {
        background: #e7e7e7;
    }
    .dataTables_paginate .paginate_button {
        padding: 0px 2px;
        margin: 0 2px;
        border-radius: 6px;
        cursor: pointer;
    }

    .dataTables_paginate .paginate_button.current {
        background: #1f3c88 !important;
        color: white !important;
        border-color: #1f3c88 !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f1f1f1;
    }
    .filter-card,
    .main-card {
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
    }
    .main-card .card-body {
        padding: 1.5rem;
    }
        .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .stat-card .card-body {
        padding: 1.25rem;
        text-align: center;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }
    .action-buttons {
        display: flex;
        gap: 0.25rem;
        justify-content: end
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
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-arrow-repeat me-2"></i>Poliçe Yenilemeleri
        </h1>
        <p class="text-muted mb-0" id="renewalCount">
            Toplam: <strong>{{ $renewals->count() }}</strong> yenileme
        </p>
    </div>
    <div>
        <a href="{{ route('renewals.calendar') }}" class="btn btn-info">
            <i class="bi bi-calendar3 me-2"></i>Takvim Görünümü
        </a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
            <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı
        </button>
    </div>
</div>


    <div class="row g-3 mb-4">
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                    <div class="stat-label">Toplam</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-success">{{ number_format($stats['pending']) }}</div>
                    <div class="stat-label">Bekliyor</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-warning">{{ number_format($stats['contacted']) }}</div>
                    <div class="stat-label">İletişimde</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-danger">{{ number_format($stats['critical']) }}</div>
                    <div class="stat-label">Kritik</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-secondary">{{ number_format($stats['renewed']) }}</div>
                    <div class="stat-label">Yenilendi</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-secondary">{{ number_format($stats['lost']) }}</div>
                    <div class="stat-label">Kaybedildi</div>
                </div>
            </div>
        </div>
    </div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-3">
            <!-- Durum -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Durum</label>
                <select id="filterStatus" class="form-select">
                    <option value="">Tüm Durumlar</option>
                    <option value="Bekliyor">Bekliyor</option>
                    <option value="İletişimde">İletişimde</option>
                    <option value="Yenilendi">Yenilendi</option>
                    <option value="Kaybedildi">Kaybedildi</option>
                </select>
            </div>

            <!-- Öncelik -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Öncelik</label>
                <select id="filterPriority" class="form-select">
                    <option value="">Tüm Öncelikler</option>
                    <option value="Düşük">Düşük</option>
                    <option value="Normal">Normal</option>
                    <option value="Yüksek">Yüksek</option>
                    <option value="Kritik">Kritik</option>
                </select>
            </div>

            <!-- Başlangıç Tarihi -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Başlangıç Tarihi</label>
                <input type="date" id="filterDateFrom" class="form-control">
            </div>

            <!-- Bitiş Tarihi -->
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Bitiş Tarihi</label>
                <input type="date" id="filterDateTo" class="form-control">
            </div>

            <!-- Temizle Butonu -->
            <div class="col-md-1">
                <label class="form-label small text-muted mb-1 d-none d-md-block">&nbsp;</label>
                <button type="button" class="btn btn-secondary w-100" onclick="clearFilters()">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tablo -->
    <div class="main-card card">
        <div class="card-body">
            <table id="renewalsTable" class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th width="50">#</th>
                        <th class="ps-4">Poliçe No</th>
                        <th>Müşteri</th>
                        <th>Tür</th>
                        <th>Şirket</th>
                        <th>Yenileme Tarihi</th>
                        <th>Kalan Gün</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th width="150" class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($renewals as $index => $renewal)
                    @php
                        $daysLeft = $renewal->days_until_renewal;
                        $isOverdue = $daysLeft < 0;
                        $isCritical = $daysLeft >= 0 && $daysLeft <= 7;
                        $isUrgent = $daysLeft > 7 && $daysLeft <= 30;

                        $rowClass = '';
                        if ($isOverdue) {
                            $rowClass = 'table-danger';
                        } elseif ($isCritical) {
                            $rowClass = 'table-warning';
                        }
                    @endphp
                    <tr class="{{ $rowClass }}" data-days="{{ $daysLeft }}">
                        <td></td>
                        <td class="ps-4">
                            @if($renewal->policy)
                                <a href="{{ route('policies.show', $renewal->policy->id) }}"
                                class="text-decoration-none">
                                    <strong>{{ $renewal->policy->policy_number }}</strong>
                                </a>
                            @else
                                <span class="text-muted">Poliçe bulunamadı</span>
                            @endif
                        </td>
                            <td>
                                @if($renewal->policy && $renewal->policy->customer)
                                    <a href="{{ route('customers.show', $renewal->policy->customer->id) }}"
                                    class="text-decoration-none text-dark">
                                        {{ $renewal->policy->customer->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Müşteri bulunamadı</span>
                                @endif

                            <br>
                            @if($renewal->policy && $renewal->policy->customer)
                                <small class="text-muted">
                                    {{ $renewal->policy->customer->phone }}
                                </small>
                            @endif

                        </td>
                        <td>
                            @if($renewal->policy && $renewal->policy->policy_type_label)
                                <span class="badge rounded-pill bg-info">
                                    {{ $renewal->policy->policy_type_label }}
                                </span>
                            @else
                                <span class="text-muted">Poliçe bulunamadı</span>
                            @endif
                        </td>
                        <td>
                            @if($renewal->policy && $renewal->policy->insuranceCompany)
                                <span class="badge rounded-pill bg-info">
                                    <small>{{ $renewal->policy->insuranceCompany->code }}</small>
                                </span>
                            @else
                                <span class="text-muted">Şirket kodu bulunamadı</span>
                            @endif
                        </td>
                        <td data-sort="{{ $renewal->renewal_date->format('Y-m-d') }}">
                            <strong>{{ $renewal->renewal_date->format('d.m.Y') }}</strong>
                        </td>
                        <td data-order="{{ $daysLeft }}">
                            @if($isOverdue)
                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    {{ abs($daysLeft) }} gün geçti
                                </span>
                            @elseif($isCritical)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $daysLeft }} gün
                                </span>
                            @elseif($isUrgent)
                                <span class="badge bg-info">
                                    {{ $daysLeft }} gün
                                </span>
                            @else
                                <span class="text-muted">{{ $daysLeft }} gün</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $priorityConfig = [
                                    'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                    'normal' => ['color' => 'info', 'label' => 'Normal'],
                                    'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                    'critical' => ['color' => 'danger', 'label' => 'Kritik'],
                                ];
                                $priority = $priorityConfig[$renewal->priority] ?? ['color' => 'secondary', 'label' => 'Normal'];
                            @endphp
                            <span class="badge bg-{{ $priority['color'] }}">
                                {{ $priority['label'] }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'contacted' => ['color' => 'info', 'label' => 'İletişimde'],
                                    'renewed' => ['color' => 'success', 'label' => 'Yenilendi'],
                                    'lost' => ['color' => 'danger', 'label' => 'Kaybedildi'],
                                ];
                                $status = $statusConfig[$renewal->status] ?? ['color' => 'secondary', 'label' => $renewal->status];
                            @endphp
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('renewals.show', $renewal) }}"
                                   class="btn-icon"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($renewal->status === 'pending')
                                <form method="POST" action="{{ route('renewals.sendReminder', $renewal) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn-icon"
                                            title="Hatırlatıcı Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Toplu Hatırlatıcı Modal -->
<div class="modal fade" id="bulkReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı Gönder
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.bulkSendReminders') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hedef Grup</label>
                        <select class="form-select" name="filter" required>
                            <option value="critical">Kritik (7 gün içinde - {{ $stats['critical'] }} adet)</option>
                            <option value="upcoming">Yaklaşan (30 gün içinde)</option>
                            <option value="all">Tümü (Bekliyor + İletişimde)</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Seçilen gruptaki tüm müşterilere SMS hatırlatıcısı gönderilecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send me-2"></i>Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#renewalsTable', {
        order: [[6, 'asc']], // Kalan güne göre sırala (en az kalan önce)
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [9] }, // İşlemler
            { targets: 5, type: 'date' }, // Yenileme tarihi
            { targets: 6, type: 'num' } // Kalan gün
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterPriority, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const priority = $('#filterPriority').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(8).search(status);
        } else {
            table.column(8).search('');
        }

        // Öncelik filtresi
        if (priority) {
            table.column(7).search(priority);
        } else {
            table.column(7).search('');
        }

        // Tarih filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[5]; // Yenileme tarihi sütunu
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
        $('#renewalCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> yenileme`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#renewalCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> yenileme`);
});

function clearFilters() {
    $('#filterStatus, #filterPriority, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#renewalsTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>
@endpush
