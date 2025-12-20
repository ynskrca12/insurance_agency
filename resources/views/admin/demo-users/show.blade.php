@extends('admin.layouts.app')

@section('title', 'Demo Kullanıcı Detay')
@section('page-title', 'Demo Kullanıcı Detay')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Demo Kullanıcı Detay</h1>
            <p class="page-subtitle">{{ $demoUser->company_name }}</p>
        </div>
        <a href="{{ route('admin.demo-users.index') }}" class="btn-primary" style="background: #64748b;">
            <i class="bi bi-arrow-left"></i>
            Geri Dön
        </a>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="admin-alert success" style="margin-bottom: 24px;">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Error Messages -->
@if($errors->any())
<div class="admin-alert error" style="margin-bottom: 24px;">
    <i class="bi bi-x-circle-fill"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px;">

    <!-- Main Content -->
    <div>

        <!-- Kullanıcı Bilgileri -->
        <div class="data-card" style="margin-bottom: 24px;">
            <div class="data-card-header">
                <h3 class="data-card-title">Kullanıcı Bilgileri</h3>
            </div>
            <div class="data-card-body">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">

                    <!-- Firma Adı -->
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                            Firma Adı
                        </label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--admin-dark);">
                            {{ $demoUser->company_name }}
                        </div>
                    </div>

                    <!-- Ad Soyad -->
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                            Ad Soyad
                        </label>
                        <div style="font-size: 16px; font-weight: 600; color: var(--admin-dark);">
                            {{ $demoUser->full_name }}
                        </div>
                    </div>

                    <!-- E-posta -->
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                            E-posta
                        </label>
                        <div style="font-size: 15px; color: var(--admin-dark);">
                            <i class="bi bi-envelope" style="color: var(--admin-primary);"></i>
                            <a href="mailto:{{ $demoUser->email }}" style="color: var(--admin-primary); text-decoration: none;">
                                {{ $demoUser->email }}
                            </a>
                        </div>
                    </div>

                    <!-- Telefon -->
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                            Telefon
                        </label>
                        <div style="font-size: 15px; color: var(--admin-dark);">
                            <i class="bi bi-telephone" style="color: var(--admin-success);"></i>
                            <a href="tel:{{ $demoUser->phone }}" style="color: var(--admin-dark); text-decoration: none;">
                                {{ $demoUser->phone }}
                            </a>
                        </div>
                    </div>

                    <!-- Şehir -->
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                            Şehir
                        </label>
                        <div style="font-size: 15px; color: var(--admin-dark);">
                            <i class="bi bi-geo-alt" style="color: var(--admin-danger);"></i>
                            {{ $demoUser->city ?: '-' }}
                        </div>
                    </div>

                    <!-- Kayıt Tarihi -->
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                            Kayıt Tarihi
                        </label>
                        <div style="font-size: 15px; color: var(--admin-dark);">
                            <i class="bi bi-calendar-check" style="color: var(--admin-warning);"></i>
                            {{ $demoUser->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>

                </div>

                <!-- Not -->
                @if($demoUser->notes)
                <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--admin-border);">
                    <label style="display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 8px;">
                        Not
                    </label>
                    <div style="font-size: 15px; color: #64748b; line-height: 1.7;">
                        {{ $demoUser->notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Kullanım İstatistikleri -->
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">Kullanım İstatistikleri</h3>
            </div>
            <div class="data-card-body">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">

                    <!-- Müşteriler -->
                    <div style="padding: 20px; background: rgba(37, 99, 235, 0.05); border-radius: 12px; border-left: 4px solid var(--admin-primary);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                                    Müşteri Sayısı
                                </div>
                                <div style="font-size: 32px; font-weight: 800; color: var(--admin-primary);">
                                    {{ $stats['customers'] }}
                                </div>
                            </div>
                            <div style="width: 56px; height: 56px; background: rgba(37, 99, 235, 0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-people" style="font-size: 28px; color: var(--admin-primary);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Poliçeler -->
                    <div style="padding: 20px; background: rgba(16, 185, 129, 0.05); border-radius: 12px; border-left: 4px solid var(--admin-success);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                                    Poliçe Sayısı
                                </div>
                                <div style="font-size: 32px; font-weight: 800; color: var(--admin-success);">
                                    {{ $stats['policies'] }}
                                </div>
                            </div>
                            <div style="width: 56px; height: 56px; background: rgba(16, 185, 129, 0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-file-earmark-text" style="font-size: 28px; color: var(--admin-success);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Teklifler -->
                    <div style="padding: 20px; background: rgba(245, 158, 11, 0.05); border-radius: 12px; border-left: 4px solid var(--admin-warning);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                                    Teklif Sayısı
                                </div>
                                <div style="font-size: 32px; font-weight: 800; color: var(--admin-warning);">
                                    {{ $stats['quotations'] }}
                                </div>
                            </div>
                            <div style="width: 56px; height: 56px; background: rgba(245, 158, 11, 0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calculator" style="font-size: 28px; color: var(--admin-warning);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Ödemeler -->
                    <div style="padding: 20px; background: rgba(239, 68, 68, 0.05); border-radius: 12px; border-left: 4px solid var(--admin-danger);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                                    Ödeme Sayısı
                                </div>
                                <div style="font-size: 32px; font-weight: 800; color: var(--admin-danger);">
                                    {{ $stats['payments'] }}
                                </div>
                            </div>
                            <div style="width: 56px; height: 56px; background: rgba(239, 68, 68, 0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-credit-card" style="font-size: 28px; color: var(--admin-danger);"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Empty State -->
                @if($stats['customers'] == 0 && $stats['policies'] == 0 && $stats['quotations'] == 0 && $stats['payments'] == 0)
                <div style="text-align: center; padding: 40px 20px; color: #64748b; margin-top: 24px; background: var(--admin-light); border-radius: 12px;">
                    <i class="bi bi-info-circle" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5;"></i>
                    <p style="font-size: 15px;">Bu kullanıcı henüz sistemi kullanmaya başlamamış.</p>
                </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div>

        <!-- Demo Durumu -->
        <div class="data-card" style="margin-bottom: 24px;">
            <div class="data-card-header">
                <h3 class="data-card-title">Demo Durumu</h3>
            </div>
            <div class="data-card-body">

                <!-- Durum Badge -->
                @if($demoUser->trial_ends_at && $demoUser->trial_ends_at->isFuture())
                <div style="padding: 16px; background: rgba(16, 185, 129, 0.1); border-radius: 12px; border: 2px solid var(--admin-success); margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i class="bi bi-check-circle-fill" style="font-size: 24px; color: var(--admin-success);"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 16px; color: var(--admin-success);">Aktif</div>
                            <div style="font-size: 12px; color: #64748b;">Demo hesabı aktif</div>
                        </div>
                    </div>
                    <div style="font-size: 13px; color: #64748b;">
                        <strong>Kalan Süre:</strong> {{ $demoUser->trial_ends_at->diffForHumans() }}
                    </div>
                </div>
                @else
                <div style="padding: 16px; background: rgba(239, 68, 68, 0.1); border-radius: 12px; border: 2px solid var(--admin-danger); margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <i class="bi bi-x-circle-fill" style="font-size: 24px; color: var(--admin-danger);"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 16px; color: var(--admin-danger);">Süresi Doldu</div>
                            <div style="font-size: 12px; color: #64748b;">Demo süresi sona erdi</div>
                        </div>
                    </div>
                    <div style="font-size: 13px; color: #64748b;">
                        <strong>Dolma Tarihi:</strong> {{ $demoUser->trial_ends_at ? $demoUser->trial_ends_at->diffForHumans() : '-' }}
                    </div>
                </div>
                @endif

                <!-- Bitiş Tarihi -->
                <div style="padding: 16px; background: var(--admin-light); border-radius: 12px; margin-bottom: 20px;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 8px;">
                        Demo Bitiş Tarihi
                    </div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--admin-dark);">
                        @if($demoUser->trial_ends_at)
                            {{ $demoUser->trial_ends_at->format('d F Y') }}
                            <div style="font-size: 13px; font-weight: 400; color: #64748b; margin-top: 4px;">
                                {{ $demoUser->trial_ends_at->format('H:i') }}
                            </div>
                        @else
                            <span style="color: #94a3b8;">-</span>
                        @endif
                    </div>
                </div>

                <!-- Demo Süre Güncelleme -->
                <form method="POST" action="{{ route('admin.demo-users.update-trial', $demoUser) }}" style="margin-bottom: 16px;">
                    @csrf
                    @method('PUT')

                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--admin-dark); margin-bottom: 8px;">
                        Demo Süresini Güncelle
                    </label>
                    <input
                        type="datetime-local"
                        name="trial_ends_at"
                        class="form-input"
                        value="{{ $demoUser->trial_ends_at ? $demoUser->trial_ends_at->format('Y-m-d\TH:i') : now()->addDays(14)->format('Y-m-d\TH:i') }}"
                        required
                        style="width: 100%; padding: 10px 14px; border: 2px solid var(--admin-border); border-radius: 10px; font-size: 14px; margin-bottom: 12px;"
                    >
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 10px;">
                        <i class="bi bi-clock-history"></i>
                        Süreyi Güncelle
                    </button>
                </form>

                <!-- Hızlı İşlemler -->
                <div style="display: grid; gap: 12px;">
                    @if($demoUser->trial_ends_at && $demoUser->trial_ends_at->isFuture())
                    <!-- Deaktif Et -->
                    <form method="POST" action="{{ route('admin.demo-users.deactivate', $demoUser) }}">
                        @csrf
                        <button
                            type="submit"
                            class="btn-primary"
                            style="width: 100%; padding: 10px; background: var(--admin-warning);"
                            onclick="return confirm('Demo hesabını deaktif etmek istediğinize emin misiniz?')"
                        >
                            <i class="bi bi-pause-circle"></i>
                            Deaktif Et
                        </button>
                    </form>
                    @else
                    <!-- Aktif Et (14 gün uzat) -->
                    <form method="POST" action="{{ route('admin.demo-users.activate', $demoUser) }}">
                        @csrf
                        <button
                            type="submit"
                            class="btn-primary"
                            style="width: 100%; padding: 10px; background: var(--admin-success);"
                            onclick="return confirm('Demo hesabını aktif etmek istediğinize emin misiniz? (14 gün uzatılacak)')"
                        >
                            <i class="bi bi-play-circle"></i>
                            Aktif Et (14 Gün)
                        </button>
                    </form>
                    @endif
                </div>

            </div>
        </div>

        <!-- Hesap Bilgileri -->
        @if($demoUser->user)
        <div class="data-card" style="margin-bottom: 24px;">
            <div class="data-card-header">
                <h3 class="data-card-title">Hesap Bilgileri</h3>
            </div>
            <div class="data-card-body">
                <div style="display: grid; gap: 16px;">
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--admin-light); border-radius: 8px;">
                        <span style="color: #64748b; font-size: 13px;">User ID</span>
                        <span style="font-weight: 600; font-size: 13px;">#{{ $demoUser->user_id }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--admin-light); border-radius: 8px;">
                        <span style="color: #64748b; font-size: 13px;">E-posta Doğrulandı</span>
                        <span style="font-weight: 600; font-size: 13px;">
                            @if($demoUser->user->email_verified_at)
                            <i class="bi bi-check-circle-fill" style="color: var(--admin-success);"></i> Evet
                            @else
                            <i class="bi bi-x-circle-fill" style="color: var(--admin-danger);"></i> Hayır
                            @endif
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--admin-light); border-radius: 8px;">
                        <span style="color: #64748b; font-size: 13px;">Rol</span>
                        <span style="font-weight: 600; font-size: 13px; text-transform: capitalize;">{{ $demoUser->user->role }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tehlikeli Bölge -->
        <div class="data-card" style="border: 2px solid var(--admin-danger);">
            <div class="data-card-header" style="background: rgba(239, 68, 68, 0.05);">
                <h3 class="data-card-title" style="color: var(--admin-danger);">
                    <i class="bi bi-exclamation-triangle"></i>
                    Tehlikeli Bölge
                </h3>
            </div>
            <div class="data-card-body">
                <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
                    Bu kullanıcıyı ve tüm verilerini kalıcı olarak silmek için aşağıdaki butona tıklayın.
                    <strong>Bu işlem geri alınamaz!</strong>
                </p>

                <form method="POST" action="{{ route('admin.demo-users.destroy', $demoUser) }}" onsubmit="return confirm('Bu kullanıcıyı ve TÜM VERİLERİNİ (müşteriler, poliçeler, ödemeler vb.) silmek istediğinize EMİN MİSİNİZ? Bu işlem GERİ ALINAMAZ!')">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn-primary"
                        style="width: 100%; padding: 12px; background: var(--admin-danger);"
                    >
                        <i class="bi bi-trash"></i>
                        Kullanıcıyı ve Tüm Verilerini Sil
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

@endsection
