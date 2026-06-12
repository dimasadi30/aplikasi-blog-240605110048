@extends('layouts.app')
@section('title', 'Edit Akun')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Akun</h1>
        <p>Memperbarui data akun: <strong>{{ $penulis->nama_depan . ' ' . $penulis->nama_belakang }}</strong></p>
    </div>
    <a href="{{ route('penulis.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-person-gear me-2" style="color:var(--primary);"></i>Edit Data Akun</h2>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
                    <i class="bi bi-clock"></i> Terdaftar {{ \Carbon\Carbon::parse($penulis->created_at)->format('d M Y') }}
                </div>
            </div>
            <div class="card-body-pad">
                <form action="{{ route('penulis.update', $penulis->id) }}" method="POST" enctype="multipart/form-data" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="row g-3 mb-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_depan" class="form-label-custom">Nama Depan <span style="color:var(--danger);">*</span></label>
                                <input type="text" class="form-control-custom @error('nama_depan') is-invalid @enderror"
                                       id="nama_depan" name="nama_depan"
                                       value="{{ old('nama_depan', $penulis->nama_depan) }}"
                                       placeholder="Nama depan" required>
                                @error('nama_depan')
                                <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_belakang" class="form-label-custom">Nama Belakang <span style="color:var(--danger);">*</span></label>
                                <input type="text" class="form-control-custom @error('nama_belakang') is-invalid @enderror"
                                       id="nama_belakang" name="nama_belakang"
                                       value="{{ old('nama_belakang', $penulis->nama_belakang) }}"
                                       placeholder="Nama belakang" required>
                                @error('nama_belakang')
                                <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label-custom">Email <span style="color:var(--danger);">*</span></label>
                        <input type="email" class="form-control-custom @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email', $penulis->email) }}"
                               placeholder="Email aktif" required>
                        @error('email')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="user_name" class="form-label-custom">Username <span style="color:var(--danger);">*</span></label>
                        <input type="text" class="form-control-custom @error('user_name') is-invalid @enderror"
                               id="user_name" name="user_name"
                               value="{{ old('user_name', $penulis->user_name) }}"
                               placeholder="Username" required>
                        @error('user_name')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role & Status -->
                    <div class="row g-3 mb-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="form-label-custom">Role <span style="color:var(--danger);">*</span></label>
                                <select class="form-control-custom @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="penulis" {{ old('role', $penulis->role) === 'penulis' ? 'selected' : '' }}>Penulis</option>
                                    <option value="tamu"    {{ old('role', $penulis->role) === 'tamu'    ? 'selected' : '' }}>Tamu</option>
                                    <option value="admin"   {{ old('role', $penulis->role) === 'admin'   ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label-custom">Status <span style="color:var(--danger);">*</span></label>
                                <select class="form-control-custom @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active"    {{ old('status', $penulis->status) === 'active'    ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ old('status', $penulis->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="pending"   {{ old('status', $penulis->status) === 'pending'   ? 'selected' : '' }}>Pending</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="form-group">
                        <label for="password" class="form-label-custom">
                            Password Baru
                            <span style="font-size:11px;font-weight:400;color:var(--text-muted);">(kosongkan jika tidak ingin diubah)</span>
                        </label>
                        <div style="position:relative;">
                            <input type="password" class="form-control-custom @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Kosongkan jika tidak ingin mengubah password"
                                   style="padding-right:40px;">
                            <i class="bi bi-eye" id="togglePwd"
                               onclick="togglePass('password','togglePwd')"
                               style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);font-size:15px;"></i>
                        </div>
                        @error('password')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label-custom">Foto Profil</label>
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px;padding:12px;background:var(--background);border-radius:var(--radius-md);">
                            <img id="currentPhoto"
                                 src="{{ asset('storage/foto/' . $penulis->foto) }}"
                                 alt="Foto Profil"
                                 style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid var(--border);"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($penulis->nama_depan . '+' . $penulis->nama_belakang) }}&background=2563EB&color=fff&size=80'">
                            <div>
                                <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Foto saat ini</div>
                                <div style="font-size:12px;color:var(--text-muted);">Upload foto baru untuk menggantinya</div>
                            </div>
                        </div>
                        <input type="file" class="form-control-custom @error('foto') is-invalid @enderror"
                               id="foto" name="foto"
                               accept="image/jpg,image/jpeg,image/png"
                               style="padding:8px 14px;"
                               onchange="previewPhoto(event)">
                        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;">JPG, JPEG, PNG · Max 2MB</div>
                        @error('foto')
                        <div class="invalid-feedback-custom mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <a href="{{ route('penulis.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-person-badge me-2" style="color:var(--primary);"></i>Info Akun</h2>
            </div>
            <div class="card-body-pad">
                <div style="text-align:center;margin-bottom:16px;">
                    <img id="previewPhoto"
                         src="{{ asset('storage/foto/' . $penulis->foto) }}"
                         alt="Foto Profil"
                         style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--border);margin-bottom:10px;"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($penulis->nama_depan . '+' . $penulis->nama_belakang) }}&background=2563EB&color=fff&size=80'">
                    <div style="font-size:14px;font-weight:700;color:var(--text-primary);">{{ $penulis->nama_depan . ' ' . $penulis->nama_belakang }}</div>
                    <div style="font-size:12px;color:var(--text-muted);">{{ $penulis->email }}</div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:var(--background);border-radius:var(--radius-sm);">
                        <span style="font-size:12px;color:var(--text-muted);">ID</span>
                        <span style="font-size:13px;font-weight:600;">{{ $penulis->id }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:var(--background);border-radius:var(--radius-sm);">
                        <span style="font-size:12px;color:var(--text-muted);">Username</span>
                        <code style="font-size:12px;">{{ $penulis->user_name }}</code>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;background:var(--background);border-radius:var(--radius-sm);">
                        <span style="font-size:12px;color:var(--text-muted);">Role</span>
                        <span class="badge-custom {{ $penulis->role === 'admin' ? 'badge-purple' : ($penulis->role === 'penulis' ? 'badge-primary' : 'badge-success') }}">
                            {{ ucfirst($penulis->role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    icon.style.cssText = 'position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);font-size:15px;';
}
function previewPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('currentPhoto').src  = e.target.result;
        document.getElementById('previewPhoto').src  = e.target.result;
    };
    reader.readAsDataURL(file);
}
document.getElementById('editUserForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection