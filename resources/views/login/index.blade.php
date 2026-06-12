<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Blog Kami</title>
    <meta name="description" content="Masuk ke akun Blog Kami Anda">

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

        /* ===== LEFT PANEL ===== */
        .auth-left {
            flex: 1;
            background: linear-gradient(145deg, #0F172A 0%, #1E3A8A 50%, #0F172A 100%);
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
            background: radial-gradient(circle, rgba(37,99,235,0.35) 0%, transparent 65%);
            top: -150px;
            right: -100px;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, transparent 65%);
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
            background: linear-gradient(135deg, var(--primary), #60A5FA);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 4px 16px rgba(37,99,235,0.4);
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
        .auth-left-headline .highlight { color: #60A5FA; }

        .auth-left-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 40px;
        }

        .auth-features { display: flex; flex-direction: column; gap: 14px; }
        .auth-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .auth-feature-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #93C5FD;
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .auth-feature-title { font-size: 14px; font-weight: 600; color: white; margin-bottom: 2px; }
        .auth-feature-desc  { font-size: 12.5px; color: rgba(255,255,255,0.5); }

        .auth-left-bottom {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 24px;
        }
        .auth-stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }
        .auth-stat-label { font-size: 11.5px; color: rgba(255,255,255,0.5); margin-top: 2px; }

        /* ===== RIGHT PANEL ===== */
        .auth-right {
            width: 480px;
            min-width: 480px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            min-height: 100vh;
            overflow-y: auto;
        }

        .auth-right-header { margin-bottom: 36px; }
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
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13.5px;
            color: #991B1B;
            margin-bottom: 24px;
        }
        .auth-alert i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }

        /* Form */
        .auth-form-group { margin-bottom: 20px; }
        .auth-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 7px;
        }
        .auth-input-wrap { position: relative; }
        .auth-input {
            width: 100%;
            padding: 11px 42px 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14.5px;
            color: var(--text-primary);
            background: white;
            outline: none;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }
        .auth-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .auth-input.is-invalid { border-color: var(--danger); }
        .auth-input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 16px;
            cursor: pointer;
            user-select: none;
            transition: color 0.2s ease;
        }
        .auth-input-icon:hover { color: var(--primary); }
        .auth-invalid-msg { font-size: 12px; color: var(--danger); margin-top: 5px; display: flex; align-items: center; gap: 4px; }

        /* Submit Button */
        .auth-submit-btn {
            width: 100%;
            padding: 13px;
            background: var(--primary);
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
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,0.35);
        }
        .auth-submit-btn:active { transform: translateY(0); }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: var(--text-muted);
            font-size: 12px;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Footer Links */
        .auth-footer { margin-top: 28px; text-align: center; }
        .auth-footer p { font-size: 13.5px; color: var(--text-secondary); margin-bottom: 6px; }
        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        .auth-footer a:hover { color: var(--primary-hover); text-decoration: underline; }

        /* Back link */
        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
            margin-bottom: 32px;
        }
        .auth-back:hover { color: var(--primary); }

        /* Responsive */
        @media (max-width: 900px) {
            .auth-left { display: none; }
            .auth-right {
                width: 100%;
                min-width: unset;
                padding: 32px 24px;
            }
        }
        @media (max-width: 480px) {
            .auth-right { padding: 24px 20px; }
            .auth-right-title { font-size: 1.4rem; }
        }
    </style>
</head>

<body>
    <!-- LEFT PANEL -->
    <div class="auth-left">
        <div class="auth-left-content">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="auth-brand">
                <div class="auth-brand-icon"><i class="bi bi-book-fill"></i></div>
                <span class="auth-brand-name">Blog Kami</span>
            </a>

            <!-- Headline -->
            <h1 class="auth-left-headline">
                Platform Blog<br>
                <span class="highlight">Modern &</span><br>
                Profesional
            </h1>
            <p class="auth-left-desc">
                Bergabunglah dengan komunitas penulis kami. Buat, kelola, dan bagikan artikel dengan mudah menggunakan CMS yang powerful.
            </p>

            <!-- Features -->
            <div class="auth-features">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-pencil-square"></i></div>
                    <div>
                        <div class="auth-feature-title">Editor Artikel Modern</div>
                        <div class="auth-feature-desc">Tulis dan format artikel dengan antarmuka yang intuitif</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="auth-feature-title">Manajemen Tim</div>
                        <div class="auth-feature-desc">Kelola penulis dan komentar dengan sistem role</div>
                    </div>
                </div>
                <div class="auth-feature-item">
                    <div class="auth-feature-icon"><i class="bi bi-graph-up"></i></div>
                    <div>
                        <div class="auth-feature-title">Dashboard Statistik</div>
                        <div class="auth-feature-desc">Monitor performa konten dengan insight mendalam</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Stats -->
        <div class="auth-left-bottom">
            <div>
                <div class="auth-stat-value">100%</div>
                <div class="auth-stat-label">Open Source</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,0.1);"></div>
            <div>
                <div class="auth-stat-value">Gratis</div>
                <div class="auth-stat-label">Selamanya</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,0.1);"></div>
            <div>
                <div class="auth-stat-value">Laravel</div>
                <div class="auth-stat-label">Powered</div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
        <a href="{{ route('home') }}" class="auth-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Blog
        </a>

        <div class="auth-right-header">
            <h2 class="auth-right-title">Selamat Datang!</h2>
            <p class="auth-right-sub">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        @if($errors->has('gagal'))
        <div class="auth-alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ $errors->first('gagal') }}</span>
        </div>
        @endif

        <form action="{{ route('login.proses') }}" method="POST" id="loginForm">
            @csrf
            <!-- Username -->
            <div class="auth-form-group">
                <label for="user_name" class="auth-label">Username</label>
                <div class="auth-input-wrap">
                    <input type="text"
                           id="user_name"
                           name="user_name"
                           class="auth-input"
                           value="{{ old('user_name') }}"
                           placeholder="Masukkan username Anda"
                           autofocus
                           autocomplete="username"
                           required>
                    <i class="bi bi-person auth-input-icon" style="cursor:default;"></i>
                </div>
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label for="password" class="auth-label">Password</label>
                <div class="auth-input-wrap">
                    <input type="password"
                           id="password"
                           name="password"
                           class="auth-input"
                           placeholder="Masukkan password"
                           autocomplete="current-password"
                           required>
                    <i class="bi bi-eye auth-input-icon" id="togglePassword" onclick="togglePasswordVisibility()" title="Tampilkan password"></i>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="auth-submit-btn" id="loginBtn">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Masuk</span>
            </button>
        </form>

        <div class="auth-divider">atau</div>

        <div class="auth-footer">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            const input  = document.getElementById('password');
            const icon   = document.getElementById('togglePassword');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash auth-input-icon';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye auth-input-icon';
            }
        }

        // Submit loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Memproses...</span>';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'not-allowed';
        });
    </script>
</body>
</html>
