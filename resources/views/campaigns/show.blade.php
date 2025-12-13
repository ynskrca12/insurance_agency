@extends('layouts.app')

@section('title', 'Kampanya Detayı')

@push('styles')
<style>
    .detail-header {
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
        font-size: 2.25rem;
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
    .btn-success.action-btn {
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

    .type-display {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .type-display i {
        font-size: 1.125rem;
        color: #495057;
    }

    .progress-card {
        background: #e8f5e9;
        border: 1px solid #a5d6a7;
        border-radius: 10px;
        padding: 1.25rem;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .progress-modern {
        height: 1.75rem;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #c8e6c9;
    }

    .progress-bar-modern {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .message-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        line-height: 1.7;
        color: #212529;
        white-space: pre-wrap;
    }

    .subject-box {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        padding: 0.875rem 1.125rem;
        margin-bottom: 1rem;
    }

    .subject-label {
        font-size: 0.75rem;
        color: #0066cc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .subject-text {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin: 0;
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
        padding: 0.875rem 1rem;
    }

    .table-modern tbody td {
        padding: 0.875rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .recipient-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .recipient-link:hover {
        color: #0d6efd;
    }

    .badge-sm {
        padding: 0.25rem 0.625rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 6px;
    }

    .table-footer {
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        padding: 0.875rem 1rem;
        text-align: center;
    }

    .modal-modern .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-modern .modal-body {
        padding: 1.5rem;
    }

    .modal-modern .modal-footer {
        background: #fafafa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .info-alert {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #0066cc;
    }

    .info-alert i {
        font-size: 1.25rem;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.75rem;
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
                <h1 class="h3 mb-2 fw-bold text-dark">{{ $campaign->name }}</h1>
                <p class="text-muted mb-0 small">
                    <i class="bi bi-calendar3 me-1"></i>
                    Oluşturulma: {{ $campaign->created_at->format('d.m.Y H:i') }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'draft' => ['color' => 'warning', 'label' => 'Taslak', 'icon' => 'file-earmark'],
                        'scheduled' => ['color' => 'info', 'label' => 'Zamanlanmış', 'icon' => 'clock'],
                        'sending' => ['color' => 'primary', 'label' => 'Gönderiliyor', 'icon' => 'arrow-repeat'],
                        'sent' => ['color' => 'success', 'label' => 'Gönderildi', 'icon' => 'check-circle'],
                        'failed' => ['color' => 'danger', 'label' => 'Başarısız', 'icon' => 'x-circle'],
                    ];
                    $status = $statusConfig[$campaign->status] ?? ['color' => 'secondary', 'label' => $campaign->status, 'icon' => 'circle'];
                @endphp
                <span class="badge badge-modern bg-{{ $status['color'] }}">
                    <i class="bi bi-{{ $status['icon'] }}"></i>
                    {{ $status['label'] }}
                </span>

                @if(in_array($campaign->status, ['draft', 'scheduled']))
                <button type="button" class="btn btn-info action-btn" data-bs-toggle="modal" data-bs-target="#testModal">
                    <i class="bi bi-send-check me-2"></i>Test Gönder
                </button>
                <form method="POST" action="{{ route('campaigns.send', $campaign) }}" class="d-inline">
                    @csrf
                    <button type="button"
                            class="btn btn-success action-btn"
                            onclick="confirmSend(this)">
                        <i class="bi bi-send me-2"></i>Gönder
                    </button>
                </form>
                @endif

                <a href="{{ route('campaigns.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($recipientStats['total']) }}</div>
                <div class="stat-label">Toplam Alıcı</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($recipientStats['sent']) }}</div>
                <div class="stat-label">Gönderildi</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($recipientStats['delivered']) }}</div>
                <div class="stat-label">İletildi</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($recipientStats['failed']) }}</div>
                <div class="stat-label">Başarısız</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Sidebar -->
        <div class="col-lg-4">
            <!-- Kampanya Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle"></i>
                        <span>Kampanya Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Kampanya Tipi</div>
                        @php
                            $typeConfig = [
                                'sms' => ['icon' => 'chat-dots', 'label' => 'SMS'],
                                'email' => ['icon' => 'envelope', 'label' => 'E-posta'],
                                'whatsapp' => ['icon' => 'whatsapp', 'label' => 'WhatsApp'],
                            ];
                            $type = $typeConfig[$campaign->type] ?? ['icon' => 'chat', 'label' => $campaign->type];
                        @endphp
                        <div class="type-display">
                            <i class="bi bi-{{ $type['icon'] }}"></i>
                            <span class="fw-semibold">{{ $type['label'] }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Hedef Kitle</div>
                        @php
                            $targetLabels = [
                                'all' => 'Tüm Müşteriler',
                                'active_customers' => 'Aktif Müşteriler',
                                'policy_type' => 'Poliçe Türü',
                                'city' => 'Şehir',
                                'custom' => 'Özel',
                            ];
                        @endphp
                        <div class="info-value">{{ $targetLabels[$campaign->target_type] ?? $campaign->target_type }}</div>
                    </div>

                    @if($campaign->scheduled_at)
                    <div class="info-item">
                        <div class="info-label">Zamanlanmış Tarih</div>
                        <div class="info-value">{{ $campaign->scheduled_at->format('d.m.Y H:i') }}</div>
                    </div>
                    @endif

                    @if($campaign->started_at)
                    <div class="info-item">
                        <div class="info-label">Başlangıç Zamanı</div>
                        <div class="info-value">{{ $campaign->started_at->format('d.m.Y H:i') }}</div>
                    </div>
                    @endif

                    @if($campaign->completed_at)
                    <div class="info-item">
                        <div class="info-label">Tamamlanma Zamanı</div>
                        <div class="info-value text-success">{{ $campaign->completed_at->format('d.m.Y H:i') }}</div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">Oluşturan Kişi</div>
                        <div class="info-value">{{ $campaign->createdBy->name }}</div>
                    </div>
                </div>
            </div>

            <!-- İlerleme -->
            @if($campaign->status === 'sent' && $recipientStats['total'] > 0)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Başarı Oranı</span>
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $successRate = ($recipientStats['sent'] / $recipientStats['total']) * 100;
                    @endphp
                    <div class="progress-card">
                        <div class="progress-label">
                            <span>Gönderim Başarısı</span>
                            <strong>{{ number_format($successRate, 1) }}%</strong>
                        </div>
                        <div class="progress-modern">
                            <div class="progress-bar-modern" style="width: {{ $successRate }}%">
                                {{ number_format($successRate, 1) }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Mesaj İçeriği -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-file-text"></i>
                        <span>Mesaj İçeriği</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($campaign->subject)
                    <div class="subject-box">
                        <div class="subject-label">Konu</div>
                        <p class="subject-text">{{ $campaign->subject }}</p>
                    </div>
                    @endif
                    <div class="message-box">{{ $campaign->message }}</div>
                </div>
            </div>

            <!-- Alıcı Listesi -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-people"></i>
                        <span>Alıcı Listesi ({{ $campaign->recipients->count() }})</span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Müşteri</th>
                                    <th>İletişim Bilgisi</th>
                                    <th>Durum</th>
                                    <th>Gönderim Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaign->recipients->take(50) as $recipient)
                                <tr>
                                    <td>
                                        <a href="{{ route('customers.show', $recipient->customer) }}" class="recipient-link">
                                            {{ $recipient->customer->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $recipient->contact_value }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $recipientStatusConfig = [
                                                'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                                'sent' => ['color' => 'success', 'label' => 'Gönderildi'],
                                                'delivered' => ['color' => 'info', 'label' => 'İletildi'],
                                                'failed' => ['color' => 'danger', 'label' => 'Başarısız'],
                                            ];
                                            $recipientStatus = $recipientStatusConfig[$recipient->status] ?? ['color' => 'secondary', 'label' => $recipient->status];
                                        @endphp
                                        <span class="badge badge-sm bg-{{ $recipientStatus['color'] }}">
                                            {{ $recipientStatus['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($recipient->sent_at)
                                            <small>{{ $recipient->sent_at->format('d.m.Y H:i') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($campaign->recipients->count() > 50)
                    <div class="table-footer">
                        <small class="text-muted">
                            İlk 50 alıcı gösteriliyor. Toplam: <strong>{{ $campaign->recipients->count() }}</strong> alıcı
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Modal -->
<div class="modal fade modal-modern" id="testModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-send-check me-2"></i>Test Mesajı Gönder
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('campaigns.test', $campaign) }}" id="testForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            @if($campaign->type === 'email')
                                E-posta Adresi
                            @else
                                Telefon Numarası
                            @endif
                        </label>
                        <input type="text"
                               class="form-control"
                               name="test_contact"
                               required
                               placeholder="{{ $campaign->type === 'email' ? 'test@example.com' : '0555 123 45 67' }}">
                    </div>
                    <div class="info-alert">
                        <i class="bi bi-info-circle"></i>
                        <span>Test mesajı gerçek bir alıcıya gönderilmeyecek, sadece önizleme amaçlıdır.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-info action-btn">
                        <i class="bi bi-send me-2"></i>Test Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmSend(button) {
    if (confirm('⚠️ DİKKAT!\n\nKampanyayı göndermek istediğinizden emin misiniz?\n\n• Tüm alıcılara mesaj gönderilecektir.\n• Bu işlem geri alınamaz!\n\nDevam etmek istiyor musunuz?')) {
        // Loading state
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Gönderiliyor...';

        // Submit form
        button.closest('form').submit();
    }
}

$(document).ready(function() {
    // Test form submit animasyonu
    $('#testForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Gönderiliyor...');
    });
});
</script>
@endpush
