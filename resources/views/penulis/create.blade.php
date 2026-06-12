@extends('layouts.app')
@section('title', 'Tambah Akun')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Akun</h1>
        <p>Buat akun pengguna baru dalam sistem</p>
    </div>
    <a href="{{ route('penulis.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-person-plus me-2" style="color:var(--primary);"></i>Data Akun Baru</h2>
            </div>
            <div class="card-body-pad">
                <form action="{{ route('penulis.store') }}" method="POST" enctype="multipart/form-data" id="createUserForm">
                    @csrf

                    <!-- Nama -->
                    <div class="row g-3 mb-0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_depan" class="form-label-custom">Nama Depan <span style="color:var(--danger);">*</span></label>
                                <input type="text" class="form-control-custom @error('nama_depan') is-invalid @enderror"
                                       id="nama_depan" name="nama_depan" value="{{ old('nama_depan') }}"
                                       placeholder="Nama depan" autofocus required>
                                @error('nama_depan')
                                <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_belakang" class="form-label-custom">Nama Belakang <span style="color:var(--danger);">*</span></label>
                                <input type="text" class="form-control-custom @error('nama_belakang') is-invalid @enderror"
                                       id="nama_belakang" name="nama_belakang" value="{{ old('nama_belakang') }}"
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
                               id="email" name="email" value="{{ old('email') }}"
                               placeholder="email@aktif.com" required>
                        @error('email')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="user_name" class="form-label-custom">Username <span style="color:var(--danger);">*</span></label>
                        <input type="text" class="form-control-custom @error('user_name') is-invalid @enderror"
                               id="user_name" name="user_name" value="{{ old('user_name') }}"
                               placeholder="Pilih username unik" required>
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
                                    <option value="penulis" {{ old('role') === 'penulis' ? 'selected' : '' }}>Penulis</option>
                                    <option value="tamu"    {{ old('role') === 'tamu'    ? 'selected' : '' }}>Tamu</option>
                                    <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
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
                                    <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="pending"   {{ old('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label-custom">Password <span style="color:var(--danger);">*</span></label>
                        <div style="position:relative;">
                            <input type="password" class="form-control-custom @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Minimal 8 karakter"
                                   style="padding-right:40px;"
                                   required>
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
                        <label for="foto" class="form-label-custom">Foto Profil <span style="color:var(--text-muted);font-weight:400;">(opsional)</span></label>
                        <input type="file" class="form-control-custom @error('foto') is-invalid @enderror"
                               id="foto" name="foto"
                               accept="image/jpg,image/jpeg,image/png"
                               style="padding:8px 14px;">
                        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;">
                            <i class="bi bi-info-circle me-1"></i> JPG, JPEG, PNG · Max 2MB. Default jika tidak diupload.
                        </div>
                        @error('foto')
                        <div class="invalid-feedback-custom mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <a href="{{ route('penulis.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-info-circle me-2" style="color:var(--info);"></i>Info Role</h2>
            </div>
            <div class="card-body-pad">
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:10px;background:var(--purple-light);border-radius:var(--radius-md);">
                        <div style="width:32px;height:32px;background:var(--purple);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:14px;flex-shrink:0;">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:var(--text-primary);">Admin</div>
                            <div style="font-size:12px;color:var(--text-muted);line-height:1.5;">Akses penuh: kelola semua artikel, akun, kategori, dan komentar</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:10px;background:var(--primary-light);border-radius:var(--radius-md);">
                        <div style="width:32px;height:32px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:14px;flex-shrink:0;">
                            <i class="bi bi-pencil"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:var(--text-primary);">Penulis</div>
                            <div style="font-size:12px;color:var(--text-muted);line-height:1.5;">Dapat membuat dan mengelola artikel sendiri</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:10px;padding:10px;background:var(--success-light);border-radius:var(--radius-md);">
                        <div style="width:32px;height:32px;background:var(--success);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:14px;flex-shrink:0;">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:var(--text-primary);">Tamu</div>
                            <div style="font-size:12px;color:var(--text-muted);line-height:1.5;">Hanya dapat membaca dan memberi komentar</div>
                        </div>
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
document.getElementById('createUserForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection