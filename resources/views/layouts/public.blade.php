<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'Blog Kami - Artikel terbaru seputar teknologi dan pemrograman')">
    <meta name="keywords" content="@yield('meta-keywords', 'blog, teknologi, pemrograman, tutorial')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og-title', 'Blog Kami')">
    <meta property="og:description" content="@yield('og-description', 'Blog Kami - Artikel terbaru seputar teknologi dan pemrograman')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('og-url', url()->current())">
    <meta property="og:image" content="@yield('og-image', asset('images/default-og.jpg'))">

    <title>@yield('title', 'Blog Kami')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

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
            --secondary: #1E293B;
            --accent: #3B82F6;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --background: #F8FAFC;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.12);
            --navbar-height: 68px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== RESET ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-main {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0;
            height: var(--navbar-height);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }
        .navbar-main.scrolled {
            box-shadow: var(--shadow-md);
        }
        .navbar-main .container {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Brand */
        .navbar-brand-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 17px;
            box-shadow: 0 4px 12px rgba(37,99,235,0.35);
        }
        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .brand-name {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }
        .brand-tagline {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Nav Links */
        .navbar-nav-custom {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-md);
            transition: var(--transition);
            white-space: nowrap;
        }
        .nav-link-custom:hover {
            color: var(--primary);
            background: var(--primary-light);
        }
        .nav-link-custom.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 600;
        }
        .nav-link-custom i { font-size: 15px; }

        /* Auth Buttons */
        .btn-nav-login {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            background: var(--primary);
            color: white;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
            border: none;
        }
        .btn-nav-login:hover {
            background: var(--primary-hover);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }

        /* User Pill */
        .user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px 5px 5px;
            border: 1px solid var(--border);
            border-radius: 99px;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            background: white;
            position: relative;
        }
        .user-pill:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        .user-pill-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
        }
        .user-pill-info { line-height: 1.25; }
        .user-pill-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            display: block;
        }
        .user-pill-role {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: block;
        }
        .user-pill-chevron { font-size: 11px; color: var(--text-muted); transition: var(--transition); }

        /* Dropdown */
        .user-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            min-width: 230px;
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            z-index: 9999;
            animation: dropdownIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .user-dropdown.open { display: block; }
        @keyframes dropdownIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .dropdown-header {
            padding: 14px 16px;
            background: var(--background);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dropdown-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
        }
        .dropdown-header-name { font-size: 13.5px; font-weight: 600; color: var(--text-primary); }
        .dropdown-header-email { font-size: 11.5px; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
        .dropdown-role-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-top: 3px;
        }
        .role-admin-badge { background: #EDE9FE; color: #7C3AED; }
        .role-penulis-badge { background: #DBEAFE; color: #2563EB; }
        .role-tamu-badge { background: #D1FAE5; color: #059669; }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            transition: background 0.15s ease;
        }
        .dropdown-item-custom:hover { background: var(--background); color: var(--text-primary); }
        .dropdown-item-custom i { color: var(--primary); font-size: 16px; }
        .dropdown-divider-custom { height: 1px; background: var(--border); margin: 4px 0; }
        .dropdown-item-danger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: var(--danger);
            background: transparent;
            border: none;
            width: 100%;
            font-size: 14px;
            cursor: pointer;
            text-align: left;
            transition: background 0.15s ease;
        }
        .dropdown-item-danger:hover { background: #FEF2F2; }
        .dropdown-item-danger i { font-size: 16px; }

        /* Mobile Toggle */
        .navbar-toggle-btn {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            background: white;
            border-radius: var(--radius-md);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 20px;
            transition: var(--transition);
        }
        .navbar-toggle-btn:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Mobile Nav */
        .navbar-mobile {
            display: none;
            flex-direction: column;
            gap: 4px;
            padding: 12px 16px;
            background: white;
            border-top: 1px solid var(--border);
            box-shadow: var(--shadow-md);
        }
        .navbar-mobile.open { display: flex; }
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }
        .mobile-nav-link:hover, .mobile-nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
        }
        .mobile-nav-link i { font-size: 16px; }
        .mobile-nav-divider { height: 1px; background: var(--border); margin: 4px 0; }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 40%, #1E3A8A 100%);
            padding: 80px 0 90px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37,99,235,0.25) 0%, transparent 70%);
            top: -200px;
            right: -100px;
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            bottom: -100px;
            left: -50px;
            pointer-events: none;
        }
        .hero-content { position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(37,99,235,0.2);
            border: 1px solid rgba(37,99,235,0.3);
            color: #93C5FD;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 20px;
            letter-spacing: 0.02em;
        }
        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: clamp(2rem, 5vw, 3.25rem);
            color: white;
            margin-bottom: 16px;
            line-height: 1.15;
            letter-spacing: -0.03em;
        }
        .hero h1 .text-accent { color: #60A5FA; }
        .hero p {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.75);
            margin-bottom: 32px;
            max-width: 520px;
            line-height: 1.7;
        }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 13px 28px;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(37,99,235,0.4);
        }
        .btn-hero-primary:hover {
            background: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.5);
        }
        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 13px 28px;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.18);
            color: white;
            transform: translateY(-2px);
        }
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .hero-stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }
        .hero-stat-label {
            font-size: 12px;
            color: rgba(255,255,255,0.55);
            margin-top: 4px;
        }

        /* ===== ARTICLE CARDS ===== */
        .article-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
        }
        .article-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        .article-card-img-wrap {
            position: relative;
            overflow: hidden;
            height: 210px;
        }
        .article-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .article-card:hover .article-card-img { transform: scale(1.05); }
        .article-card-category {
            position: absolute;
            bottom: 12px;
            left: 14px;
            background: var(--primary);
            color: white;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .article-card-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .article-card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            line-height: 1.4;
            transition: color 0.2s ease;
        }
        .article-card-title:hover { color: var(--primary); }
        .article-card-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 12.5px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }
        .article-card-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .article-card-excerpt {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.65;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 16px;
        }
        .btn-read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }
        .btn-read-more:hover {
            color: var(--primary-hover);
            gap: 10px;
        }

        /* Featured Article Card */
        .article-card-featured {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
        }
        .article-card-featured:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        .article-card-featured .img-wrap {
            height: 280px;
            overflow: hidden;
            position: relative;
        }
        .article-card-featured .img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .article-card-featured:hover .img-wrap img { transform: scale(1.04); }

        /* ===== SIDEBAR ===== */
        .sidebar-widget {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: calc(var(--navbar-height) + 16px);
        }
        .sidebar-widget + .sidebar-widget { margin-top: 20px; }
        .widget-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }
        .category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 10px;
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 13.5px;
            transition: var(--transition);
            margin-bottom: 2px;
        }
        .category-item:hover, .category-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }
        .category-item.active { font-weight: 600; }
        .category-count {
            background: var(--border);
            color: var(--text-muted);
            padding: 1px 8px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 500;
        }
        .category-item:hover .category-count, .category-item.active .category-count {
            background: rgba(37,99,235,0.15);
            color: var(--primary);
        }

        /* Related Articles */
        .related-item {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .related-item:last-child { border-bottom: none; padding-bottom: 0; }
        .related-item-img {
            width: 72px;
            height: 54px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            flex-shrink: 0;
        }
        .related-item-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            text-decoration: none;
            display: block;
            line-height: 1.4;
            transition: color 0.2s ease;
        }
        .related-item-title:hover { color: var(--primary); }
        .related-item-date {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ===== ARTICLE DETAIL ===== */
        .article-hero-img {
            width: 100%;
            max-height: 440px;
            object-fit: cover;
            border-radius: var(--radius-xl);
            margin-bottom: 28px;
        }
        .article-hero-category {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 4px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 14px;
            text-decoration: none;
        }
        .article-hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.6rem, 4vw, 2.25rem);
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }
        .article-meta-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }
        .article-author-pill {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .author-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .author-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        .author-date {
            font-size: 12px;
            color: var(--text-muted);
        }
        .article-meta-sep { color: var(--border); font-size: 18px; }
        .article-meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Reading Progress */
        .reading-progress {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            z-index: 9998;
            transition: width 0.1s linear;
        }

        /* Article Content */
        .article-content {
            font-size: 17px;
            line-height: 1.85;
            color: var(--text-primary);
        }
        .article-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 2.5rem 0 0.875rem;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }
        .article-content h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 2rem 0 0.75rem;
            color: var(--text-primary);
        }
        .article-content p { margin-bottom: 1.2rem; }
        .article-content ul, .article-content ol {
            margin-bottom: 1.2rem;
            padding-left: 1.5rem;
        }
        .article-content li { margin-bottom: 0.5rem; }
        .article-content img {
            max-width: 100%;
            border-radius: var(--radius-md);
            margin: 1.5rem 0;
        }
        .article-content blockquote {
            border-left: 4px solid var(--primary);
            background: var(--primary-light);
            padding: 16px 20px;
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
            margin: 1.5rem 0;
            font-style: italic;
            color: var(--text-secondary);
        }
        .article-content code {
            background: #F1F5F9;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.875em;
            color: #DC2626;
        }
        .article-content pre {
            background: #1E293B;
            color: #E2E8F0;
            padding: 20px;
            border-radius: var(--radius-md);
            overflow-x: auto;
            margin: 1.5rem 0;
            font-size: 0.875rem;
        }

        /* Breadcrumb */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .breadcrumb-modern a {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }
        .breadcrumb-modern a:hover { color: var(--primary-hover); text-decoration: underline; }
        .breadcrumb-modern .sep { color: var(--border); font-size: 16px; }
        .breadcrumb-modern .current { color: var(--text-secondary); }

        /* Comment Section */
        .comment-wrapper {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 28px;
            margin-top: 32px;
        }
        .comment-section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .comment-section-title i { color: var(--primary); }
        .comment-form-box {
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px;
            margin-bottom: 28px;
        }
        .comment-form-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }
        .form-label-c {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }
        .form-control-c {
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
        .form-control-c:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .form-control-c.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }
        .comment-item {
            display: flex;
            gap: 14px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }
        .comment-item:last-child { border-bottom: none; }
        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .comment-content-box { flex: 1; min-width: 0; }
        .comment-author-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .comment-author-name { font-size: 14px; font-weight: 600; color: var(--text-primary); }
        .comment-date { font-size: 12px; color: var(--text-muted); }
        .comment-text { font-size: 14px; color: var(--text-secondary); line-height: 1.65; }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--secondary);
            color: rgba(255,255,255,0.7);
            padding: 60px 0 0;
            margin-top: 80px;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            text-decoration: none;
        }
        .footer-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }
        .footer-brand-name {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: white;
        }
        .footer-desc {
            font-size: 13.5px;
            line-height: 1.7;
            color: rgba(255,255,255,0.5);
            max-width: 280px;
            margin-bottom: 20px;
        }
        .footer-heading {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: rgba(255,255,255,0.9);
            margin-bottom: 14px;
        }
        .footer-link {
            display: block;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 13.5px;
            padding: 4px 0;
            transition: var(--transition);
        }
        .footer-link:hover { color: rgba(255,255,255,0.9); padding-left: 4px; }
        .footer-bottom {
            margin-top: 48px;
            padding: 20px 0;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .footer-bottom-text {
            font-size: 13px;
            color: rgba(255,255,255,0.35);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state-public {
            text-align: center;
            padding: 80px 24px;
        }
        .empty-state-public i {
            font-size: 56px;
            color: var(--text-muted);
            margin-bottom: 16px;
            display: block;
        }
        .empty-state-public h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .empty-state-public p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* ===== TOAST ===== */
        .toast-container-public {
            position: fixed;
            top: calc(var(--navbar-height) + 12px);
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }
        .toast-pub {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            min-width: 300px;
            border-left: 4px solid var(--primary);
            pointer-events: all;
            animation: toastIn 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .toast-pub.toast-success { border-left-color: var(--success); }
        .toast-pub.toast-danger  { border-left-color: var(--danger); }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ===== SEARCH ===== */
        .search-hero {
            background: linear-gradient(135deg, var(--primary) 0%, #1E40AF 100%);
            padding: 60px 0;
            text-align: center;
        }
        .search-hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
        }
        .search-hero p { color: rgba(255,255,255,0.8); margin-bottom: 24px; font-size: 15px; }
        .search-input-wrapper {
            max-width: 560px;
            margin: 0 auto;
            position: relative;
        }
        .search-input-big {
            width: 100%;
            padding: 16px 54px 16px 54px;
            border: none;
            border-radius: 99px;
            font-size: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            outline: none;
            background: white;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
        }
        .search-input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
        }
        .search-input-btn {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            padding: 0 22px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 99px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        .search-input-btn:hover { background: var(--primary-hover); }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeInUp 0.5s ease forwards; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .navbar-toggle-btn { display: flex !important; }
            .navbar-nav-desktop { display: none !important; }
        }
        @media (max-width: 768px) {
            .hero { padding: 60px 0 70px; }
            .hero h1 { font-size: 2rem; }
            .hero-stats { gap: 20px; }
            .article-card-img-wrap { height: 170px; }
            .sidebar-widget { position: static; top: auto; }
            .footer { padding-top: 40px; }
            .search-hero { padding: 40px 0; }
        }
        @media (max-width: 480px) {
            .hero-actions { flex-direction: column; }
            .btn-hero-primary, .btn-hero-secondary { justify-content: center; }
            .toast-container-public { right: 12px; left: 12px; }
            .toast-pub { min-width: unset; }
        }

        /* Bootstrap overrides */
        .breadcrumb { background: transparent; padding: 0; margin: 0; }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }
        .pagination .page-link {
            color: var(--primary);
            border-color: var(--border);
            border-radius: var(--radius-sm) !important;
            margin: 0 2px;
            font-size: 14px;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .pagination .page-link:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        .invalid-feedback { font-size: 12px; }
        .btn { border-radius: var(--radius-md) !important; }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Reading Progress Bar -->
    <div class="reading-progress" id="readingProgress"></div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar-main" id="mainNavbar" role="navigation" aria-label="Navigasi Utama">
        <div class="container">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="navbar-brand-custom" aria-label="Blog Kami - Beranda">
                <div class="brand-icon"><i class="bi bi-book-fill"></i></div>
                <div class="brand-text">
                    <span class="brand-name">Blog Kami</span>
                    <span class="brand-tagline">Berbagi Pengetahuan</span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <ul class="navbar-nav-custom navbar-nav-desktop ms-auto" role="list">
                <li>
                    <a href="{{ route('home') }}" class="nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" aria-label="Beranda">
                        <i class="bi bi-house"></i> Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('search.index') }}" class="nav-link-custom {{ request()->routeIs('search.*') ? 'active' : '' }}" aria-label="Cari Artikel">
                        <i class="bi bi-search"></i> Cari
                    </a>
                </li>

                @auth
                {{-- Dashboard Link --}}
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link-custom" style="color: var(--primary); font-weight: 600;" aria-label="Dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                {{-- User Dropdown --}}
                <li style="position: relative;" id="userDropdownNav">
                    <button class="user-pill" id="userPillBtn" onclick="toggleDropdown(event)" aria-haspopup="true" aria-expanded="false" aria-label="Menu Pengguna">
                        <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}"
                             alt="Foto Profil"
                             class="user-pill-avatar"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_depan) }}&background=2563EB&color=fff&size=64'">
                        <div class="user-pill-info">
                            <span class="user-pill-name">{{ Auth::user()->nama_depan }}</span>
                            <span class="user-pill-role"
                                  style="color: {{ Auth::user()->isAdmin() ? '#7C3AED' : (Auth::user()->isPenulis() ? '#2563EB' : '#059669') }};">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <i class="bi bi-chevron-down user-pill-chevron" id="dropdownChevron"></i>
                    </button>

                    <!-- Dropdown -->
                    <div class="user-dropdown" id="userDropdownMenu" role="menu">
                        <div class="dropdown-header">
                            <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}"
                                 alt="Foto Profil"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_depan . '+' . Auth::user()->nama_belakang) }}&background=2563EB&color=fff&size=80'">
                            <div style="min-width: 0;">
                                <div class="dropdown-header-name">{{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }}</div>
                                <div class="dropdown-header-email">{{ Auth::user()->email }}</div>
                                <span class="dropdown-role-badge
                                    @if(Auth::user()->isAdmin()) role-admin-badge
                                    @elseif(Auth::user()->isPenulis()) role-penulis-badge
                                    @else role-tamu-badge @endif">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>
                        <div style="padding: 4px 0;">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item-custom" role="menuitem">
                                <i class="bi bi-person-circle"></i> Profil Saya
                            </a>
                            <a href="{{ route('dashboard') }}" class="dropdown-item-custom" role="menuitem">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </div>
                        <div class="dropdown-divider-custom"></div>
                        <div style="padding: 4px 0;">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item-danger" role="menuitem">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @else
                {{-- Login Button --}}
                <li>
                    <a href="{{ route('login') }}" class="btn-nav-login" aria-label="Masuk">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </a>
                </li>
                @endauth
            </ul>

            <!-- Mobile Toggle -->
            <button class="navbar-toggle-btn ms-auto" id="mobileToggleBtn" onclick="toggleMobileNav()" aria-label="Toggle Navigasi" style="display: none;">
                <i class="bi bi-list" id="mobileToggleIcon"></i>
            </button>
        </div>

        <!-- Mobile Nav -->
        <div class="navbar-mobile" id="mobileNav" role="navigation" aria-label="Navigasi Mobile">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house"></i> Beranda
            </a>
            <a href="{{ route('search.index') }}" class="mobile-nav-link {{ request()->routeIs('search.*') ? 'active' : '' }}">
                <i class="bi bi-search"></i> Cari Artikel
            </a>

            @auth
            <div class="mobile-nav-divider"></div>
            <a href="{{ route('dashboard') }}" class="mobile-nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                <i class="bi bi-person-circle"></i> Profil Saya
            </a>
            <div class="mobile-nav-divider"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mobile-nav-link" style="width: 100%; border: none; background: none; cursor: pointer; color: var(--danger); text-align: left;">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
            @else
            <div class="mobile-nav-divider"></div>
            <a href="{{ route('login') }}" class="mobile-nav-link" style="background: var(--primary-light); color: var(--primary); font-weight: 600;">
                <i class="bi bi-box-arrow-in-right"></i> Masuk / Daftar
            </a>
            @endauth
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    @yield('content')

    <!-- ===== FOOTER ===== -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="row g-4">
                <!-- Brand Col -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="footer-brand">
                        <div class="footer-brand-icon"><i class="bi bi-book-fill"></i></div>
                        <span class="footer-brand-name">Blog Kami</span>
                    </a>
                    <p class="footer-desc">Platform berbagi artikel, tutorial, dan pengetahuan seputar teknologi dan pengembangan web.</p>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('home') }}" style="width:34px;height:34px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);text-decoration:none;transition:all 0.2s ease;font-size:15px;" onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='white';" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.5)';">
                            <i class="bi bi-globe"></i>
                        </a>
                        <a href="{{ route('home') }}" style="width:34px;height:34px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);text-decoration:none;transition:all 0.2s ease;font-size:15px;" onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='white';" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.5)';">
                            <i class="bi bi-rss"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div class="col-lg-2 col-md-3 col-6">
                    <p class="footer-heading">Navigasi</p>
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('search.index') }}" class="footer-link">Cari Artikel</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="footer-link">Masuk</a>
                    <a href="{{ route('register') }}" class="footer-link">Daftar</a>
                    @endauth
                </div>

                <!-- Platform -->
                <div class="col-lg-2 col-md-3 col-6">
                    <p class="footer-heading">Platform</p>
                    <a href="{{ route('login') }}" class="footer-link">Login Penulis</a>
                    <a href="{{ route('register') }}" class="footer-link">Daftar Penulis</a>
                    <a href="{{ route('search.index') }}" class="footer-link">Eksplor Artikel</a>
                </div>

                <!-- Tentang -->
                <div class="col-lg-4 col-md-12">
                    <p class="footer-heading">Tentang Blog</p>
                    <p style="font-size: 13.5px; color: rgba(255,255,255,0.45); line-height: 1.7;">
                        Blog Kami adalah platform open-source untuk berbagi artikel dan pengetahuan. Bergabunglah sebagai penulis dan mulai bagikan ide Anda.
                    </p>
                    <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 6px; margin-top: 12px; background: var(--primary); color: white; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.2s ease;" onmouseover="this.style.background='#1D4ED8';" onmouseout="this.style.background='var(--primary)';">
                        <i class="bi bi-pencil-square"></i> Mulai Menulis
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="footer-bottom-text">&copy; {{ date('Y') }} Blog Kami. Seluruh hak cipta dilindungi.</span>
                    <span class="footer-bottom-text" style="display: flex; align-items: center; gap: 4px;">
                        Dibuat dengan <i class="bi bi-heart-fill" style="color: #EF4444; font-size: 11px;"></i> menggunakan Laravel
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== TOAST ===== -->
    @if(session('sukses') || session('gagal'))
    <div class="toast-container-public" role="alert" aria-live="polite">
        @if(session('sukses'))
        <div class="toast-pub toast-success" id="pubToastSukses">
            <div style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:rgba(16,185,129,0.15);border-radius:50%;font-size:15px;color:var(--success);flex-shrink:0;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Berhasil!</div>
                <div style="font-size:12px;color:var(--text-secondary);">{{ session('sukses') }}</div>
            </div>
            <button onclick="closeToastPub('pubToastSukses')" style="background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:16px;" aria-label="Tutup">
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif
        @if(session('gagal'))
        <div class="toast-pub toast-danger" id="pubToastGagal">
            <div style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:rgba(239,68,68,0.15);border-radius:50%;font-size:15px;color:var(--danger);flex-shrink:0;">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:600;color:var(--text-primary);">Gagal!</div>
                <div style="font-size:12px;color:var(--text-secondary);">{{ session('gagal') }}</div>
            </div>
            <button onclick="closeToastPub('pubToastGagal')" style="background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:16px;" aria-label="Tutup">
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif
    </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll shadow
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) { navbar.classList.add('scrolled'); }
            else { navbar.classList.remove('scrolled'); }

            // Reading progress
            const progressBar = document.getElementById('readingProgress');
            if (progressBar) {
                const doc = document.documentElement;
                const scrolled = (doc.scrollTop + document.body.scrollTop) / (doc.scrollHeight - doc.clientHeight) * 100;
                progressBar.style.width = scrolled + '%';
            }
        }, { passive: true });

        // Mobile nav toggle
        function toggleMobileNav() {
            const nav = document.getElementById('mobileNav');
            const icon = document.getElementById('mobileToggleIcon');
            nav.classList.toggle('open');
            icon.className = nav.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
        }

        // User dropdown toggle
        function toggleDropdown(e) {
            e.preventDefault();
            e.stopPropagation();
            const menu    = document.getElementById('userDropdownMenu');
            const chevron = document.getElementById('dropdownChevron');
            const btn     = document.getElementById('userPillBtn');
            const isOpen  = menu.classList.contains('open');
            menu.classList.toggle('open');
            chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            chevron.style.transition = 'transform 0.2s ease';
            btn.setAttribute('aria-expanded', !isOpen);
        }

        // Close dropdown on outside click
        document.addEventListener('click', function(e) {
            const nav  = document.getElementById('userDropdownNav');
            const menu = document.getElementById('userDropdownMenu');
            const chevron = document.getElementById('dropdownChevron');
            if (nav && menu && !nav.contains(e.target)) {
                menu.classList.remove('open');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        });

        // Toast auto dismiss
        function closeToastPub(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                el.style.transition = 'all 0.3s ease';
                setTimeout(() => el.remove(), 300);
            }
        }
        document.querySelectorAll('.toast-pub').forEach(function(t) {
            setTimeout(function() {
                t.style.opacity = '0';
                t.style.transform = 'translateX(100%)';
                t.style.transition = 'all 0.3s ease';
                setTimeout(() => t.remove(), 300);
            }, 4500);
        });

        // ESC closes mobile nav
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const nav = document.getElementById('mobileNav');
                const icon = document.getElementById('mobileToggleIcon');
                if (nav) { nav.classList.remove('open'); }
                if (icon) icon.className = 'bi bi-list';
                const menu = document.getElementById('userDropdownMenu');
                if (menu) menu.classList.remove('open');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
