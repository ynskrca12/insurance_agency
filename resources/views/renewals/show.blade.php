@extends('layouts.app')

@section('title', 'Yenileme Detayı')

@push('styles')
<style>
    .detail-header {
        padding: 12px 0;
        margin-bottom: 1rem;
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
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
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

    .countdown-card {
        text-align: center;
        padding: 1.5rem;
    }

    .countdown-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .countdown-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
    }

    .priority-display {
        text-align: center;
        padding: 1.5rem;
    }

    .priority-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
    }

    .priority-label {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 0.75rem;
    }

    .quick-action-btn {
        border-radius: 8px;
        padding: 0.875rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .contact-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .contact-detail {
        margin-bottom: 1rem;
    }

    .contact-detail:last-child {
        margin-bottom: 0;
    }

    .contact-detail-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .contact-detail-value {
        font-size: 0.9375rem;
        color: #212529;
    }

    .reminder-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .reminder-item:hover {
        background: #f0f0f0;
    }

    .reminder-item:last-child {
        margin-bottom: 0;
    }

    .reminder-info {
        flex: 1;
    }

    .reminder-date {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .reminder-channel {
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .badge-pill {
        border-radius: 50px;
        padding: 0.375rem 0.875rem;
        font-size: 0.8125rem;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
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

    .lost-reason-box {
        background: #fff5f5;
        border: 1px solid #fee;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: 1fr 1fr;
        }

        .countdown-value {
            font-size: 2rem;
        }

        .priority-icon {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="flex-grow-1">
                <h1 class="h4 mb-1 fw-bold text-dark">
                    <i class="bi bi-arrow-repeat me-2"></i>Yenileme Detayı
                </h1>
                <p class="text-muted mb-0 small">
                    Poliçe: {{ $renewal->policy->policy_number }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'pending' => ['color' => 'warning', 'label' => 'Bekliyor', 'icon' => 'clock'],
                        'contacted' => ['color' => 'info', 'label' => 'İletişimde', 'icon' => 'telephone'],
                        'renewed' => ['color' => 'success', 'label' => 'Yenilendi', 'icon' => 'check-circle-fill'],
                        'lost' => ['color' => 'danger', 'label' => 'Kaybedildi', 'icon' => 'x-circle-fill'],
                    ];
                    $status = $statusConfig[$renewal->status] ?? ['color' => 'secondary', 'label' => $renewal->status, 'icon' => 'circle-fill'];
                @endphp
                <span class="badge badge-modern bg-{{ $status['color'] }}">
                    <i class="bi bi-{{ $status['icon'] }}"></i>
                    {{ $status['label'] }}
                </span>
                <a href="{{ route('renewals.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Sidebar -->
        <div class="col-lg-4">
            <!-- Müşteri Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-person"></i>
                        <span>Müşteri Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Müşteri Adı</div>
                        <div class="info-value">
                            <a href="{{ route('customers.show', $renewal->policy->customer) }}" class="customer-link">
                                {{ $renewal->policy->customer->name }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">
                            <a href="tel:{{ $renewal->policy->customer->phone }}" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone me-1"></i>{{ $renewal->policy->customer->phone }}
                            </a>
                        </div>
                    </div>

                    @if($renewal->policy->customer->email)
                    <div class="info-item">
                        <div class="info-label">E-posta</div>
                        <div class="info-value">
                            <a href="mailto:{{ $renewal->policy->customer->email }}" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope me-1"></i>{{ $renewal->policy->customer->email }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($renewal->policy->customer->city)
                    <div class="info-item">
                        <div class="info-label">Şehir</div>
                        <div class="info-value">
                            <i class="bi bi-geo-alt me-1"></i>{{ $renewal->policy->customer->city }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Poliçe Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Mevcut Poliçe</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Poliçe Numarası</div>
                        <div class="info-value">
                            <a href="{{ route('policies.show', $renewal->policy) }}" class="text-decoration-none text-primary">
                                {{ $renewal->policy->policy_number }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Poliçe Türü</div>
                        <div class="info-value">{{ $renewal->policy->policy_type_label }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Sigorta Şirketi</div>
                        <div class="info-value">{{ $renewal->policy->insuranceCompany->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Prim Tutarı</div>
                        <div class="info-value text-success">{{ number_format($renewal->policy->premium_amount, 2) }} ₺</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Bitiş Tarihi</div>
                        <div class="info-value">{{ $renewal->policy->end_date->format('d.m.Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Yenileme Tarihi -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-calendar-check"></i>
                        <span>Yenileme Tarihi</span>
                    </h6>
                </div>
                <div class="card-body countdown-card">
                    <div class="countdown-value">{{ $renewal->renewal_date->format('d.m.Y') }}</div>
                    @php
                        $daysLeft = $renewal->days_until_renewal;
                        $badgeColor = $daysLeft <= 0 ? 'danger' : ($daysLeft <= 7 ? 'danger' : ($daysLeft <= 30 ? 'warning' : 'info'));
                    @endphp
                    @if($daysLeft > 0)
                        <span class="countdown-badge bg-{{ $badgeColor }} text-white">
                            <i class="bi bi-clock-history me-1"></i>
                            {{ $daysLeft }} gün kaldı
                        </span>
                    @elseif($daysLeft === 0)
                        <span class="countdown-badge bg-danger text-white">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Bugün
                        </span>
                    @else
                        <span class="countdown-badge bg-danger text-white">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            {{ abs($daysLeft) }} gün geçti
                        </span>
                    @endif
                </div>
            </div>

            <!-- Öncelik -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-flag"></i>
                        <span>Öncelik Seviyesi</span>
                    </h6>
                </div>
                <div class="card-body priority-display">
                    @php
                        $priorityConfig = [
                            'low' => ['color' => 'secondary', 'label' => 'Düşük', 'icon' => 'flag'],
                            'normal' => ['color' => 'info', 'label' => 'Normal', 'icon' => 'flag'],
                            'high' => ['color' => 'warning', 'label' => 'Yüksek', 'icon' => 'flag-fill'],
                            'critical' => ['color' => 'danger', 'label' => 'Kritik', 'icon' => 'flag-fill'],
                        ];
                        $priority = $priorityConfig[$renewal->priority] ?? ['color' => 'secondary', 'label' => 'Normal', 'icon' => 'flag'];
                    @endphp
                    <i class="bi bi-{{ $priority['icon'] }} text-{{ $priority['color'] }} priority-icon"></i>
                    <h4 class="priority-label text-{{ $priority['color'] }}">{{ $priority['label'] }}</h4>
                </div>
            </div>
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Hızlı İşlemler -->
            @if(in_array($renewal->status, ['pending', 'contacted']))
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-lightning"></i>
                        <span>Hızlı İşlemler</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <form method="POST" action="{{ route('renewals.sendReminder', $renewal) }}">
                            @csrf
                            <button type="submit" class="quick-action-btn btn btn-success w-100">
                                <i class="bi bi-send me-1"></i>
                                Hatırlatıcı Gönder
                            </button>
                        </form>

                        <button type="button" class="quick-action-btn btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-telephone me-1"></i>
                            İletişim Kaydet
                        </button>

                        <button type="button" class="quick-action-btn btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#renewedModal">
                            <i class="bi bi-check-circle me-1"></i>
                            Yenilendi
                        </button>

                        <button type="button" class="quick-action-btn btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#lostModal">
                            <i class="bi bi-x-circle me-1"></i>
                            Kaybedildi
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- İletişim Geçmişi -->
            @if($renewal->contacted_at)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Son İletişim Bilgisi</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="contact-box">
                        <div class="contact-detail">
                            <div class="contact-detail-label">İletişim Tarihi</div>
                            <div class="contact-detail-value">
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ $renewal->contacted_at->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        @if($renewal->contact_notes)
                        <div class="contact-detail">
                            <div class="contact-detail-label">İletişim Notları</div>
                            <div class="contact-detail-value">{{ $renewal->contact_notes }}</div>
                        </div>
                        @endif

                        @if($renewal->next_contact_date)
                        <div class="contact-detail">
                            <div class="contact-detail-label">Sonraki İletişim</div>
                            <div class="contact-detail-value">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $renewal->next_contact_date->format('d.m.Y') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Hatırlatıcılar -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-bell"></i>
                        <span>Gönderilen Hatırlatıcılar</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($renewal->reminders->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-bell-slash"></i>
                            <h6 class="text-muted mb-1">Hatırlatıcı Yok</h6>
                            <p class="text-muted small mb-0">Henüz hiç hatırlatıcı gönderilmemiş.</p>
                        </div>
                    @else
                        @foreach($renewal->reminders->sortByDesc('created_at') as $reminder)
                        <div class="reminder-item">
                            <div class="reminder-info">
                                <div class="reminder-date">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $reminder->created_at->format('d.m.Y H:i') }}
                                </div>
                                <div class="reminder-channel">
                                    <span class="badge badge-pill bg-secondary">
                                        <i class="bi bi-{{ $reminder->channel === 'sms' ? 'chat-square-text' : ($reminder->channel === 'email' ? 'envelope' : 'telephone') }} me-1"></i>
                                        {{ strtoupper($reminder->channel) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-pill bg-{{ $reminder->status === 'sent' ? 'success' : ($reminder->status === 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($reminder->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Yeni Poliçe (Eğer yenilendiyse) -->
            @if($renewal->status === 'renewed' && $renewal->newPolicy)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-check-circle"></i>
                        <span>Yeni Poliçe Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="contact-box">
                        <div class="contact-detail">
                            <div class="contact-detail-label">Poliçe Numarası</div>
                            <div class="contact-detail-value">{{ $renewal->newPolicy->policy_number }}</div>
                        </div>
                        <div class="contact-detail">
                            <div class="contact-detail-label">Prim Tutarı</div>
                            <div class="contact-detail-value text-success">{{ number_format($renewal->newPolicy->premium_amount, 2) }} ₺</div>
                        </div>
                        <div class="contact-detail">
                            <div class="contact-detail-label">Başlangıç Tarihi</div>
                            <div class="contact-detail-value">{{ $renewal->newPolicy->start_date->format('d.m.Y') }}</div>
                        </div>
                    </div>
                    <a href="{{ route('policies.show', $renewal->newPolicy) }}"
                       class="btn btn-success action-btn w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>Poliçeyi Görüntüle
                    </a>
                </div>
            </div>
            @endif

            <!-- Kayıp Nedeni (Eğer kaybedildiyse) -->
            @if($renewal->status === 'lost')
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-x-circle"></i>
                        <span>Kayıp Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="lost-reason-box">
                        <div class="contact-detail">
                            <div class="contact-detail-label">Kayıp Nedeni</div>
                            <div class="contact-detail-value">
                                @php
                                    $lostReasons = [
                                        'price' => 'Fiyat',
                                        'service' => 'Hizmet Kalitesi',
                                        'competitor' => 'Rakip Firma',
                                        'customer_decision' => 'Müşteri Kararı',
                                        'other' => 'Diğer',
                                    ];
                                @endphp
                                {{ $lostReasons[$renewal->lost_reason] ?? $renewal->lost_reason }}
                            </div>
                        </div>
                        @if($renewal->notes)
                        <div class="contact-detail">
                            <div class="contact-detail-label">Notlar</div>
                            <div class="contact-detail-value">{{ $renewal->notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- İletişim Modal -->
<div class="modal fade modal-modern" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-telephone me-2"></i>İletişim Kaydı Oluştur
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.contact', $renewal) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">İletişim Yöntemi</label>
                        <select class="form-select" name="contact_method" required>
                            <option value="">Seçiniz</option>
                            <option value="phone">Telefon</option>
                            <option value="email">E-posta</option>
                            <option value="sms">SMS</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">İletişim Notları</label>
                        <textarea class="form-control"
                                  name="contact_notes"
                                  rows="4"
                                  placeholder="Görüşme detaylarını buraya yazın..."
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sonraki İletişim Tarihi</label>
                        <input type="date" class="form-control" name="next_contact_date">
                        <small class="form-text text-muted">İsteğe bağlı - Tekrar aranacak tarih</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-info action-btn">
                        <i class="bi bi-check-circle me-2"></i>Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Yenilendi Modal -->
<div class="modal fade modal-modern" id="renewedModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Yenileme Tamamlandı
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.markAsRenewed', $renewal) }}">
                @csrf
                <div class="modal-body">
                    <!-- Bilgilendirme -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Mevcut Poliçe:</strong> {{ $renewal->policy->policy_number }}
                        ({{ $renewal->policy->policy_type_label }})
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Yeni Poliçe <span class="text-danger">*</span>
                        </label>

                        @if($customerPolicies->count() > 0)
                            <select class="form-select" name="new_policy_id" required>
                                <option value="">Yeni poliçeyi seçiniz</option>
                                @foreach($customerPolicies as $policy)
                                    <option value="{{ $policy->id }}">
                                        {{ $policy->policy_number }} -
                                        {{ $policy->policy_type_label }} -
                                        {{ $policy->insuranceCompany->name }} -
                                        ({{ $policy->start_date->format('d.m.Y') }} / {{ $policy->end_date->format('d.m.Y') }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="bi bi-check-circle text-success me-1"></i>
                                {{ $customerPolicies->count() }} adet aktif poliçe bulundu
                            </small>
                        @else
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Müşterinin henüz yeni bir poliçesi yok!
                            </div>

                            <a href="{{ route('policies.create', ['customer_id' => $renewal->customer_id]) }}"
                               class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Önce Yeni Poliçe Oluştur
                            </a>

                            <select class="form-select" name="new_policy_id" disabled>
                                <option value="">Önce yeni poliçe oluşturun</option>
                            </select>
                            <small class="form-text text-danger">
                                <i class="bi bi-x-circle me-1"></i>
                                Yenileme işlemini tamamlamak için önce yeni poliçe oluşturmalısınız
                            </small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Yenileme Notları</label>
                        <textarea class="form-control"
                                  name="notes"
                                  rows="3"
                                  placeholder="Yenileme hakkında notlar (opsiyonel)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit"
                            class="btn btn-success action-btn"
                            {{ $customerPolicies->count() === 0 ? 'disabled' : '' }}>
                        <i class="bi bi-check-circle me-2"></i>Yenilemeyi Tamamla
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Kaybedildi Modal -->
<div class="modal fade modal-modern" id="lostModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-x-circle me-2"></i>Yenileme Kaybedildi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.markAsLost', $renewal) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kayıp Nedeni</label>
                        <select class="form-select" name="lost_reason" required>
                            <option value="">Neden seçiniz</option>
                            <option value="price">Fiyat - Daha uygun teklif buldu</option>
                            <option value="service">Hizmet Kalitesi - Memnun değil</option>
                            <option value="competitor">Rakip Firma - Başka firmaya geçti</option>
                            <option value="customer_decision">Müşteri Kararı - Sigorta yaptırmayacak</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Detaylı Açıklama</label>
                        <textarea class="form-control"
                                  name="notes"
                                  rows="4"
                                  placeholder="Kayıp hakkında detaylı bilgi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-danger action-btn">
                        <i class="bi bi-check-circle me-2"></i>Kaydet
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
    // Form submit animasyonu
    $('form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>İşleniyor...');
    });
});
</script>
@endpush
