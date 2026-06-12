<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Blog Kami</title>
    <meta name="description" content="Buat akun baru di Blog Kami">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --danger: #EF4444;
            --success: #10B981;
            --background: #F8FAFC;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--background);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* LEFT PANEL */
        .auth-left {
            flex: 1;
            background: linear-gradient(145deg, #065F46 0%, #059669 50%, #0F172A 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 48px;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }
        .auth-left::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16,185,129,0.3) 0%, transparent 65%);
            top: -150px;
            right: -100px;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(5,150,105,0.2) 0%, transparent 65%);
            bottom: -100px;
            left: -80px;
        }
        .auth-left-content { position: relative; z-index: 1; }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 60px;
            text-decoration: none;
        }
        .auth-brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #10B981, #34D399);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 4px 16px rgba(16,185,129,0.4);
        }
        .auth-brand-name {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: white;
        }

        .auth-left-headline {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            color: white;
            line-height: 1.15;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }
        .auth-left-headline .highlight { color: #6EE7B7; }
        .auth-left-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 40px;
        }

        .auth-features { display: flex; flex-direction: column; gap: 14px; }
        .auth-feature-item { display: flex; align-items: flex-start; gap: 12px; }
        .auth-feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6EE7B7;
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .auth-feature-title { font-size: 14px; font-weight: 600; color: white; margin-bottom: 2px; }
        .auth-feature-desc  { font-size: 12.5px; color: rgba(255,255,255,0.5); }

        .auth-left-bottom { position: relative; z-index: 1; display: flex; gap: 24px; }
        .auth-stat-value { font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 700; color: white; line-height: 1; }
        .auth-stat-label { font-size: 11.5px; color: rgba(255,255,255,0.5); margin-top: 2px; }

        /* RIGHT PANEL */
        .auth-right {
            width: 500px;
            min-width: 500px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            min-height: 100vh;
            overflow-y: auto;
        }

        .auth-right-header { margin-bottom: 28px; }
        .auth-right-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }
        .auth-right-sub { font-size: 14px; color: var(--text-secondary); }

        /* Alert */
        .auth-alert {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: #991B1B;
            margin-bottom: 20px;
        }
        .auth-alert ul { margin: 0; padding-left: 18px; }
        .auth-alert li { margin-bottom: 3px; }

        /* Form */
        .auth-form-group { margin-bottom: 16px; }
        .auth-label { display: block; font-size: 13px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; }
        .auth-input-wrap { position: relative; }
        .auth-input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            background: white;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }
        .auth-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .auth-input.is-invalid { border-color: var(--danger); }
        .auth-input-icon {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 15px; cursor: pointer;
            transition: color 0.2s ease;
        }
        .auth-input-icon:hover { color: var(--primary); }
        .auth-invalid-msg { font-size: 12px; color: var(--danger); margin-top: 4px; }

        /* Role Select Cards */
        .role-cards { display: flex; gap: 12px; }
        .role-card {
            flex: 1;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        .role-card:hover { border-color: var(--primary); background: rgba(37,99,235,0.02); }
        .role-card.selected { border-color: var(--primary); background: rgba(37,99,235,0.05); }
        .role-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .role-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .role-penulis-icon { background: rgba(37,99,235,0.1); color: var(--primary); }
        .role-tamu-icon    { background: rgba(16,185,129,0.1); color: var(--success); }
        .role-card-title   { font-size: 13.5px; font-weight: 700; color: var(--text-primary); margin-bottom: 2px; }
        .role-card-desc    { font-size: 11.5px; color: var(--text-muted); line-height: 1.4; }
        .role-check {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }
        .role-card.selected .role-check { display: flex; }

        /* Submit */
        .auth-submit-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--primary), #1E40AF);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            margin-top: 8px;
        }
        .auth-submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,0.35);
        }

        /* Footer */
        .auth-footer { margin-top: 20px; text-align: center; }
        .auth-footer p { font-size: 13.5px; color: var(--text-secondary); margin-bottom: 6px; }
        .auth-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }

        .auth-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; color: var(--text-muted); text-decoration: none;
            transition: color 0.2s ease; margin-bottom: 28px;
        }
        .auth-back:hover { color: var(--primary); }

        /* Password strength */
        .password-strength { margin-top: 6px; }
        .strength-bar { height: 3px; border-radius: 2px; background: var(--border); margin-bottom: 3px; overflow: hidden; }
        .strength-fill { height: 100%; width: 0%; transition: all 0.3s ease; border-radius: 2px; }
        .strength-label { font-size: 11px; color: var(--text-muted); }

        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; min-width: unset; padding: 32px 24px; }
        }
        @media (max-width: 480px) {
            .auth-right { padding: 24px 16px; }
            .role-cards { flex-direction: column; }
        }
    </style>
</head>

<body>
    <!-- LEFT PANEL -->
    <div class="auth-left">
        <div class="auth-left-content">
            <a href="{{ route('home') }}" class="auth-brand">
                <div class="auth-brand-icon"><i class="bi bi-book-fill"></i></div>
                <span class="auth-brand-name">Blog Kami</span>
            </a>

            <h1 class="auth-left-headline">
                Mulai Perjalanan<br>
                <span class="highlight">Menulis</span><br>
                Anda Hari Ini
            </h1>
            <p class="auth-left-desc">
                Bergabunglah dan bagikan pengetahuan Anda kepada dunia. Daftar gratis dan mulai berkontribusi!
            </p>

            <div class="auth-features">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <div class="auth-feature-title">Registrasi Gratis</div>
                        <div class="auth-feature-desc">Buat akun tanpa biaya, mulai menulis langsung</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="auth-feature-title">Aman & Terpercaya</div>
                        <div class="auth-feature-desc">Data Anda dilindungi dengan enkripsi modern</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="auth-feature-title">Komunitas Aktif</div>
                        <div class="auth-feature-desc">Bergabung dengan penulis dan pembaca aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-left-bottom">
            <div>
                <div class="auth-stat-value">∞</div>
                <div class="auth-stat-label">Artikel</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,0.1);"></div>
            <div>
                <div class="auth-stat-value">2</div>
                <div class="auth-stat-label">Tipe Akun</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,0.1);"></div>
            <div>
                <div class="auth-stat-value">0</div>
                <div class="auth-stat-label">Biaya</div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
        <a href="{{ route('home') }}" class="auth-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Blog
        </a>

        <div class="auth-right-header">
            <h2 class="auth-right-title">Buat Akun Baru</h2>
            <p class="auth-right-sub">Isi formulir di bawah untuk memulai</p>
        </div>

        @if($errors->any())
        <div class="auth-alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" id="registerForm">
            @csrf

            <!-- Nama -->
            <div class="row g-3 mb-0">
                <div class="col-6">
                    <div class="auth-form-group">
                        <label for="nama_depan" class="auth-label">Nama Depan</label>
                        <input type="text" id="nama_depan" name="nama_depan"
                               class="auth-input" value="{{ old('nama_depan') }}"
                               placeholder="Nama depan" autofocus required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="auth-form-group">
                        <label for="nama_belakang" class="auth-label">Nama Belakang</label>
                        <input type="text" id="nama_belakang" name="nama_belakang"
                               class="auth-input" value="{{ old('nama_belakang') }}"
                               placeholder="Nama belakang">
                    </div>
                </div>
            </div>

            <!-- Username -->
            <div class="auth-form-group">
                <label for="user_name" class="auth-label">Username</label>
                <div class="auth-input-wrap">
                    <input type="text" id="user_name" name="user_name"
                           class="auth-input" value="{{ old('user_name') }}"
                           placeholder="Pilih username unik" required>
                    <i class="bi bi-at auth-input-icon" style="cursor:default;"></i>
                </div>
            </div>

            <!-- Email -->
            <div class="auth-form-group">
                <label for="email" class="auth-label">Email</label>
                <div class="auth-input-wrap">
                    <input type="email" id="email" name="email"
                           class="auth-input" value="{{ old('email') }}"
                           placeholder="email@aktif.com" required>
                    <i class="bi bi-envelope auth-input-icon" style="cursor:default;"></i>
                </div>
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label for="password" class="auth-label">Password</label>
                <div class="auth-input-wrap">
                    <input type="password" id="password" name="password"
                           class="auth-input" placeholder="Min. 8 karakter"
                           oninput="checkPasswordStrength(this.value)"
                           autocomplete="new-password" required>
                    <i class="bi bi-eye auth-input-icon" id="togglePwd" onclick="togglePass('password','togglePwd')"></i>
                </div>
                <div class="password-strength">
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <span class="strength-label" id="strengthLabel">Masukkan password</span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="auth-form-group">
                <label for="password_confirmation" class="auth-label">Konfirmasi Password</label>
                <div class="auth-input-wrap">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="auth-input" placeholder="Ulangi password"
                           autocomplete="new-password" required>
                    <i class="bi bi-eye auth-input-icon" id="togglePwd2" onclick="togglePass('password_confirmation','togglePwd2')"></i>
                </div>
            </div>

            <!-- Role -->
            <div class="auth-form-group">
                <label class="auth-label">Daftar Sebagai</label>
                <div class="role-cards" id="roleCards">
                    <!-- Penulis Card -->
                    <label class="role-card {{ old('role', 'tamu') == 'penulis' ? 'selected' : '' }}" id="cardPenulis" onclick="selectRole('penulis')">
                        <input type="radio" name="role" value="penulis"
                               {{ old('role', 'tamu') == 'penulis' ? 'checked' : '' }}>
                        <div class="role-card-icon role-penulis-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="role-card-title">Penulis</div>
                        <div class="role-card-desc">Buat & kelola artikel</div>
                        <div class="role-check"><i class="bi bi-check"></i></div>
                    </label>

                    <!-- Tamu Card -->
                    <label class="role-card {{ old('role', 'tamu') == 'tamu' ? 'selected' : '' }}" id="cardTamu" onclick="selectRole('tamu')">
                        <input type="radio" name="role" value="tamu"
                               {{ old('role', 'tamu') == 'tamu' ? 'checked' : '' }}>
                        <div class="role-card-icon role-tamu-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="role-card-title">Tamu</div>
                        <div class="role-card-desc">Baca & beri komentar</div>
                        <div class="role-check"><i class="bi bi-check"></i></div>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="auth-submit-btn" id="registerBtn">
                <i class="bi bi-person-plus"></i>
                <span>Buat Akun</span>
            </button>
        </form>

        <div class="auth-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash auth-input-icon';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye auth-input-icon';
            }
        }

        function selectRole(role) {
            document.getElementById('cardPenulis').classList.remove('selected');
            document.getElementById('cardTamu').classList.remove('selected');
            document.getElementById('card' + role.charAt(0).toUpperCase() + role.slice(1)).classList.add('selected');
            document.querySelector(`input[value="${role}"]`).checked = true;
        }

        function checkPasswordStrength(value) {
            const fill  = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');
            let strength = 0;
            if (value.length >= 8) strength++;
            if (/[A-Z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^A-Za-z0-9]/.test(value)) strength++;

            const levels = [
                { w:'0%',   c:'transparent', l:'Masukkan password' },
                { w:'25%',  c:'#EF4444',     l:'Lemah' },
                { w:'50%',  c:'#F59E0B',     l:'Sedang' },
                { w:'75%',  c:'#3B82F6',     l:'Kuat' },
                { w:'100%', c:'#10B981',     l:'Sangat Kuat' },
            ];
            const lvl = levels[strength];
            fill.style.width = lvl.w;
            fill.style.background = lvl.c;
            label.textContent = lvl.l;
            label.style.color = lvl.c === 'transparent' ? '#94A3B8' : lvl.c;
        }

        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Memproses...</span>';
            btn.style.opacity = '0.8';
        });
    </script>
</body>
</html>
