@extends('layouts.app')

@section('title', 'Kullanıcı Yönetimi')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .settings-sidebar {
        position: sticky;
        top: 2rem;
    }

    .settings-menu {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
    }

    .settings-menu-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .settings-menu-item:last-child {
        border-bottom: none;
    }

    .settings-menu-item:hover {
        background: #f8f9fa;
        color: #212529;
    }

    .settings-menu-item.active {
        background: #0d6efd;
        color: #ffffff;
    }

    .settings-menu-item.active i {
        color: #ffffff;
    }

    .settings-menu-item i {
        font-size: 1.125rem;
        color: #6c757d;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #0d6efd;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .users-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
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

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }

    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        color: #ffffff;
        border: 2px solid #e9ecef;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.125rem;
    }

    .user-badge {
        padding: 0.25rem 0.5rem;
        font-weight: 600;
        border-radius: 4px;
        font-size: 0.6875rem;
    }

    .role-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .btn-icon {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        transform: translateY(-1px);
    }

    .btn-icon.btn-edit {
        color: #ffc107;
        border-color: #ffc107;
    }

    .btn-icon.btn-edit:hover {
        background: #ffc107;
        color: #ffffff;
    }

    .btn-icon.btn-delete {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        color: #ffffff;
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

    .form-label .text-danger {
        font-weight: 600;
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

    .form-check {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
        border: 2px solid #dcdcdc;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #495057;
        padding-left: 0.5rem;
        font-size: 1rem;
    }

    .helper-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
        display: block;
    }

    @media (max-width: 768px) {
        .settings-sidebar {
            position: static;
        }

        .user-avatar,
        .avatar-circle {
            width: 40px;
            height: 40px;
        }

        .avatar-circle {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h1 class="h3 mb-0 fw-bold text-dark">
                <i class="bi bi-people me-2"></i>Kullanıcı Yönetimi
            </h1>
            <button type="button" class="btn btn-primary action-btn" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="bi bi-plus-circle me-2"></i>Yeni Kullanıcı
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="settings-sidebar">
                <div class="settings-menu">
                    <a href="{{ route('settings.index') }}" class="settings-menu-item">
                        <i class="bi bi-building"></i>
                        <span>Genel Ayarlar</span>
                    </a>
                    <a href="{{ route('settings.users') }}" class="settings-menu-item active">
                        <i class="bi bi-people"></i>
                        <span>Kullanıcılar</span>
                    </a>
                    <a href="{{ route('settings.profile') }}" class="settings-menu-item">
                        <i class="bi bi-person"></i>
                        <span>Profil Ayarları</span>
                    </a>
                    <a href="{{ route('settings.security') }}" class="settings-menu-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Güvenlik</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Users Table -->
            <div class="users-card card">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Kullanıcı Bilgileri</th>
                                <th>E-posta</th>
                                <th>Telefon</th>
                                <th>Rol</th>
                                <th>Durum</th>
                                <th class="text-end">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="user-avatar">
                                        @else
                                        <div class="avatar-circle">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        <div>
                                            <div class="user-name">{{ $user->name }}</div>
                                            @if($user->id === auth()->id())
                                                <span class="badge user-badge bg-info">Siz</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $user->phone ?? '-' }}</span>
                                </td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'admin' => 'danger',
                                            'manager' => 'warning',
                                            'agent' => 'info',
                                        ];
                                    @endphp
                                    <span class="badge role-badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                        {{ $user->role_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge status-badge bg-{{ $user->status_color }}">
                                        {{ $user->status_label }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button"
                                                class="btn btn-icon btn-edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUserModal"
                                                onclick="editUser({{ json_encode($user) }})"
                                                title="Düzenle">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <button type="button"
                                                class="btn btn-icon btn-delete"
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

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade modal-modern" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Kullanıcı Ekle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('settings.storeUser') }}" id="createUserForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               name="name"
                               required
                               placeholder="Kullanıcı adı ve soyadı">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-posta <span class="text-danger">*</span></label>
                        <input type="email"
                               class="form-control"
                               name="email"
                               required
                               placeholder="email@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefon</label>
                        <input type="text"
                               class="form-control"
                               name="phone"
                               placeholder="0555 123 45 67">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Rolü <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="agent">Acente</option>
                            <option value="manager">Müdür</option>
                            <option value="admin">Yönetici</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Şifre <span class="text-danger">*</span></label>
                        <input type="password"
                               class="form-control"
                               name="password"
                               required
                               placeholder="Minimum 8 karakter">
                        <small class="helper-text">En az 8 karakter uzunluğunda olmalı</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Şifre Tekrar <span class="text-danger">*</span></label>
                        <input type="password"
                               class="form-control"
                               name="password_confirmation"
                               required
                               placeholder="Şifreyi tekrar girin">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               checked
                               id="createIsActive">
                        <label class="form-check-label" for="createIsActive">
                            Aktif Durum
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Kullanıcı Ekle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade modal-modern" id="editUserModal" tabindex="-1">
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
                        <input type="text"
                               class="form-control"
                               name="name"
                               id="editName"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-posta <span class="text-danger">*</span></label>
                        <input type="email"
                               class="form-control"
                               name="email"
                               id="editEmail"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefon</label>
                        <input type="text"
                               class="form-control"
                               name="phone"
                               id="editPhone">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Rolü <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" id="editRole" required>
                            <option value="agent">Acente</option>
                            <option value="manager">Müdür</option>
                            <option value="admin">Yönetici</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Yeni Şifre</label>
                        <input type="password"
                               class="form-control"
                               name="password"
                               placeholder="Değiştirmek için yeni şifre girin">
                        <small class="helper-text">Boş bırakırsanız şifre değişmez</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Şifre Tekrar</label>
                        <input type="password"
                               class="form-control"
                               name="password_confirmation"
                               placeholder="Yeni şifreyi tekrar girin">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               id="editIsActive">
                        <label class="form-check-label" for="editIsActive">
                            Aktif Durum
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
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
    if (confirm('⚠️ Bu kullanıcıyı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        const form = document.getElementById('deleteForm');
        form.action = '/panel/settings/users/' + userId;
        form.submit();
    }
}

$(document).ready(function() {
    // Form submit animasyonu
    $('#createUserForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Ekleniyor...');
    });

    $('#editUserForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Güncelleniyor...');
    });

    // Modal açıldığında form reset
    $('#createUserModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    // Input focus'ta invalid class'ı kaldır
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
