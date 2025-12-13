@extends('layouts.app')

@section('title', $insuranceCompany->name)

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .company-logo-header {
        max-height: 60px;
        max-width: 120px;
        object-fit: contain;
        margin-right: 1.5rem;
    }

    .company-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .company-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
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

    .btn-warning.action-btn {
        border-color: #ffc107;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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

    .info-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .info-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .card-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: #6c757d;
        font-size: 1.25rem;
    }

    .info-card .card-body {
        padding: 1.5rem;
    }

    .contact-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .contact-value {
        margin: 0;
    }

    .contact-value a {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-value a:hover {
        color: #0d6efd;
    }

    .contact-value i {
        color: #6c757d;
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

    .commission-table {
        margin-bottom: 0;
    }

    .commission-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
    }

    .commission-table tbody tr:last-child {
        border-bottom: none;
    }

    .commission-table td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
    }

    .commission-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }

    .product-name {
        font-weight: 600;
        color: #212529;
    }

    .progress-modern {
        height: 1.5rem;
        border-radius: 8px;
        background: #e9ecef;
        overflow: hidden;
        min-width: 120px;
    }

    .progress-bar-modern {
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        transition: width 0.6s ease;
    }

    .policy-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .policy-link:hover {
        color: #0d6efd;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .company-title {
            font-size: 1.5rem;
        }

        .progress-modern {
            min-width: 80px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div class="d-flex align-items-center flex-wrap gap-3">
                @if($insuranceCompany->logo)
                <img src="{{ asset('storage/' . $insuranceCompany->logo) }}"
                     alt="{{ $insuranceCompany->name }}"
                     class="company-logo-header rounded">
                @endif
                <div>
                    <h1 class="company-title">{{ $insuranceCompany->name }}</h1>
                    <div class="company-badges">
                        <span class="badge badge-modern bg-secondary">{{ $insuranceCompany->code }}</span>
                        <span class="badge badge-modern bg-{{ $insuranceCompany->status_color }}">{{ $insuranceCompany->status_label }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('insurance-companies.edit', $insuranceCompany) }}" class="btn btn-warning action-btn">
                    <i class="bi bi-pencil me-2"></i>Düzenle
                </a>
                <a href="{{ route('insurance-companies.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total_policies']) }}</div>
                <div class="stat-label">Toplam Poliçe</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['total_premium'], 2) }} ₺</div>
                <div class="stat-label">Toplam Prim</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['total_commission'], 2) }} ₺</div>
                <div class="stat-label">Toplam Komisyon</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['active_policies']) }}</div>
                <div class="stat-label">Aktif Poliçe</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Kolon -->
        <div class="col-lg-4">
            <!-- İletişim Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-telephone"></i>
                        <span>İletişim Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    @if($insuranceCompany->phone || $insuranceCompany->email || $insuranceCompany->website)
                        @if($insuranceCompany->phone)
                        <div class="contact-item">
                            <div class="contact-label">Telefon</div>
                            <p class="contact-value">
                                <a href="tel:{{ $insuranceCompany->phone }}">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ $insuranceCompany->phone }}</span>
                                </a>
                            </p>
                        </div>
                        @endif

                        @if($insuranceCompany->email)
                        <div class="contact-item">
                            <div class="contact-label">E-posta</div>
                            <p class="contact-value">
                                <a href="mailto:{{ $insuranceCompany->email }}">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ $insuranceCompany->email }}</span>
                                </a>
                            </p>
                        </div>
                        @endif

                        @if($insuranceCompany->website)
                        <div class="contact-item">
                            <div class="contact-label">Website</div>
                            <p class="contact-value">
                                <a href="{{ $insuranceCompany->website }}" target="_blank">
                                    <i class="bi bi-globe"></i>
                                    <span>{{ $insuranceCompany->website }}</span>
                                </a>
                            </p>
                        </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="bi bi-telephone-x"></i>
                            <p>İletişim bilgisi bulunmuyor</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Komisyon Oranları -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-percent"></i>
                        <span>Komisyon Oranları</span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <table class="commission-table table">
                        <tbody>
                            <tr>
                                <td><span class="product-name">Kasko</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_kasko, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="product-name">Trafik</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_trafik, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="product-name">Konut</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_konut, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="product-name">DASK</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_dask, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="product-name">Sağlık</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_saglik, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="product-name">Hayat</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_hayat, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="product-name">Tamamlayıcı Sağlık</span></td>
                                <td class="text-end">
                                    <span class="commission-badge">%{{ number_format($insuranceCompany->default_commission_tss, 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sağ Kolon -->
        <div class="col-lg-8">
            <!-- Poliçe Türü Dağılımı -->
            <div class="info-card card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Poliçe Türü Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($policyDistribution->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Poliçe Türü</th>
                                    <th class="text-end">Adet</th>
                                    <th class="text-end">Toplam Prim</th>
                                    <th class="text-end">Dağılım Oranı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $typeLabels = [
                                        'kasko' => 'Kasko',
                                        'trafik' => 'Trafik',
                                        'konut' => 'Konut',
                                        'dask' => 'DASK',
                                        'saglik' => 'Sağlık',
                                        'hayat' => 'Hayat',
                                        'tss' => 'Tamamlayıcı Sağlık',
                                    ];
                                @endphp
                                @foreach($policyDistribution as $type)
                                <tr>
                                    <td><strong class="product-name">{{ $typeLabels[$type->policy_type] ?? $type->policy_type }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($type->count) }}</strong></td>
                                    <td class="text-end"><strong class="text-success">{{ number_format($type->total_premium, 2) }} ₺</strong></td>
                                    <td class="text-end">
                                        @php
                                            $percentage = $stats['total_policies'] > 0 ? ($type->count / $stats['total_policies']) * 100 : 0;
                                        @endphp
                                        <div class="progress-modern">
                                            <div class="progress-bar-modern" style="width: {{ $percentage }}%">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="bi bi-file-earmark-text"></i>
                        <p>Henüz poliçe bulunmuyor</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Son Poliçeler -->
            <div class="info-card card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Son Poliçeler</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentPolicies->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Poliçe No</th>
                                    <th>Müşteri</th>
                                    <th>Tür</th>
                                    <th class="text-end">Prim Tutarı</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPolicies as $policy)
                                <tr>
                                    <td>
                                        <a href="{{ route('policies.show', $policy) }}" class="policy-link">
                                            {{ $policy->policy_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.show', $policy->customer) }}" class="policy-link">
                                            {{ $policy->customer->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @php
                                            $typeLabels = [
                                                'kasko' => 'Kasko',
                                                'trafik' => 'Trafik',
                                                'konut' => 'Konut',
                                                'dask' => 'DASK',
                                                'saglik' => 'Sağlık',
                                                'hayat' => 'Hayat',
                                                'tss' => 'TSS',
                                            ];
                                        @endphp
                                        <small class="text-muted">{{ $typeLabels[$policy->policy_type] ?? $policy->policy_type }}</small>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">{{ number_format($policy->premium_amount, 2) }} ₺</strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $policy->created_at->format('d.m.Y') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="bi bi-file-earmark-text"></i>
                        <p>Henüz poliçe bulunmuyor</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
