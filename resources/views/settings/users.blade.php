@extends('layouts.app')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-people me-2"></i>Kullanıcı Yönetimi
    </h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi bi-plus-circle me-2"></i>Yeni Kullanıcı
    </button>
</div>

<!-- Ayar Menüsü -->
<div class="row g-3">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-building me-2"></i>Genel Ayarlar
            </a>
            <a href="{{ route('settings.users') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-people me-2"></i>Kullanıcılar
            </a>
            <a href="{{ route('settings.profile') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-person me-2"></i>Profil Ayarları
            </a>
            <a href="{{ route('settings.security') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-shield-check me-2"></i>Güvenlik
            </a>
        </div>
    </div>

    <div class="col-md-9">
        <!-- Kullanıcı Listesi -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Kullanıcı</th>
                                <th>E-posta</th>
                                <th>Telefon</th>
                                <th>Rol</th>
                                <th>Durum</th>
                                <th class="pe-4 text-end">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="rounded-circle me-2"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            @if($user->id === auth()->id())
                                                <span class="badge bg-info ms-1">Sen</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'admin' => 'danger',
                                            'manager' => 'warning',
                                            'agent' => 'info',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                        {{ $user->role_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->status_color }}">
                                        {{ $user->status_label }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button"
                                                class="btn btn-outline-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUserModal"
                                                onclick="editUser({{ json_encode($user) }})"
                                                title="Düzenle">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                onclick="deleteUser({{ $user->id }})"
                                                title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
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

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-3">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Kullanıcı Ekle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('settings.storeUser') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-posta <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefon</label>
                        <input type="text" class="form-control" name="phone">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rol <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="agent">Acente</option>
                            <option value="manager">Müdür</option>
                            <option value="admin">Yönetici</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Şifre <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Şifre Tekrar <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="createIsActive">
                        <label class="form-check-label" for="createIsActive">
                            Aktif
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Kullanıcı Ekle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Kullanıcı Düzenle
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editUserForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-posta <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefon</label>
                        <input type="text" class="form-control" name="phone" id="editPhone">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rol <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" id="editRole" required>
                            <option value="agent">Acente</option>
                            <option value="manager">Müdür</option>
                            <option value="admin">Yönetici</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Yeni Şifre</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-muted">Boş bırakırsanız şifre değişmez</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Şifre Tekrar</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="editIsActive">
                        <label class="form-check-label" for="editIsActive">
                            Aktif
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-2"></i>Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}
</style>
@endpush

@push('scripts')
<script>
function editUser(user) {
    document.getElementById('editUserForm').action = '/panel/settings/users/' + user.id;
    document.getElementById('editName').value = user.name;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editPhone').value = user.phone || '';
    document.getElementById('editRole').value = user.role;
    document.getElementById('editIsActive').checked = user.is_active;
}

function deleteUser(userId) {
    if (confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/settings/users/' + userId;
        form.submit();
    }
}
</script>
@endpush
