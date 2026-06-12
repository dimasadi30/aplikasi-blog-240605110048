@extends('layouts.app')
@section('title', 'Dashboard')

@yield('styles')

@section('content')
<style>
    /* ===== KPI CARDS ===== */
    .kpi-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 22px 22px 18px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: rgba(37,99,235,0.25);
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--kpi-color, var(--primary)), var(--kpi-color2, var(--accent)));
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }
    .kpi-card-blue   { --kpi-color: #2563EB; --kpi-color2: #60A5FA; }
    .kpi-card-green  { --kpi-color: #10B981; --kpi-color2: #34D399; }
    .kpi-card-amber  { --kpi-color: #F59E0B; --kpi-color2: #FCD34D; }
    .kpi-card-purple { --kpi-color: #8B5CF6; --kpi-color2: #A78BFA; }

    .kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .kpi-icon-blue   { background: rgba(37,99,235,0.1);  color: #2563EB; }
    .kpi-icon-green  { background: rgba(16,185,129,0.1); color: #10B981; }
    .kpi-icon-amber  { background: rgba(245,158,11,0.1); color: #F59E0B; }
    .kpi-icon-purple { background: rgba(139,92,246,0.1); color: #8B5CF6; }

    .kpi-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        margin-bottom: 4px;
    }
    .kpi-value {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }
    .kpi-sub {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, #0F172A 0%, #1E3A8A 60%, #1E293B 100%);
        border-radius: var(--radius-xl);
        padding: 32px 36px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(37,99,235,0.3) 0%, transparent 70%);
        right: -80px;
        top: -80px;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
        right: 40px;
        bottom: -60px;
    }
    .welcome-text { position: relative; z-index: 1; }
    .welcome-greeting {
        font-size: 13px;
        color: rgba(255,255,255,0.6);
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }
    .welcome-name {
        font-family: 'Poppins', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    .welcome-desc {
        font-size: 13.5px;
        color: rgba(255,255,255,0.65);
        max-width: 400px;
    }
    .welcome-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.85);
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-top: 10px;
    }
    .welcome-icon-wrap {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: rgba(255,255,255,0.7);
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 18px 12px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        text-align: center;
    }
    .quick-action-btn:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .quick-action-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .quick-action-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-secondary);
        transition: var(--transition);
    }
    .quick-action-btn:hover .quick-action-label { color: var(--primary); }

    /* ===== RECENT ARTICLES TABLE ===== */
    .recent-articles-table { width: 100%; border-collapse: collapse; }
    .recent-articles-table th {
        background: var(--background);
        padding: 10px 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
        text-align: left;
    }
    .recent-articles-table td {
        padding: 12px 14px;
        border-bottom: 1px solid var(--border-light);
        font-size: 13.5px;
        vertical-align: middle;
    }
    .recent-articles-table tbody tr:last-child td { border-bottom: none; }
    .recent-articles-table tbody tr:hover { background: rgba(37,99,235,0.02); }

    /* Activity Timeline */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-item {
        display: flex;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-light);
        position: relative;
    }
    .timeline-item:last-child { border-bottom: none; }
    .timeline-dot {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .timeline-content { flex: 1; min-width: 0; }
    .timeline-text { font-size: 13px; color: var(--text-primary); line-height: 1.45; }
    .timeline-text strong { font-weight: 600; }
    .timeline-time { font-size: 11.5px; color: var(--text-muted); margin-top: 3px; }
</style>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-text">
        <span class="welcome-greeting">Selamat datang kembali 👋</span>
        <h1 class="welcome-name">{{ $nama_lengkap }}</h1>
        <p class="welcome-desc">Kelola konten blog Anda dari sini. Apa yang ingin Anda lakukan hari ini?</p>
        <div class="welcome-role-badge">
            <i class="bi bi-shield-check"></i>
            {{ ucfirst($role) }}
        </div>
    </div>
    <div class="welcome-icon-wrap">
        @if(Auth::user()->isAdmin())
            <i class="bi bi-lightning-charge"></i>
        @elseif(Auth::user()->isPenulis())
            <i class="bi bi-pencil-square"></i>
        @else
            <i class="bi bi-person-circle"></i>
        @endif
    </div>
</div>

<!-- KPI Stats -->
@if(isset($total_artikel))
<div class="row g-3 mb-4">
    <div class="{{ isset($total_kategori) && isset($total_penulis) ? 'col-lg-3 col-md-6' : (isset($total_kategori) ? 'col-md-6' : 'col-12') }}">
        <div class="kpi-card kpi-card-blue animate-fade-up" style="animation-delay: 0.05s;">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Total Artikel</div>
                    <div class="kpi-value">{{ $total_artikel }}</div>
                    <div class="kpi-sub">Artikel yang diterbitkan</div>
                </div>
                <div class="kpi-icon kpi-icon-blue"><i class="bi bi-file-earmark-richtext"></i></div>
            </div>
            @if(Auth::user()->isPenulis() || Auth::user()->isAdmin())
            <a href="{{ route('artikel.index') }}" style="font-size:12px;color:var(--primary);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px;">
                Kelola Artikel <i class="bi bi-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>

    @if(isset($total_kategori))
    <div class="{{ isset($total_penulis) ? 'col-lg-3 col-md-6' : 'col-md-6' }}">
        <div class="kpi-card kpi-card-amber animate-fade-up" style="animation-delay: 0.1s;">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Total Kategori</div>
                    <div class="kpi-value">{{ $total_kategori }}</div>
                    <div class="kpi-sub">Kategori artikel</div>
                </div>
                <div class="kpi-icon kpi-icon-amber"><i class="bi bi-folder2-open"></i></div>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('kategori.index') }}" style="font-size:12px;color:var(--warning);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px;">
                Kelola Kategori <i class="bi bi-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>
    @endif

    @if(isset($total_penulis))
    <div class="col-lg-3 col-md-6">
        <div class="kpi-card kpi-card-green animate-fade-up" style="animation-delay: 0.15s;">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Total Penulis</div>
                    <div class="kpi-value">{{ $total_penulis }}</div>
                    <div class="kpi-sub">Pengguna terdaftar</div>
                </div>
                <div class="kpi-icon kpi-icon-green"><i class="bi bi-people"></i></div>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('penulis.index') }}" style="font-size:12px;color:var(--success);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px;">
                Kelola Akun <i class="bi bi-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="kpi-card kpi-card-purple animate-fade-up" style="animation-delay: 0.2s;">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Login Sebagai</div>
                    <div class="kpi-value" style="font-size:1.3rem;">{{ ucfirst($role) }}</div>
                    <div class="kpi-sub">{{ $waktu_login }}</div>
                </div>
                <div class="kpi-icon kpi-icon-purple"><i class="bi bi-clock-history"></i></div>
            </div>
            <a href="{{ route('profile.edit') }}" style="font-size:12px;color:var(--purple);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px;">
                Edit Profil <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@else
<!-- Info Cards (for non-penulis/admin) -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="kpi-card kpi-card-blue animate-fade-up">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Login sebagai</div>
                    <div class="kpi-value" style="font-size:1.25rem;">{{ ucfirst($role) }}</div>
                </div>
                <div class="kpi-icon kpi-icon-blue"><i class="bi bi-person-badge"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="kpi-card kpi-card-purple animate-fade-up" style="animation-delay:0.05s;">
            <div class="kpi-top">
                <div>
                    <div class="kpi-label">Waktu Login</div>
                    <div class="kpi-value" style="font-size:1.1rem;">{{ $waktu_login }}</div>
                </div>
                <div class="kpi-icon kpi-icon-purple"><i class="bi bi-clock-history"></i></div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="card mb-4 animate-fade-up" style="animation-delay: 0.25s;">
    <div class="card-header">
        <h2 class="card-title"><i class="bi bi-lightning-charge me-2" style="color:var(--warning);"></i>Aksi Cepat</h2>
    </div>
    <div class="card-body-pad">
        <div class="row g-3">
            @if(Auth::user()->isPenulis() || Auth::user()->isAdmin())
            <div class="col-6 col-md-3">
                <a href="{{ route('artikel.create') }}" class="quick-action-btn" id="btn-new-article">
                    <div class="quick-action-icon" style="background: rgba(37,99,235,0.1); color: var(--primary);">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <span class="quick-action-label">Tulis Artikel</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('artikel.index') }}" class="quick-action-btn" id="btn-my-articles">
                    <div class="quick-action-icon" style="background: rgba(16,185,129,0.1); color: var(--success);">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <span class="quick-action-label">Artikel Saya</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->isAdmin())
            <div class="col-6 col-md-3">
                <a href="{{ route('penulis.index') }}" class="quick-action-btn" id="btn-manage-users">
                    <div class="quick-action-icon" style="background: rgba(245,158,11,0.1); color: var(--warning);">
                        <i class="bi bi-people"></i>
                    </div>
                    <span class="quick-action-label">Kelola Akun</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('komentar.index') }}" class="quick-action-btn" id="btn-comments">
                    <div class="quick-action-icon" style="background: rgba(139,92,246,0.1); color: var(--purple);">
                        <i class="bi bi-chat-square-dots"></i>
                    </div>
                    <span class="quick-action-label">Komentar</span>
                </a>
            </div>
            @endif
            <div class="col-6 col-md-3">
                <a href="{{ route('profile.edit') }}" class="quick-action-btn" id="btn-profile">
                    <div class="quick-action-icon" style="background: rgba(14,165,233,0.1); color: var(--info);">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <span class="quick-action-label">Edit Profil</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('home') }}" class="quick-action-btn" id="btn-view-blog" target="_blank" rel="noopener">
                    <div class="quick-action-icon" style="background: rgba(239,68,68,0.1); color: var(--danger);">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <span class="quick-action-label">Lihat Blog</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('search.index') }}" class="quick-action-btn" id="btn-search">
                    <div class="quick-action-icon" style="background: rgba(16,185,129,0.1); color: var(--success);">
                        <i class="bi bi-search"></i>
                    </div>
                    <span class="quick-action-label">Cari Artikel</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row g-4 animate-fade-up" style="animation-delay: 0.3s;">
    <!-- Activity Timeline -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-activity me-2" style="color:var(--primary);"></i>Info Akun</h2>
            </div>
            <div class="card-body-pad">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: rgba(16,185,129,0.1); color: var(--success);">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-text">Login berhasil sebagai <strong>{{ ucfirst($role) }}</strong></div>
                            <div class="timeline-time">{{ $waktu_login }}</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: rgba(37,99,235,0.1); color: var(--primary);">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-text">Profil: <strong>{{ Auth::user()->nama_depan }} {{ Auth::user()->nama_belakang }}</strong></div>
                            <div class="timeline-time">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    @if(isset($total_artikel))
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: rgba(245,158,11,0.1); color: var(--warning);">
                            <i class="bi bi-file-earmark-richtext"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-text">Total <strong>{{ $total_artikel }}</strong> artikel tersedia di sistem</div>
                            <div class="timeline-time">Data terkini</div>
                        </div>
                    </div>
                    @endif
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background: rgba(139,92,246,0.1); color: var(--purple);">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-text">Sesi aktif dan aman</div>
                            <div class="timeline-time">Status keamanan: OK</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Getting Started / Tips -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-lightbulb me-2" style="color:var(--warning);"></i>Panduan Cepat</h2>
            </div>
            <div class="card-body-pad">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @if(Auth::user()->isPenulis() || Auth::user()->isAdmin())
                    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px;background:var(--background);border-radius:var(--radius-md);">
                        <div style="width:36px;height:36px;background:rgba(37,99,235,0.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:16px;flex-shrink:0;">
                            <i class="bi bi-1-circle-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Tulis Artikel Baru</div>
                            <div style="font-size:12.5px;color:var(--text-muted);">Klik "Kelola Artikel" → "Tambah Artikel" untuk membuat artikel baru.</div>
                        </div>
                    </div>
                    @endif
                    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px;background:var(--background);border-radius:var(--radius-md);">
                        <div style="width:36px;height:36px;background:rgba(16,185,129,0.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--success);font-size:16px;flex-shrink:0;">
                            <i class="bi bi-2-circle-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Lengkapi Profil</div>
                            <div style="font-size:12.5px;color:var(--text-muted);">Tambahkan foto profil dan bio untuk tampil lebih profesional.</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px;background:var(--background);border-radius:var(--radius-md);">
                        <div style="width:36px;height:36px;background:rgba(245,158,11,0.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--warning);font-size:16px;flex-shrink:0;">
                            <i class="bi bi-3-circle-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Jelajahi Blog</div>
                            <div style="font-size:12.5px;color:var(--text-muted);">Kunjungi halaman utama blog untuk melihat semua artikel yang dipublikasikan.</div>
                        </div>
                    </div>
                    @if(Auth::user()->isAdmin())
                    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px;background:var(--background);border-radius:var(--radius-md);">
                        <div style="width:36px;height:36px;background:rgba(139,92,246,0.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--purple);font-size:16px;flex-shrink:0;">
                            <i class="bi bi-4-circle-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px;">Moderasi Komentar</div>
                            <div style="font-size:12.5px;color:var(--text-muted);">Review dan setujui komentar yang masuk melalui menu "Moderasi Komentar".</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection