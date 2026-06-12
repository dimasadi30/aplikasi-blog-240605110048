@extends('layouts.app')
@section('title', 'Moderasi Komentar')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Moderasi Komentar</h1>
        <p>Review dan kelola semua komentar dari pengunjung blog</p>
    </div>
    <!-- Stats -->
    <div style="display:flex;gap:8px;">
        @php
            $allKomentar = $komentar;
            $pending  = $komentar->filter(fn($k) => $k->status === 'pending')->count();
            $approved = $komentar->filter(fn($k) => $k->status === 'approved')->count();
        @endphp
        @if($pending > 0)
        <div style="display:flex;align-items:center;gap:6px;background:rgba(245,158,11,0.1);color:var(--warning);border:1px solid rgba(245,158,11,0.2);padding:6px 14px;border-radius:var(--radius-md);font-size:13px;font-weight:600;">
            <i class="bi bi-clock-history"></i> {{ $pending }} Pending
        </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="bi bi-chat-square-dots me-2" style="color:var(--primary);"></i>Daftar Komentar</h2>
        <span class="badge-custom badge-primary">{{ method_exists($komentar, 'total') ? $komentar->total() : count($komentar) }} total</span>
    </div>

    <div style="overflow-x:auto;">
        <table class="table-modern" aria-label="Tabel Komentar">
            <thead>
                <tr>
                    <th style="width:36px;">#</th>
                    <th>Artikel</th>
                    <th>Pengirim</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th style="width:200px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($komentar as $index => $item)
                <tr>
                    <td style="font-size:12px;color:var(--text-muted);font-weight:500;">
                        {{ ($komentar->currentPage() - 1) * $komentar->perPage() + $index + 1 }}
                    </td>
                    <td style="max-width:160px;">
                        <a href="{{ route('article.show', optional($item->artikel)->slug ?? '#') }}"
                           style="font-size:12.5px;font-weight:600;color:var(--text-primary);text-decoration:none;display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;transition:color 0.2s ease;"
                           onmouseover="this.style.color='var(--primary)';"
                           onmouseout="this.style.color='var(--text-primary)';"
                           target="_blank" rel="noopener">
                            {{ Str::limit(optional($item->artikel)->judul ?? '—', 40) }}
                        </a>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;flex-shrink:0;">
                                @if($item->user)
                                    {{ strtoupper(substr($item->user->nama_depan, 0, 1)) }}
                                @else
                                    {{ strtoupper(substr($item->nama_tamu ?? 'T', 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:600;color:var(--text-primary);">
                                    @if($item->user)
                                        {{ $item->user->nama_depan . ' ' . $item->user->nama_belakang }}
                                    @else
                                        {{ $item->nama_tamu ?? '—' }}
                                    @endif
                                </div>
                                @if($item->user)
                                <div style="font-size:10.5px;color:var(--success);font-weight:600;">Member</div>
                                @else
                                <div style="font-size:10.5px;color:var(--text-muted);">Tamu</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="max-width:220px;">
                        <p style="font-size:12.5px;color:var(--text-secondary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:0;" title="{{ $item->isi_komentar }}">
                            {{ $item->isi_komentar }}
                        </p>
                        <span style="font-size:11px;color:var(--text-muted);">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</span>
                    </td>
                    <td>
                        @if($item->status === 'approved')
                        <span class="badge-custom badge-success">
                            <i class="bi bi-check-circle"></i> Approved
                        </span>
                        @elseif($item->status === 'pending')
                        <span class="badge-custom badge-warning">
                            <i class="bi bi-clock-history"></i> Pending
                        </span>
                        @elseif($item->status === 'rejected')
                        <span class="badge-custom badge-danger">
                            <i class="bi bi-x-circle"></i> Rejected
                        </span>
                        @elseif($item->status === 'spam')
                        <span class="badge-custom badge-muted">
                            <i class="bi bi-shield-exclamation"></i> Spam
                        </span>
                        @else
                        <span class="badge-custom badge-muted">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:5px;flex-wrap:wrap;">
                            @if($item->status === 'pending')
                            <!-- Approve -->
                            <form action="{{ route('komentar.approve', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        class="btn-success-custom"
                                        title="Setujui komentar"
                                        aria-label="Approve komentar">
                                    <i class="bi bi-check-lg"></i> Approve
                                </button>
                            </form>
                            <!-- Reject -->
                            <form action="{{ route('komentar.reject', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        class="btn-danger-custom"
                                        title="Tolak komentar"
                                        aria-label="Reject komentar">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </button>
                            </form>
                            @endif
                            <!-- Hapus -->
                            <form action="{{ route('komentar.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus komentar ini secara permanen?')"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-danger-custom"
                                        title="Hapus permanen"
                                        aria-label="Hapus komentar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-chat-dots"></i></div>
                            <h3>Belum ada komentar</h3>
                            <p>Komentar dari pengunjung akan muncul di sini untuk dimoderasi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($komentar, 'hasPages') && $komentar->hasPages())
    <div style="padding:16px;border-top:1px solid var(--border);background:var(--background);">
        {{ $komentar->links() }}
    </div>
    @endif
</div>
@endsection
