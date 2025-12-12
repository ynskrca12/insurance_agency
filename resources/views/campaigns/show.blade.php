@extends('layouts.app')

@section('title', 'Kampanya Detayı')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">{{ $campaign->name }}</h1>
        <p class="text-muted mb-0">
            <i class="bi bi-calendar3 me-1"></i>
            {{ $campaign->created_at->format('d.m.Y H:i') }}
        </p>
    </div>
    <div>
        @php
            $statusConfig = [
                'draft' => ['color' => 'warning', 'label' => 'Taslak'],
                'scheduled' => ['color' => 'info', 'label' => 'Zamanlanmış'],
                'sending' => ['color' => 'primary', 'label' => 'Gönderiliyor'],
                'sent' => ['color' => 'success', 'label' => 'Gönderildi'],
                'failed' => ['color' => 'danger', 'label' => 'Başarısız'],
            ];
            $status = $statusConfig[$campaign->status] ?? ['color' => 'secondary', 'label' => $campaign->status];
        @endphp
        <span class="badge bg-{{ $status['color'] }} fs-6 me-2">
            {{ $status['label'] }}
        </span>

        @if(in_array($campaign->status, ['draft', 'scheduled']))
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#testModal">
            <i class="bi bi-send-check me-2"></i>Test Gönder
        </button>
        <form method="POST" action="{{ route('campaigns.send', $campaign) }}" class="d-inline">
            @csrf
            <button type="submit"
                    class="btn btn-success"
                    onclick="return confirm('Kampanyayı göndermek istediğinizden emin misiniz?')">
                <i class="bi bi-send me-2"></i>Gönder
            </button>
        </form>
        @endif

        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-primary">{{ number_format($recipientStats['total']) }}</h2>
                <small class="text-muted">Toplam Alıcı</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-success">{{ number_format($recipientStats['sent']) }}</h2>
                <small class="text-muted">Gönderildi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-info">{{ number_format($recipientStats['delivered']) }}</h2>
                <small class="text-muted">İletildi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-danger">{{ number_format($recipientStats['failed']) }}</h2>
                <small class="text-muted">Başarısız</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Sol Kolon -->
    <div class="col-md-4">
        <!-- Kampanya Bilgileri -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Kampanya Bilgileri
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Kampanya Tipi</small>
                    <p class="mb-0">
                        @php
                            $typeConfig = [
                                'sms' => ['icon' => 'chat-dots', 'label' => 'SMS'],
                                'email' => ['icon' => 'envelope', 'label' => 'E-posta'],
                                'whatsapp' => ['icon' => 'whatsapp', 'label' => 'WhatsApp'],
                            ];
                            $type = $typeConfig[$campaign->type] ?? ['icon' => 'chat', 'label' => $campaign->type];
                        @endphp
                        <i class="bi bi-{{ $type['icon'] }} me-1"></i>
                        <strong>{{ $type['label'] }}</strong>
                    </p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Hedef Kitle</small>
                    <p class="mb-0">
                        @php
                            $targetLabels = [
                                'all' => 'Tüm Müşteriler',
                                'active_customers' => 'Aktif Müşteriler',
                                'policy_type' => 'Poliçe Türü',
                                'city' => 'Şehir',
                                'custom' => 'Özel',
                            ];
                        @endphp
                        <strong>{{ $targetLabels[$campaign->target_type] ?? $campaign->target_type }}</strong>
                    </p>
                </div>

                @if($campaign->scheduled_at)
                <div class="mb-3">
                    <small class="text-muted">Zamanlanmış Tarih</small>
                    <p class="mb-0">
                        <strong>{{ $campaign->scheduled_at->format('d.m.Y H:i') }}</strong>
                    </p>
                </div>
                @endif

                @if($campaign->started_at)
                <div class="mb-3">
                    <small class="text-muted">Başlangıç Zamanı</small>
                    <p class="mb-0">{{ $campaign->started_at->format('d.m.Y H:i') }}</p>
                </div>
                @endif

                @if($campaign->completed_at)
                <div class="mb-3">
                    <small class="text-muted">Tamamlanma Zamanı</small>
                    <p class="mb-0">{{ $campaign->completed_at->format('d.m.Y H:i') }}</p>
                </div>
                @endif

                <div>
                    <small class="text-muted">Oluşturan</small>
                    <p class="mb-0">{{ $campaign->createdBy->name }}</p>
                </div>
            </div>
        </div>

        <!-- İlerleme -->
        @if($campaign->status === 'sent' && $recipientStats['total'] > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>İlerleme
                </h6>
            </div>
            <div class="card-body">
                @php
                    $successRate = ($recipientStats['sent'] / $recipientStats['total']) * 100;
                @endphp
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <small>Başarı Oranı</small>
                        <small><strong>{{ number_format($successRate, 1) }}%</strong></small>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success"
                             role="progressbar"
                             style="width: {{ $successRate }}%">
                            {{ number_format($successRate, 1) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sağ Kolon -->
    <div class="col-md-8">
        <!-- Mesaj İçeriği -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-text me-2"></i>Mesaj İçeriği
                </h5>
            </div>
            <div class="card-body">
                @if($campaign->subject)
                <div class="mb-3">
                    <small class="text-muted">Konu</small>
                    <p class="mb-0"><strong>{{ $campaign->subject }}</strong></p>
                </div>
                <hr>
                @endif
                <div class="bg-light p-3 rounded">
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $campaign->message }}</p>
                </div>
            </div>
        </div>

        <!-- Alıcı Listesi -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-people me-2"></i>Alıcılar ({{ $campaign->recipients->count() }})
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Müşteri</th>
                                <th>İletişim</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaign->recipients->take(50) as $recipient)
                            <tr>
                                <td>
                                    <a href="{{ route('customers.show', $recipient->customer) }}" class="text-decoration-none">
                                        {{ $recipient->customer->name }}
                                    </a>
                                </td>
                                <td>
                                    <small>{{ $recipient->contact_value }}</small>
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
                                    <span class="badge bg-{{ $recipientStatus['color'] }}">
                                        {{ $recipientStatus['label'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($recipient->sent_at)
                                        <small>{{ $recipient->sent_at->format('d.m H:i') }}</small>
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
                <p class="text-muted text-center mb-0 mt-2">
                    <small>İlk 50 alıcı gösteriliyor. Toplam: {{ $campaign->recipients->count() }}</small>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Test Modal -->
<div class="modal fade" id="testModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-send-check me-2"></i>Test Mesajı Gönder
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('campaigns.test', $campaign) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
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
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Test mesajı gerçek bir alıcıya gönderilmeyecek, sadece önizleme amaçlıdır.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-info">
                        <i class="bi bi-send me-2"></i>Test Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
