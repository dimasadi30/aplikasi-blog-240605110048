@extends('layouts.app')
@section('title', 'Profil Saya')

@section('styles')
<style>
    /* Tab navigation */
    .profile-tabs {
        display: flex;
        gap: 4px;
        border-bottom: 2px solid var(--border);
        margin-bottom: 24px;
    }
    .profile-tab {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        border: none;
        background: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s ease;
        border-radius: var(--radius-sm) var(--radius-sm) 0 0;
    }
    .profile-tab:hover { color: var(--primary); background: var(--primary-light); }
    .profile-tab.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
        background: var(--primary-light);
    }
    .tab-content-panel { display: none; animation: fadeInUp 0.3s ease; }
    .tab-content-panel.active { display: block; }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Profil Saya</h1>
        <p>Kelola informasi akun dan keamanan Anda</p>
    </div>
</div>

<div class="row g-4">
    <!-- Avatar Card -->
    <div class="col-lg-4">
        <div class="card" style="text-align:center;">
            <div class="card-body-pad" style="padding: 32px 24px;">
                <!-- Avatar -->
                <div style="position:relative;display:inline-block;margin-bottom:16px;" id="avatarWrapper">
                    <img src="{{ asset('storage/foto/' . $user->foto) }}"
                         alt="Foto Profil"
                         id="profilePreview"
                         style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:4px solid var(--border);display:block;"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->nama_depan . '+' . $user->nama_belakang) }}&background=2563EB&color=fff&size=200'">
                </div>

                <!-- Name & Role -->
                <h2 style="font-family:'Poppins',sans-serif;font-size:1.125rem;font-weight:700;color:var(--text-primary);margin-bottom:4px;">
                    {{ $user->nama_depan }} {{ $user->nama_belakang }}
                </h2>
                <span class="badge-custom {{ $user->isAdmin() ? 'badge-purple' : ($user->isPenulis() ? 'badge-primary' : 'badge-success') }}" style="margin-bottom:8px;">
                    {{ ucfirst($user->role) }}
                </span>
                <p style="font-size:13px;color:var(--text-muted);margin-top:6px;margin-bottom:0;">{{ $user->email }}</p>
                <p style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                    <i class="bi bi-at"></i> {{ $user->user_name }}
                </p>

                <!-- Account info -->
                <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                    <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:12.5px;">
                        <span style="color:var(--text-muted);">Bergabung</span>
                        <span style="font-weight:600;">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:12.5px;">
                        <span style="color:var(--text-muted);">Status</span>
                        <span class="badge-custom badge-success" style="font-size:10px;">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms -->
    <div class="col-lg-8">
        <!-- Tabs -->
        <div class="profile-tabs" role="tablist">
            <button class="profile-tab active" id="tab-profil" onclick="switchTab('profil')" role="tab" aria-selected="true">
                <i class="bi bi-person-circle"></i> Informasi Profil
            </button>
            <button class="profile-tab" id="tab-password" onclick="switchTab('password')" role="tab" aria-selected="false">
                <i class="bi bi-shield-lock"></i> Ubah Password
            </button>
            <button class="profile-tab" id="tab-foto" onclick="switchTab('foto')" role="tab" aria-selected="false">
                <i class="bi bi-camera"></i> Foto Profil
            </button>
        </div>

        <!-- Tab: Profil -->
        <div class="tab-content-panel active" id="panel-profil" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-person-circle me-2" style="color:var(--primary);"></i>Informasi Profil</h2>
                </div>
                <div class="card-body-pad">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_depan" class="form-label-custom">Nama Depan</label>
                                    <input type="text" class="form-control-custom @error('nama_depan') is-invalid @enderror"
                                           id="nama_depan" name="nama_depan"
                                           value="{{ old('nama_depan', $user->nama_depan) }}">
                                    @error('nama_depan')
                                    <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_belakang" class="form-label-custom">Nama Belakang</label>
                                    <input type="text" class="form-control-custom @error('nama_belakang') is-invalid @enderror"
                                           id="nama_belakang" name="nama_belakang"
                                           value="{{ old('nama_belakang', $user->nama_belakang) }}">
                                    @error('nama_belakang')
                                    <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_name" class="form-label-custom">Username</label>
                            <input type="text" class="form-control-custom @error('user_name') is-invalid @enderror"
                                   id="user_name" name="user_name"
                                   value="{{ old('user_name', $user->user_name) }}">
                            @error('user_name')
                            <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="email" class="form-label-custom">Email</label>
                            <input type="email" class="form-control-custom @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   value="{{ old('email', $user->email) }}">
                            @error('email')
                            <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div style="display:flex;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                            <button type="submit" class="btn-primary-custom" id="profileSubmitBtn">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tab: Password -->
        <div class="tab-content-panel" id="panel-password" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-shield-lock me-2" style="color:var(--warning);"></i>Ubah Password</h2>
                </div>
                <div class="card-body-pad">
                    <form action="{{ route('profile.password') }}" method="POST" id="passwordForm">
                        @csrf
                        <div class="form-group">
                            <label for="current_password" class="form-label-custom">Password Saat Ini</label>
                            <div style="position:relative;">
                                <input type="password" class="form-control-custom @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password"
                                       placeholder="Masukkan password lama"
                                       style="padding-right:40px;">
                                <i class="bi bi-eye" id="toggleCurrent" onclick="togglePass('current_password','toggleCurrent')"
                                   style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);font-size:15px;"></i>
                            </div>
                            @error('current_password')
                            <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3 mb-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label-custom">Password Baru</label>
                                    <div style="position:relative;">
                                        <input type="password" class="form-control-custom @error('password') is-invalid @enderror"
                                               id="password" name="password"
                                               placeholder="Password baru"
                                               style="padding-right:40px;">
                                        <i class="bi bi-eye" id="toggleNew" onclick="togglePass('password','toggleNew')"
                                           style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);font-size:15px;"></i>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label-custom">Konfirmasi Password</label>
                                    <input type="password" class="form-control-custom"
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                        <div style="background:rgba(14,165,233,0.08);border:1px solid rgba(14,165,233,0.2);border-radius:var(--radius-md);padding:12px 14px;margin-top:4px;font-size:12.5px;color:#0369A1;">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Syarat:</strong> Minimal 12 karakter, huruf besar & kecil, angka, dan karakter spesial
                        </div>
                        <div style="display:flex;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                            <button type="submit" class="btn-primary-custom" style="background:var(--warning);" id="pwdSubmitBtn"
                                    onmouseover="this.style.background='#D97706';" onmouseout="this.style.background='var(--warning)';">
                                <i class="bi bi-key"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tab: Foto -->
        <div class="tab-content-panel" id="panel-foto" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-camera me-2" style="color:var(--success);"></i>Foto Profil</h2>
                </div>
                <div class="card-body-pad">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="fotoForm">
                        @csrf
                        <!-- Foto saat ini -->
                        <div style="text-align:center;margin-bottom:24px;">
                            <img src="{{ asset('storage/foto/' . $user->foto) }}"
                                 alt="Foto Profil"
                                 id="fotoPreview"
                                 style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid var(--border);"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->nama_depan) }}&background=2563EB&color=fff&size=200'">
                            <p style="font-size:12.5px;color:var(--text-muted);margin-top:10px;">Foto saat ini</p>
                        </div>

                        <!-- Upload area -->
                        <div style="border:2px dashed var(--border);border-radius:var(--radius-lg);padding:28px;text-align:center;cursor:pointer;transition:all 0.2s ease;background:var(--background);position:relative;"
                             id="fotoUploadArea"
                             onmouseover="this.style.borderColor='var(--primary)';this.style.background='var(--primary-light)';"
                             onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--background)';">
                            <input type="file" name="foto" id="foto" accept="image/jpg,image/jpeg,image/png"
                                   style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;"
                                   onchange="previewFoto(event)">
                            <i class="bi bi-cloud-upload" style="font-size:36px;color:var(--text-muted);display:block;margin-bottom:10px;"></i>
                            <div style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:4px;">Klik untuk upload foto baru</div>
                            <div style="font-size:12.5px;color:var(--text-muted);">JPG, JPEG, PNG · Maksimal 2 MB</div>
                        </div>
                        @error('foto')
                        <div class="invalid-feedback-custom mt-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror

                        <div style="display:flex;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);">
                            <button type="submit" class="btn-primary-custom" style="background:var(--success);"
                                    onmouseover="this.style.background='#059669';" onmouseout="this.style.background='var(--success)';">
                                <i class="bi bi-upload"></i> Upload Foto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(tabName) {
        document.querySelectorAll('.profile-tab').forEach(t => {
            t.classList.remove('active');
            t.setAttribute('aria-selected', 'false');
        });
        document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.remove('active'));

        document.getElementById('tab-' + tabName).classList.add('active');
        document.getElementById('tab-' + tabName).setAttribute('aria-selected', 'true');
        document.getElementById('panel-' + tabName).classList.add('active');
    }

    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        icon.style.cssText = 'position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--text-muted);font-size:15px;';
    }

    function previewFoto(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('fotoPreview').src = e.target.result;
            document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Auto-open password tab if there are password errors
    @if($errors->has('current_password') || $errors->has('password'))
        switchTab('password');
    @endif

    // Loading state
    ['profileForm','passwordForm','fotoForm'].forEach(function(id) {
        const form = document.getElementById(id);
        if (form) {
            form.addEventListener('submit', function() {
                const btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
                    btn.disabled = true;
                }
            });
        }
    });
</script>
@endsection
