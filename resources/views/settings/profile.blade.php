@extends('layouts.app')

@section('title', 'Profil Ayarları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-person me-2"></i>Profil Ayarları
    </h1>
</div>

<!-- Ayar Menüsü -->
<div class="row g-3">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-building me-2"></i>Genel Ayarlar
            </a>
            <a href="{{ route('settings.users') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-people me-2"></i>Kullanıcılar
            </a>
            <a href="{{ route('settings.profile') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-person me-2"></i>Profil Ayarları
            </a>
            <a href="{{ route('settings.security') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-shield-check me-2"></i>Güvenlik
            </a>
        </div>
    </div>

    <div class="col-md-9">
        <div class="row g-3">
            <!-- Profil Bilgileri -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>Profil Bilgileri
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.updateProfile') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12 text-center mb-3">
                                    @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                         alt="{{ $user->name }}"
                                         class="rounded-circle mb-3"
                                         id="avatarPreview"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                    <div class="avatar-circle bg-primary text-white mx-auto mb-3"
                                         id="avatarPreview"
                                         style="width: 120px; height: 120px; font-size: 48px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <div>
                                        <input type="file"
                                               class="form-control"
                                               id="avatar"
                                               name="avatar"
                                               accept="image/*"
                                               onchange="previewAvatar(this)">
                                        <small class="text-muted">PNG, JPG, GIF - Max 2MB</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        Ad Soyad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        E-posta <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="text"
                                           class="form-control"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $user->phone) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Rol</label>
                                    <input type="text"
                                           class="form-control"
                                           value="{{ $user->role_label }}"
                                           readonly>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Profili Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Şifre Değiştir -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-key me-2"></i>Şifre Değiştir
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.updatePassword') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="current_password" class="form-label">
                                        Mevcut Şifre <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           id="current_password"
                                           name="current_password"
                                           required>
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        Yeni Şifre <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">En az 8 karakter</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">
                                        Yeni Şifre Tekrar <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-shield-check me-2"></i>Şifreyi Değiştir
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded-circle mb-3';
                img.style.width = '120px';
                img.style.height = '120px';
                img.style.objectFit = 'cover';
                img.id = 'avatarPreview';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
