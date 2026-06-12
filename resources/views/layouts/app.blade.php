<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Manajemen Blog')</title>
    <meta name="description" content="CMS Blog — Sistem Manajemen Konten Modern">

    <!-- Inter & Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* ===== DESIGN SYSTEM ===== */
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --primary-light: rgba(37, 99, 235, 0.08);
            --primary-mid: rgba(37, 99, 235, 0.15);
            --secondary: #1E293B;
            --accent: #3B82F6;
            --success: #10B981;
            --success-light: rgba(16, 185, 129, 0.1);
            --warning: #F59E0B;
            --warning-light: rgba(245, 158, 11, 0.1);
            --danger: #EF4444;
            --danger-light: rgba(239, 68, 68, 0.1);
            --info: #0EA5E9;
            --info-light: rgba(14, 165, 233, 0.1);
            --purple: #8B5CF6;
            --purple-light: rgba(139, 92, 246, 0.1);
            --background: #F1F5F9;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --sidebar-width: 260px;
            --sidebar-bg: #0F172A;
            --sidebar-text: rgba(255,255,255,0.7);
            --sidebar-active: #FFFFFF;
            --topbar-height: 64px;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            scrollbar-width: none;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        /* Sidebar Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37,99,235,0.4);
        }
        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand-name {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: white;
            line-height: 1.2;
            letter-spacing: -0.01em;
        }
        .sidebar-brand-sub {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* Sidebar User */
        .sidebar-user {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.15);
            flex-shrink: 0;
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            display: inline-block;
            padding: 1px 8px;
            border-radius: 99px;
            margin-top: 2px;
        }
        .role-admin { background: rgba(139,92,246,0.2); color: #C4B5FD; }
        .role-penulis { background: rgba(37,99,235,0.2); color: #93C5FD; }
        .role-tamu { background: rgba(16,185,129,0.2); color: #6EE7B7; }

        /* Sidebar Nav */
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 16px 20px 6px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: var(--transition);
            position: relative;
            margin: 1px 0;
        }
        .nav-item-link:hover {
            color: white;
            background: rgba(255,255,255,0.06);
            border-left-color: rgba(37,99,235,0.5);
        }
        .nav-item-link.active {
            color: var(--sidebar-active);
            background: rgba(37,99,235,0.2);
            border-left-color: var(--primary);
            font-weight: 600;
        }
        .nav-item-link.active .nav-icon {
            color: #93C5FD;
        }
        .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            color: rgba(255,255,255,0.5);
            transition: var(--transition);
        }
        .nav-item-link:hover .nav-icon { color: rgba(255,255,255,0.8); }
        .nav-item-link.active .nav-icon { color: #93C5FD; }

        /* Sidebar Bottom */
        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 9px 14px;
            background: rgba(239,68,68,0.1);
            color: #FCA5A5;
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        .btn-logout:hover {
            background: rgba(239,68,68,0.2);
            color: #FCA5A5;
            border-color: rgba(239,68,68,0.3);
        }

        /* ===== MAIN WRAPPER ===== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== TOP BAR ===== */
        .topbar {
            height: var(--topbar-height);
            background: var(--card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: var(--shadow-sm);
        }
        .topbar-hamburger {
            display: none;
            width: 36px;
            height: 36px;
            border: none;
            background: var(--border-light);
            border-radius: var(--radius-sm);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 18px;
            transition: var(--transition);
        }
        .topbar-hamburger:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
            min-width: 0;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .topbar-page {
            font-size: 13px;
            color: var(--text-muted);
        }
        .topbar-divider {
            color: var(--border);
            font-size: 12px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            background: var(--card);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-size: 16px;
            position: relative;
        }
        .topbar-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            padding: 24px;
        }

        /* ===== TOAST NOTIFICATIONS ===== */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }
        .toast-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            background: var(--card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            min-width: 300px;
            max-width: 400px;
            border-left: 4px solid var(--primary);
            pointer-events: all;
            animation: toastIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            position: relative;
            overflow: hidden;
        }
        .toast-item.toast-success { border-left-color: var(--success); }
        .toast-item.toast-danger  { border-left-color: var(--danger); }
        .toast-item.toast-warning { border-left-color: var(--warning); }
        .toast-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .toast-success .toast-icon { background: var(--success-light); color: var(--success); }
        .toast-danger  .toast-icon { background: var(--danger-light);  color: var(--danger);  }
        .toast-warning .toast-icon { background: var(--warning-light); color: var(--warning); }
        .toast-body { flex: 1; min-width: 0; }
        .toast-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }
        .toast-message {
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.5;
        }
        .toast-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            padding: 0;
            flex-shrink: 0;
            transition: var(--transition);
        }
        .toast-close:hover { color: var(--text-primary); }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--primary);
            animation: toastProgress 4s linear forwards;
        }
        .toast-success .toast-progress { background: var(--success); }
        .toast-danger  .toast-progress { background: var(--danger); }
        .toast-warning .toast-progress { background: var(--warning); }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(100%) scale(0.95); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0%; }
        }

        /* ===== OVERLAY (Mobile) ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header-left h1,
        .page-header-left h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.02em;
        }
        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 4px 0 0;
        }

        /* ===== CARD ===== */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        .card-body-pad { padding: 20px; }

        /* ===== BUTTONS ===== */
        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary-custom:hover {
            background: var(--primary-hover);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }
        .btn-secondary-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--card);
            color: var(--text-secondary);
            border: 1px solid var(--border);
            padding: 9px 18px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        .btn-secondary-custom:hover {
            background: var(--background);
            color: var(--text-primary);
            border-color: var(--text-muted);
        }
        .btn-danger-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid rgba(239,68,68,0.2);
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        .btn-danger-custom:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }
        .btn-edit-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid rgba(37,99,235,0.2);
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        .btn-edit-custom:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        .btn-success-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--success-light);
            color: var(--success);
            border: 1px solid rgba(16,185,129,0.2);
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        .btn-success-custom:hover {
            background: var(--success);
            color: white;
        }

        /* ===== TABLE ===== */
        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }
        .table-modern thead th {
            background: var(--background);
            border-bottom: 1px solid var(--border);
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            white-space: nowrap;
        }
        .table-modern tbody td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--border-light);
            font-size: 13.5px;
            color: var(--text-primary);
            vertical-align: middle;
        }
        .table-modern tbody tr:last-child td { border-bottom: none; }
        .table-modern tbody tr {
            transition: var(--transition);
        }
        .table-modern tbody tr:hover { background: rgba(37,99,235,0.02); }

        /* ===== BADGES ===== */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-success { background: var(--success-light); color: var(--success); }
        .badge-warning { background: var(--warning-light); color: #92400E; }
        .badge-danger  { background: var(--danger-light);  color: var(--danger); }
        .badge-info    { background: var(--info-light);    color: var(--info); }
        .badge-primary { background: var(--primary-light); color: var(--primary); }
        .badge-purple  { background: var(--purple-light);  color: var(--purple); }
        .badge-muted   { background: var(--border-light);  color: var(--text-muted); }

        /* ===== FORM ELEMENTS ===== */
        .form-group { margin-bottom: 20px; }
        .form-label-custom {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 7px;
        }
        .form-label-custom .required { color: var(--danger); }
        .form-control-custom {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 14px;
            color: var(--text-primary);
            background: white;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
            outline: none;
        }
        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .form-control-custom.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }
        .invalid-feedback-custom {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 24px;
        }
        .empty-state-icon {
            width: 72px;
            height: 72px;
            background: var(--background);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px;
            color: var(--text-muted);
        }
        .empty-state h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }
        .empty-state p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0 0 20px;
        }

        /* ===== SEARCH BAR ===== */
        .search-bar {
            position: relative;
        }
        .search-bar input {
            padding-left: 38px;
        }
        .search-bar .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
            pointer-events: none;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .animate-fade-up { animation: fadeInUp 0.4s ease forwards; }
        .animate-fade { animation: fadeIn 0.3s ease forwards; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 32px rgba(0,0,0,0.3);
            }
            .sidebar-overlay.open {
                display: block;
                animation: fadeIn 0.25s ease;
            }
            .main-wrapper {
                margin-left: 0;
            }
            .topbar-hamburger {
                display: flex;
            }
        }
        @media (max-width: 768px) {
            .main-content { padding: 16px; }
            .topbar { padding: 0 16px; }
            .page-header { margin-bottom: 16px; }
            .toast-container { right: 12px; left: 12px; }
            .toast-item { min-width: unset; max-width: unset; }
        }

        /* Bootstrap overrides */
        .btn { border-radius: var(--radius-md) !important; font-weight: 500; }
        .btn-primary { background-color: var(--primary) !important; border-color: var(--primary) !important; }
        .btn-primary:hover { background-color: var(--primary-hover) !important; border-color: var(--primary-hover) !important; }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
        }
        .alert { border-radius: var(--radius-md) !important; border: none !important; }
        .alert-success { background: var(--success-light) !important; color: #065F46 !important; }
        .alert-danger  { background: var(--danger-light)  !important; color: #991B1B !important; }
    </style>

    @yield('styles')
</head>

<body>
    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar" aria-label="Sidebar Navigation">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="sidebar-brand" title="Lihat Blog">
            <div class="sidebar-brand-icon">
                <i class="bi bi-book"></i>
            </div>
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">Blog CMS</span>
                <span class="sidebar-brand-sub">Management System</span>
            </div>
        </a>

        <!-- User Profile -->
        @auth
        <div class="sidebar-user">
            <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}"
                 alt="Foto Profil"
                 class="sidebar-avatar"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_depan . '+' . Auth::user()->nama_belakang) }}&background=2563EB&color=fff&size=80'"
            >
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }}</span>
                <span class="sidebar-user-role
                    @if(Auth::user()->isAdmin()) role-admin
                    @elseif(Auth::user()->isPenulis()) role-penulis
                    @else role-tamu @endif">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>
        @endauth

        <!-- Nav: Menu Utama -->
        <div class="sidebar-section-label">Menu Utama</div>

        <a href="{{ route('dashboard') }}"
           class="nav-item-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 nav-icon"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="nav-item-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle nav-icon"></i>
            <span>Profil Saya</span>
        </a>

        <a href="{{ route('search.index') }}"
           class="nav-item-link {{ request()->routeIs('search.*') ? 'active' : '' }}">
            <i class="bi bi-search nav-icon"></i>
            <span>Cari Artikel</span>
        </a>

        @if(Auth::check() && (Auth::user()->isPenulis() || Auth::user()->isAdmin()))
        <!-- Nav: Konten -->
        <div class="sidebar-section-label" style="margin-top: 8px;">Konten</div>

        <a href="{{ route('artikel.index') }}"
           class="nav-item-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-richtext nav-icon"></i>
            <span>Kelola Artikel</span>
        </a>
        @endif

        @if(Auth::check() && Auth::user()->isAdmin())
        <!-- Nav: Admin -->
        <div class="sidebar-section-label" style="margin-top: 8px;">Administrasi</div>

        <a href="{{ route('penulis.index') }}"
           class="nav-item-link {{ request()->routeIs('penulis.*') ? 'active' : '' }}">
            <i class="bi bi-people nav-icon"></i>
            <span>Kelola Akun</span>
        </a>

        <a href="{{ route('kategori.index') }}"
           class="nav-item-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open nav-icon"></i>
            <span>Kelola Kategori</span>
        </a>

        <a href="{{ route('komentar.index') }}"
           class="nav-item-link {{ request()->routeIs('komentar.*') ? 'active' : '' }}">
            <i class="bi bi-chat-square-dots nav-icon"></i>
            <span>Moderasi Komentar</span>
        </a>
        @endif

        <!-- Sidebar Footer: Logout -->
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" class="btn-logout" style="margin-bottom: 8px; background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.6); border-color: rgba(255,255,255,0.08);">
                <i class="bi bi-globe2"></i>
                <span>Lihat Blog</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- ===== MAIN WRAPPER ===== -->
    <div class="main-wrapper" id="mainWrapper">
        <!-- Top Bar -->
        <header class="topbar">
            <button class="topbar-hamburger" id="hamburgerBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="topbar-breadcrumb">
                <span class="topbar-page">@yield('title', 'Dashboard')</span>
            </div>

            <div class="topbar-actions">
                <a href="{{ route('home') }}" class="topbar-btn" title="Lihat Blog" aria-label="Lihat Blog">
                    <i class="bi bi-globe2"></i>
                </a>
                <a href="{{ route('profile.edit') }}" class="topbar-btn" title="Profil" aria-label="Profil">
                    <i class="bi bi-person-circle"></i>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content animate-fade-up">
            @yield('content')
        </main>
    </div>

    <!-- ===== TOAST NOTIFICATIONS ===== -->
    <div class="toast-container" id="toastContainer" role="alert" aria-live="polite">
        @if(session('sukses'))
        <div class="toast-item toast-success" id="toast-sukses">
            <div class="toast-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="toast-body">
                <div class="toast-title">Berhasil!</div>
                <div class="toast-message">{{ session('sukses') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast('toast-sukses')" aria-label="Tutup"><i class="bi bi-x"></i></button>
            <div class="toast-progress"></div>
        </div>
        @endif
        @if(session('gagal'))
        <div class="toast-item toast-danger" id="toast-gagal">
            <div class="toast-icon"><i class="bi bi-x-circle-fill"></i></div>
            <div class="toast-body">
                <div class="toast-title">Gagal!</div>
                <div class="toast-message">{{ session('gagal') }}</div>
            </div>
            <button class="toast-close" onclick="closeToast('toast-gagal')" aria-label="Tutup"><i class="bi bi-x"></i></button>
            <div class="toast-progress"></div>
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }

        // Toast auto-dismiss
        function closeToast(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                el.style.transition = 'all 0.3s ease';
                setTimeout(() => el.remove(), 300);
            }
        }
        // Auto dismiss after 4s
        document.querySelectorAll('.toast-item').forEach(function(toast) {
            setTimeout(function() {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        });

        // Close sidebar on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });
    </script>

    @yield('scripts')
</body>

</html>