@extends('layouts.app')

@section('title', 'Yenileme Detayı')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-arrow-repeat me-2"></i>Yenileme Detayı
        </h1>
        <p class="text-muted mb-0">
            Poliçe: {{ $renewal->policy->policy_number }}
        </p>
    </div>
    <div>
        @php
            $statusConfig = [
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                'contacted' => ['color' => 'info', 'label' => 'İletişimde'],
                'renewed' => ['color' => 'success', 'label' => 'Yenilendi'],
                'lost' => ['color' => 'danger', 'label' => 'Kaybedildi'],
            ];
            $status = $statusConfig[$renewal->status] ?? ['color' => 'secondary', 'label' => $renewal->status];
        @endphp
        <span class="badge bg-{{ $status['color'] }} fs-6 me-2">
            {{ $status['label'] }}
        </span>
        <a href="{{ route('renewals.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Sol Kolon -->
    <div class="col-md-4">
        <!-- Müşteri Bilgileri -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-person me-2"></i>Müşteri Bilgileri
                </h6>
            </div>
            <div class="card-body">
                <h5 class="mb-3">
                    <a href="{{ route('customers.show', $renewal->policy->customer) }}" class="text-decoration-none">
                        {{ $renewal->policy->customer->name }}
                    </a>
                </h5>
                <div class="mb-2">
                    <i class="bi bi-telephone text-muted me-2"></i>
                    <a href="tel:{{ $renewal->policy->customer->phone }}" class="text-decoration-none">
                        {{ $renewal->policy->customer->phone }}
                    </a>
                </div>
                @if($renewal->policy->customer->email)
                <div class="mb-2">
                    <i class="bi bi-envelope text-muted me-2"></i>
                    <a href="mailto:{{ $renewal->policy->customer->email }}" class="text-decoration-none">
                        {{ $renewal->policy->customer->email }}
                    </a>
                </div>
                @endif
                @if($renewal->policy->customer->city)
                <div>
                    <i class="bi bi-geo-alt text-muted me-2"></i>
                    {{ $renewal->policy->customer->city }}
                </div>
                @endif
            </div>
        </div>

        <!-- Poliçe Bilgileri -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>Mevcut Poliçe
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Poliçe No</small>
                    <p class="mb-0">
                        <a href="{{ route('policies.show', $renewal->policy) }}" class="text-decoration-none">
                            <strong>{{ $renewal->policy->policy_number }}</strong>
                        </a>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Tür</small>
                    <p class="mb-0"><strong>{{ $renewal->policy->policy_type_label }}</strong></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Şirket</small>
                    <p class="mb-0"><strong>{{ $renewal->policy->insuranceCompany->name }}</strong></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Prim Tutarı</small>
                    <p class="mb-0"><strong>{{ number_format($renewal->policy->premium_amount, 2) }} ₺</strong></p>
                </div>
                <div>
                    <small class="text-muted">Bitiş Tarihi</small>
                    <p class="mb-0"><strong>{{ $renewal->policy->end_date->format('d.m.Y') }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Yenileme Tarihi -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="bi bi-calendar-check me-2"></i>Yenileme Tarihi
                </h6>
            </div>
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $renewal->renewal_date->format('d.m.Y') }}</h3>
                @php
                    $daysLeft = $renewal->days_until_renewal;
                @endphp
                @if($daysLeft > 0)
                    <span class="badge bg-{{ $daysLeft <= 7 ? 'danger' : ($daysLeft <= 30 ? 'warning' : 'info') }} fs-6">
                        {{ $daysLeft }} gün kaldı
                    </span>
                @elseif($daysLeft === 0)
                    <span class="badge bg-danger fs-6">Bugün</span>
                @else
                    <span class="badge bg-danger fs-6">{{ abs($daysLeft) }} gün geçti</span>
                @endif
            </div>
        </div>

        <!-- Öncelik -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-flag me-2"></i>Öncelik
                </h6>
            </div>
            <div class="card-body text-center">
                @php
                    $priorityConfig = [
                        'low' => ['color' => 'secondary', 'label' => 'Düşük', 'icon' => 'flag'],
                        'normal' => ['color' => 'info', 'label' => 'Normal', 'icon' => 'flag'],
                        'high' => ['color' => 'warning', 'label' => 'Yüksek', 'icon' => 'flag-fill'],
                        'critical' => ['color' => 'danger', 'label' => 'Kritik', 'icon' => 'flag-fill'],
                    ];
                    $priority = $priorityConfig[$renewal->priority] ?? ['color' => 'secondary', 'label' => 'Normal', 'icon' => 'flag'];
                @endphp
                <i class="bi bi-{{ $priority['icon'] }} text-{{ $priority['color'] }}" style="font-size: 3rem;"></i>
                <h4 class="mt-2 mb-0">{{ $priority['label'] }}</h4>
            </div>
        </div>
    </div>

    <!-- Sağ Kolon -->
    <div class="col-md-8">
        <!-- Hızlı İşlemler -->
        @if(in_array($renewal->status, ['pending', 'contacted']))
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>Hızlı İşlemler
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3">
                        <form method="POST" action="{{ route('renewals.sendReminder', $renewal) }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-send me-1"></i>Hatırlatıcı Gönder
                            </button>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#contactModal">
                            <i class="bi bi-telephone me-1"></i>İletişim Kaydet
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#renewedModal">
                            <i class="bi bi-check-circle me-1"></i>Yenilendi
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#lostModal">
                            <i class="bi bi-x-circle me-1"></i>Kaybedildi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- İletişim Geçmişi -->
        @if($renewal->contacted_at)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-chat-left-text me-2"></i>Son İletişim
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Tarih:</strong> {{ $renewal->contacted_at->format('d.m.Y H:i') }}
                </div>
                @if($renewal->contact_notes)
                <div class="mb-2">
                    <strong>Notlar:</strong>
                    <p class="mb-0">{{ $renewal->contact_notes }}</p>
                </div>
                @endif
                @if($renewal->next_contact_date)
                <div>
                    <strong>Sonraki İletişim:</strong> {{ $renewal->next_contact_date->format('d.m.Y') }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Hatırlatıcılar -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="bi bi-bell me-2"></i>Hatırlatıcılar
                </h6>
            </div>
            <div class="card-body">
                @if($renewal->reminders->isEmpty())
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-bell-slash" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Henüz hatırlatıcı gönderilmemiş.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Tarih</th>
                                    <th>Kanal</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($renewal->reminders->sortByDesc('created_at') as $reminder)
                                <tr>
                                    <td>{{ $reminder->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ strtoupper($reminder->channel) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $reminder->status === 'sent' ? 'success' : ($reminder->status === 'failed' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($reminder->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Yeni Poliçe (Eğer yenilendiyse) -->
        @if($renewal->status === 'renewed' && $renewal->newPolicy)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-check-circle me-2"></i>Yeni Poliçe
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Poliçe No:</strong> {{ $renewal->newPolicy->policy_number }}
                </p>
                <p class="mb-2">
                    <strong>Prim Tutarı:</strong> {{ number_format($renewal->newPolicy->premium_amount, 2) }} ₺
                </p>
                <p class="mb-3">
                    <strong>Başlangıç:</strong> {{ $renewal->newPolicy->start_date->format('d.m.Y') }}
                </p>
                <a href="{{ route('policies.show', $renewal->newPolicy) }}" class="btn btn-success w-100">
                    <i class="bi bi-eye me-2"></i>Poliçeyi Görüntüle
                </a>
            </div>
        </div>
        @endif

        <!-- Kayıp Nedeni (Eğer kaybedildiyse) -->
        @if($renewal->status === 'lost')
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0">
                    <i class="bi bi-x-circle me-2"></i>Kayıp Bilgileri
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Neden:</strong>
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
                @if($renewal->notes)
                <div>
                    <strong>Notlar:</strong>
                    <p class="mb-0">{{ $renewal->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- İletişim Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-telephone me-2"></i>İletişim Kaydet
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.contact', $renewal) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">İletişim Yöntemi</label>
                        <select class="form-select" name="contact_method" required>
                            <option value="phone">Telefon</option>
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notlar</label>
                        <textarea class="form-control" name="contact_notes" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sonraki İletişim Tarihi</label>
                        <input type="date" class="form-control" name="next_contact_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-info">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Yenilendi Modal -->
<div class="modal fade" id="renewedModal" tabindex="-1">
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
                    <div class="mb-3">
                        <label class="form-label">Yeni Poliçe</label>
                        <select class="form-select" name="new_policy_id" required>
                            <option value="">Poliçe Seçiniz</option>
                            <!-- Burada müşterinin aktif poliçeleri listelenecek -->
                        </select>
                        <small class="text-muted">Önce yeni poliçeyi oluşturmanız gerekiyor.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notlar</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">Tamamla</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Kaybedildi Modal -->
<div class="modal fade" id="lostModal" tabindex="-1">
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
                        <label class="form-label">Kayıp Nedeni</label>
                        <select class="form-select" name="lost_reason" required>
                            <option value="price">Fiyat</option>
                            <option value="service">Hizmet Kalitesi</option>
                            <option value="competitor">Rakip Firma</option>
                            <option value="customer_decision">Müşteri Kararı</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notlar</label>
                        <textarea class="form-control" name="notes" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
