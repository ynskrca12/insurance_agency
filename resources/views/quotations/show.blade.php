@extends('layouts.app')

@section('title', 'Teklif Detayı - ' . $quotation->quotation_number)

@push('styles')
<style>
    .detail-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
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

    .company-item {
        background: #fafafa;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .company-item:hover {
        background: #f5f5f5;
        border-color: #d0d0d0;
        transform: translateX(5px);
    }

    .company-item.recommended {
        background: #fff8e1;
        border: 2px solid #ffc107;
    }

    .company-item.lowest {
        background: #e8f5e9;
        border: 2px solid #4caf50;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
    }

    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-icon.created { background: #e0f2fe; color: #0284c7; }
    .activity-icon.updated { background: #fef3c7; color: #d97706; }
    .activity-icon.email_sent { background: #dbeafe; color: #2563eb; }
    .activity-icon.viewed { background: #f3e8ff; color: #9333ea; }
    .activity-icon.approved { background: #dcfce7; color: #16a34a; }
    .activity-icon.rejected { background: #fee2e2; color: #dc2626; }

    .tab-custom {
        border: none;
        border-bottom: 2px solid #e5e7eb;
    }

    .tab-custom .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #6b7280;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
    }

    .tab-custom .nav-link.active {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
        background: transparent;
    }

    .revision-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .document-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }

    .document-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #3b82f6;
        color: white;
        font-size: 1.5rem;
    }

    .email-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .email-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .email-status.sent { background: #dbeafe; color: #1e40af; }
    .email-status.opened { background: #dcfce7; color: #166534; }
    .email-status.clicked { background: #fef3c7; color: #92400e; }
    .email-status.failed { background: #fee2e2; color: #991b1b; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="flex-grow-1">
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-file-earmark-text me-2"></i>{{ $quotation->quotation_number }}
                </h1>
                <p class="text-muted mb-0 small">
                    {{ $quotation->typeDisplay }} Teklifi •
                    {{ $quotation->created_at->format('d.m.Y H:i') }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'draft' => ['color' => 'secondary', 'label' => 'Taslak', 'icon' => 'file-earmark'],
                        'sent' => ['color' => 'info', 'label' => 'Gönderildi', 'icon' => 'send-check'],
                        'viewed' => ['color' => 'primary', 'label' => 'Görüntülendi', 'icon' => 'eye-fill'],
                        'approved' => ['color' => 'warning', 'label' => 'Onaylandı', 'icon' => 'hand-thumbs-up'],
                        'rejected' => ['color' => 'danger', 'label' => 'Reddedildi', 'icon' => 'hand-thumbs-down'],
                        'converted' => ['color' => 'success', 'label' => 'Dönüştürüldü', 'icon' => 'check-circle-fill'],
                    ];
                    $config = $statusConfig[$quotation->status] ?? ['color' => 'secondary', 'label' => $quotation->status, 'icon' => 'circle-fill'];
                @endphp
                <span class="badge badge-modern bg-{{ $config['color'] }}">
                    <i class="bi bi-{{ $config['icon'] }}"></i>
                    {{ $config['label'] }}
                </span>

                <!-- PDF Print Butonu -->
                <a href="{{ route('quotations.print', $quotation) }}" target="_blank" class="btn btn-danger action-btn">
                    <i class="bi bi-file-pdf me-2"></i>PDF Çıktı Al
                </a>

                <!-- Email Butonu -->
                @if($quotation->status !== 'converted')
                <button type="button" class="btn btn-info action-btn text-white" data-bs-toggle="modal" data-bs-target="#emailModal">
                    <i class="bi bi-envelope me-2"></i>Email Gönder
                </button>
                @endif

                <!-- Link Kopyala -->
                <button type="button" class="btn btn-primary action-btn" onclick="copyShareLink()">
                    <i class="bi bi-share me-2"></i>Link Kopyala
                </button>

                <!-- Düzenle -->
                @if($quotation->status !== 'converted')
                <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-warning action-btn">
                    <i class="bi bi-pencil me-2"></i>Düzenle
                </a>
                @endif

                <!-- Poliçeye Dönüştür -->
                @if(in_array($quotation->status, ['approved', 'viewed']) && $quotation->status !== 'converted')
                <button type="button" class="btn btn-success action-btn" data-bs-toggle="modal" data-bs-target="#convertModal">
                    <i class="bi bi-arrow-right-circle me-2"></i>Poliçeye Dönüştür
                </button>
                @endif

                <!-- Geri -->
                <a href="{{ route('quotations.index') }}" class="btn btn-light action-btn">
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
                            <a href="{{ route('customers.show', $quotation->customer) }}" class="text-decoration-none text-dark">
                                {{ $quotation->customer->name }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">
                            <a href="tel:{{ $quotation->customer->phone }}" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone me-1"></i>{{ $quotation->customer->phone }}
                            </a>
                        </div>
                    </div>

                    @if($quotation->customer->email)
                    <div class="info-item">
                        <div class="info-label">E-posta</div>
                        <div class="info-value">
                            <a href="mailto:{{ $quotation->customer->email }}" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope me-1"></i>{{ $quotation->customer->email }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Geçerlilik -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-calendar-check"></i>
                        <span>Geçerlilik Durumu</span>
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">
                        {{ $quotation->valid_until->format('d.m.Y') }}
                    </div>
                    @if($quotation->isValid())
                        <span class="badge badge-modern bg-success">
                            <i class="bi bi-check-circle-fill"></i>
                            Geçerli ({{ $quotation->valid_until->diffForHumans() }})
                        </span>
                    @else
                        <span class="badge badge-modern bg-danger">
                            <i class="bi bi-x-circle-fill"></i>
                            Süresi Dolmuş
                        </span>
                    @endif
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-graph-up"></i>
                        <span>İstatistikler</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Görüntüleme</div>
                        <div class="info-value">{{ $quotation->view_count }} kez</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email Gönderimi</div>
                        <div class="info-value">
                            {{ $quotation->email_sent_count }} kez
                            @if($quotation->last_emailed_at)
                            <br><small class="text-muted">Son: {{ $quotation->last_emailed_at->diffForHumans() }}</small>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Revizyon Sayısı</div>
                        <div class="info-value">{{ $quotation->revisions->count() }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Dosya Sayısı</div>
                        <div class="info-value">{{ $quotation->documents->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Paylaşım Linki -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-share"></i>
                        <span>Paylaşım Linki</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text"
                               id="shareLink"
                               class="form-control"
                               value="{{ $quotation->share_url }}"
                               readonly>
                        <button class="btn btn-primary" onclick="copyShareLink()" title="Kopyala">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <small class="text-muted d-block mt-2">
                        Bu linki müşteriye göndererek teklifi görüntülemesini sağlayabilirsiniz.
                    </small>
                </div>
            </div>

            @if($quotation->status === 'converted' && $quotation->convertedPolicy)
            <!-- Dönüştürülen Poliçe -->
            <div class="info-card card border-success">
                <div class="card-header bg-success bg-opacity-10">
                    <h6 class="card-title text-success">
                        <i class="bi bi-check-circle"></i>
                        <span>Dönüştürülen Poliçe</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Poliçe Numarası</div>
                        <div class="info-value">{{ $quotation->convertedPolicy->policy_number }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Dönüşüm Tarihi</div>
                        <div class="info-value">{{ $quotation->converted_at->format('d.m.Y H:i') }}</div>
                    </div>
                    <a href="{{ route('policies.show', $quotation->convertedPolicy) }}"
                       class="btn btn-success action-btn w-100 mt-3">
                        <i class="bi bi-eye me-2"></i>Poliçeyi Görüntüle
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Tabs -->
            <ul class="nav nav-tabs tab-custom mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#companies" type="button">
                        <i class="bi bi-building me-2"></i>Şirket Teklifleri
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#emails" type="button">
                        <i class="bi bi-envelope me-2"></i>Emailler ({{ $quotation->emails->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documents" type="button">
                        <i class="bi bi-paperclip me-2"></i>Dosyalar ({{ $quotation->documents->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#revisions" type="button">
                        <i class="bi bi-clock-history me-2"></i>Revizyonlar ({{ $quotation->revisions->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity" type="button">
                        <i class="bi bi-activity me-2"></i>Aktivite
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Şirket Teklifleri -->
                <div class="tab-pane fade show active" id="companies">
                    <div class="info-card card">
                        <div class="card-body">
                            @forelse($quotation->items->sortBy('premium_amount') as $item)
                            <div class="company-item {{ $loop->first ? 'lowest' : '' }} {{ $item->is_recommended ? 'recommended' : '' }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ $item->insuranceCompany->name }}</h6>
                                        <small class="text-muted">{{ $item->insuranceCompany->code }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="price-value">{{ number_format($item->premium_amount, 2) }} ₺</div>
                                        <div class="mt-1">
                                            @if($loop->first)
                                            <span class="badge bg-success">
                                                <i class="bi bi-trophy-fill"></i> En Düşük
                                            </span>
                                            @endif
                                            @if($item->is_recommended)
                                            <span class="badge bg-warning">
                                                <i class="bi bi-star-fill"></i> Önerilen
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($item->coverage_summary)
                                <div class="mt-2 pt-2 border-top">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-shield-check me-1"></i>Teminatlar
                                    </small>
                                    <p class="mb-0 small">{{ $item->coverage_summary }}</p>
                                </div>
                                @endif
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #d0d0d0;"></i>
                                <h6 class="text-muted mt-3">Teklif Bulunamadı</h6>
                            </div>
                            @endforelse

                            @if($quotation->items->count() > 1)
                            <!-- Fiyat Karşılaştırması -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="mb-3 fw-bold">
                                    <i class="bi bi-bar-chart me-2"></i>Fiyat Karşılaştırması
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <small class="text-muted d-block">En Düşük</small>
                                        <h5 class="text-success mb-0">{{ number_format($quotation->lowest_price_item->premium_amount, 2) }} ₺</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted d-block">Ortalama</small>
                                        <h5 class="text-primary mb-0">{{ number_format($quotation->average_price, 2) }} ₺</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted d-block">En Yüksek</small>
                                        <h5 class="text-danger mb-0">{{ number_format($quotation->highest_price_item->premium_amount, 2) }} ₺</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Araç/Konut Bilgileri -->
                    @if($quotation->vehicle_info && count(array_filter($quotation->vehicle_info)) > 0)
                    <div class="info-card card mt-3">
                        <div class="card-header">
                            <h6 class="card-title">
                                <i class="bi bi-car-front"></i>
                                <span>Araç Bilgileri</span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach($quotation->vehicle_info as $key => $value)
                                    @if($value)
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">{{ ucfirst($key) }}</small>
                                        <strong>{{ $value }}</strong>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($quotation->property_info && count(array_filter($quotation->property_info)) > 0)
                    <div class="info-card card mt-3">
                        <div class="card-header">
                            <h6 class="card-title">
                                <i class="bi bi-house"></i>
                                <span>Konut Bilgileri</span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach($quotation->property_info as $key => $value)
                                    @if($value)
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">{{ ucfirst($key) }}</small>
                                        <strong>{{ $value }}</strong>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Emailler -->
                <div class="tab-pane fade" id="emails">
                    <div class="info-card card">
                        <div class="card-body">
                            @forelse($quotation->emails as $email)
                            <div class="email-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $email->recipient_email }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>{{ $email->recipient_name ?? '-' }}
                                        </small>
                                    </div>
                                    <span class="email-status {{ $email->status }}">
                                        <i class="bi bi-{{ $email->status === 'sent' ? 'send-check' : ($email->status === 'opened' ? 'eye' : ($email->status === 'clicked' ? 'cursor' : 'x-circle')) }}"></i>
                                        {{ ucfirst($email->status) }}
                                    </span>
                                </div>
                                <p class="mb-2"><strong>Konu:</strong> {{ $email->subject }}</p>
                                <small class="text-muted d-block">
                                    <i class="bi bi-clock me-1"></i>{{ $email->created_at->format('d.m.Y H:i') }}
                                    @if($email->open_count > 0)
                                    • <i class="bi bi-eye me-1"></i>{{ $email->open_count }}x açıldı
                                    @endif
                                    @if($email->click_count > 0)
                                    • <i class="bi bi-cursor me-1"></i>{{ $email->click_count }}x tıklandı
                                    @endif
                                </small>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-envelope-x" style="font-size: 4rem; color: #d0d0d0;"></i>
                                <h6 class="text-muted mt-3">Henüz email gönderilmedi</h6>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Dosyalar -->
                <div class="tab-pane fade" id="documents">
                    <div class="info-card card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-paperclip"></i>
                                    <span>Dosyalar</span>
                                </h6>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <i class="bi bi-upload me-2"></i>Dosya Yükle
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @forelse($quotation->documents as $document)
                            <div class="document-item">
                                <div class="document-icon">
                                    <i class="bi bi-file-earmark-{{ $document->file_type === 'application/pdf' ? 'pdf' : 'fill' }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $document->file_name }}</h6>
                                    <small class="text-muted">
                                        {{ $document->file_size_formatted }} •
                                        {{ $document->created_at->format('d.m.Y H:i') }} •
                                        {{ $document->uploadedBy->name }}
                                    </small>
                                    @if($document->description)
                                    <p class="mb-0 mt-1 small">{{ $document->description }}</p>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ $document->file_url }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form method="POST" action="{{ route('quotations.delete-document', [$quotation, $document]) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Dosyayı silmek istediğinizden emin misiniz?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-file-earmark-x" style="font-size: 4rem; color: #d0d0d0;"></i>
                                <h6 class="text-muted mt-3">Henüz dosya yüklenmedi</h6>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Revizyonlar -->
                <div class="tab-pane fade" id="revisions">
                    <div class="info-card card">
                        <div class="card-body">
                            @forelse($quotation->revisions as $revision)
                            <div class="revision-item">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0">Revizyon #{{ $revision->revision_number }}</h6>
                                        <small class="text-muted">
                                            {{ $revision->created_at->format('d.m.Y H:i') }} • {{ $revision->createdBy->name }}
                                        </small>
                                    </div>
                                    <span class="badge bg-info">{{ count($revision->items_data) }} şirket</span>
                                </div>
                                @if($revision->notes)
                                <p class="mb-0 small">{{ $revision->notes }}</p>
                                @endif
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-clock-history" style="font-size: 4rem; color: #d0d0d0;"></i>
                                <h6 class="text-muted mt-3">Henüz revizyon yok</h6>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Aktivite -->
                <div class="tab-pane fade" id="activity">
                    <div class="info-card card">
                        <div class="card-body">
                            @forelse($quotation->activityLogs as $log)
                            <div class="activity-item">
                                <div class="activity-icon {{ $log->action }}">
                                    <i class="bi bi-{{
                                        $log->action === 'created' ? 'plus-circle' :
                                        ($log->action === 'email_sent' ? 'envelope' :
                                        ($log->action === 'viewed' ? 'eye' :
                                        ($log->action === 'approved' ? 'check-circle' :
                                        ($log->action === 'rejected' ? 'x-circle' : 'pencil'))))
                                    }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0"><strong>{{ $log->description }}</strong></p>
                                    <small class="text-muted">
                                        {{ $log->user_name }} • {{ $log->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-activity" style="font-size: 4rem; color: #d0d0d0;"></i>
                                <h6 class="text-muted mt-3">Aktivite yok</h6>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-envelope me-2"></i>Email Gönder
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('quotations.send-email', $quotation) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Alıcı Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                               class="form-control"
                               name="recipient_email"
                               value="{{ $quotation->customer->email }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alıcı Adı</label>
                        <input type="text"
                               class="form-control"
                               name="recipient_name"
                               value="{{ $quotation->customer->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Özel Mesaj</label>
                        <textarea class="form-control"
                                  name="custom_message"
                                  rows="4"
                                  placeholder="Email'e eklemek istediğiniz özel mesaj..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="bi bi-send me-2"></i>Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-upload me-2"></i>Dosya Yükle
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('quotations.upload-document', $quotation) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Dosya <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="document" required>
                        <small class="text-muted">Maksimum 10MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Dosya Tipi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="document_type" required>
                            <option value="pdf">PDF</option>
                            <option value="contract">Sözleşme</option>
                            <option value="policy">Poliçe</option>
                            <option value="attachment">Ek Döküman</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Açıklama</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-2"></i>Yükle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Convert Modal -->
<div class="modal fade" id="convertModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-arrow-right-circle me-2"></i>Poliçeye Dönüştür
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('quotations.convert', $quotation) }}">
                @csrf
                <div class="modal-body">
                    <!-- Cari Bilgilendirme -->
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Otomatik Cari Kayıtları:</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Müşteri carisine <strong id="premium_for_customer">0₺</strong> borç kaydedilecek</li>
                            <li>Şirket carisine <strong id="net_for_company">0₺</strong> alacak kaydedilecek</li>
                            <li>Komisyon: <strong id="commission_info">0₺</strong></li>
                        </ul>
                    </div>

                    <!-- Şirket Seçimi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Seçilen Şirket <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="selected_item_id" id="selected_item_id" required>
                            <option value="">Şirket seçiniz</option>
                            @foreach($quotation->items->sortBy('premium_amount') as $item)
                            <option value="{{ $item->id }}"
                                    data-premium="{{ $item->premium_amount }}"
                                    data-commission-rate="{{ $item->insuranceCompany->getCommissionRate($quotation->quotation_type) }}"
                                    {{ $item->is_recommended ? 'selected' : '' }}>
                                {{ $item->insuranceCompany->name }} - {{ number_format($item->premium_amount, 2) }}₺
                                @if($item->is_recommended)
                                    (Önerilen)
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Başlangıç Tarihi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Başlangıç Tarihi <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               class="form-control"
                               name="start_date"
                               id="start_date"
                               value="{{ now()->format('Y-m-d') }}"
                               required>
                    </div>

                    <!-- Bitiş Tarihi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Bitiş Tarihi <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               class="form-control"
                               name="end_date"
                               id="end_date"
                               value="{{ now()->addYear()->format('Y-m-d') }}"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Poliçe Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Şirket seçildiğinde cari bilgilerini hesapla
$('#selected_item_id').on('change', function() {
    const selected = $(this).find(':selected');
    const premium = parseFloat(selected.data('premium')) || 0;
    const commissionRate = parseFloat(selected.data('commission-rate')) || 0;
    const commission = (premium * commissionRate) / 100;
    const netForCompany = premium - commission;

    $('#premium_for_customer').text(premium.toFixed(2) + '₺');
    $('#commission_info').text(commission.toFixed(2) + '₺ (' + commissionRate + '%)');
    $('#net_for_company').text(netForCompany.toFixed(2) + '₺');
});

// Sayfa yüklendiğinde seçili şirket varsa hesapla
$(document).ready(function() {
    if ($('#selected_item_id').val()) {
        $('#selected_item_id').trigger('change');
    }

    // Başlangıç tarihine göre bitiş tarihini otomatik ayarla
    $('#start_date').on('change', function() {
        const startDate = new Date($(this).val());
        if (!isNaN(startDate)) {
            const endDate = new Date(startDate);
            endDate.setFullYear(endDate.getFullYear() + 1);
            endDate.setDate(endDate.getDate() - 1);
            $('#end_date').val(endDate.toISOString().split('T')[0]);
        }
    });
});
</script>
@endpush
@endsection

@push('scripts')
<script>
function copyShareLink() {
    const link = document.getElementById('shareLink').value;
    navigator.clipboard.writeText(link).then(function() {
        const toast = `
            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Başarılı!</strong> Link kopyalandı.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').append(toast);

        setTimeout(function() {
            $('.alert').fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    });
}

$(document).ready(function() {
    // Payment type değişimi
    $('#payment_type').on('change', function() {
        if ($(this).val() === 'installment') {
            $('#installment_div').slideDown(300);
        } else {
            $('#installment_div').slideUp(300);
        }
    });
});
</script>
@endpush
