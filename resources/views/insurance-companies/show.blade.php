@extends('layouts.app')

@section('title', $insuranceCompany->name)

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        @if($insuranceCompany->logo)
        <img src="{{ asset('storage/' . $insuranceCompany->logo) }}"
             alt="{{ $insuranceCompany->name }}"
             class="me-3 rounded"
             style="max-height: 60px; max-width: 120px;">
        @endif
        <div>
            <h1 class="h3 mb-0">{{ $insuranceCompany->name }}</h1>
            <p class="text-muted mb-0">
                <span class="badge bg-secondary me-2">{{ $insuranceCompany->code }}</span>
                <span class="badge bg-{{ $insuranceCompany->status_color }}">{{ $insuranceCompany->status_label }}</span>
            </p>
        </div>
    </div>
    <div>
        <a href="{{ route('insurance-companies.edit', $insuranceCompany) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('insurance-companies.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-primary">{{ number_format($stats['total_policies']) }}</h2>
                <small class="text-muted">Toplam Poliçe</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-success">{{ number_format($stats['total_premium'], 2) }} ₺</h2>
                <small class="text-muted">Toplam Prim</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-warning">{{ number_format($stats['total_commission'], 2) }} ₺</h2>
                <small class="text-muted">Toplam Komisyon</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-info">{{ number_format($stats['active_policies']) }}</h2>
                <small class="text-muted">Aktif Poliçe</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Sol Kolon -->
    <div class="col-md-4">
        <!-- İletişim Bilgileri -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-telephone me-2"></i>İletişim Bilgileri
                </h6>
            </div>
            <div class="card-body">
                @if($insuranceCompany->phone)
                <div class="mb-2">
                    <small class="text-muted">Telefon</small>
                    <p class="mb-0">
                        <a href="tel:{{ $insuranceCompany->phone }}" class="text-decoration-none">
                            <i class="bi bi-telephone me-1"></i>{{ $insuranceCompany->phone }}
                        </a>
                    </p>
                </div>
                @endif

                @if($insuranceCompany->email)
                <div class="mb-2">
                    <small class="text-muted">E-posta</small>
                    <p class="mb-0">
                        <a href="mailto:{{ $insuranceCompany->email }}" class="text-decoration-none">
                            <i class="bi bi-envelope me-1"></i>{{ $insuranceCompany->email }}
                        </a>
                    </p>
                </div>
                @endif

                @if($insuranceCompany->website)
                <div>
                    <small class="text-muted">Website</small>
                    <p class="mb-0">
                        <a href="{{ $insuranceCompany->website }}" target="_blank" class="text-decoration-none">
                            <i class="bi bi-globe me-1"></i>{{ $insuranceCompany->website }}
                        </a>
                    </p>
                </div>
                @endif

                @if(!$insuranceCompany->phone && !$insuranceCompany->email && !$insuranceCompany->website)
                <p class="text-muted text-center mb-0">İletişim bilgisi bulunmuyor.</p>
                @endif
            </div>
        </div>

        <!-- Komisyon Oranları -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-percent me-2"></i>Komisyon Oranları
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <tbody>
                            <tr>
                                <td><strong>Kasko</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_kasko, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Trafik</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_trafik, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Konut</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_konut, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>DASK</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_dask, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Sağlık</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_saglik, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Hayat</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_hayat, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TSS</strong></td>
                                <td class="text-end">
                                    <span class="badge bg-success">%{{ number_format($insuranceCompany->default_commission_tss, 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ Kolon -->
    <div class="col-md-8">
        <!-- Poliçe Türü Dağılımı -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Poliçe Türü Dağılımı
                </h5>
            </div>
            <div class="card-body">
                @if($policyDistribution->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Poliçe Türü</th>
                                <th class="text-end">Adet</th>
                                <th class="text-end">Toplam Prim</th>
                                <th class="text-end">Oran</th>
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
                                    'tss' => 'TSS',
                                ];
                            @endphp
                            @foreach($policyDistribution as $type)
                            <tr>
                                <td><strong>{{ $typeLabels[$type->policy_type] ?? $type->policy_type }}</strong></td>
                                <td class="text-end">{{ number_format($type->count) }}</td>
                                <td class="text-end">{{ number_format($type->total_premium, 2) }} ₺</td>
                                <td class="text-end">
                                    @php
                                        $percentage = $stats['total_policies'] > 0 ? ($type->count / $stats['total_policies']) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px; min-width: 100px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
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
                <p class="text-muted text-center mb-0">Henüz poliçe bulunmuyor.</p>
                @endif
            </div>
        </div>

        <!-- Son Poliçeler -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>Son Poliçeler
                </h5>
            </div>
            <div class="card-body">
                @if($recentPolicies->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Poliçe No</th>
                                <th>Müşteri</th>
                                <th>Tür</th>
                                <th class="text-end">Prim</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPolicies as $policy)
                            <tr>
                                <td>
                                    <a href="{{ route('policies.show', $policy) }}" class="text-decoration-none">
                                        {{ $policy->policy_number }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('customers.show', $policy->customer) }}" class="text-decoration-none">
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
                                    <small>{{ $typeLabels[$policy->policy_type] ?? $policy->policy_type }}</small>
                                </td>
                                <td class="text-end">
                                    <strong>{{ number_format($policy->premium_amount, 2) }} ₺</strong>
                                </td>
                                <td>
                                    <small>{{ $policy->created_at->format('d.m.Y') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center mb-0">Henüz poliçe bulunmuyor.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
