@extends('layouts.app')
@section('title', 'Kelola Akun')

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Akun</h1>
        <p>Manajemen semua pengguna terdaftar dalam sistem</p>
    </div>
    <a href="{{ route('penulis.create') }}" class="btn-primary-custom" id="btn-add-user">
        <i class="bi bi-person-plus"></i> Tambah Akun
    </a>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="bi bi-people me-2" style="color:var(--primary);"></i>
            Daftar Pengguna
        </h2>
        <span class="badge-custom badge-primary">
            {{ method_exists($penulis, 'total') ? $penulis->total() : count($penulis) }} pengguna
        </span>
    </div>

    <div style="overflow-x: auto;">
        <table class="table-modern" aria-label="Tabel Pengguna">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Pengguna</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width:150px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penulis as $index => $item)
                <tr>
                    <td style="font-size:13px;color:var(--text-muted);font-weight:500;">
                        {{ ($penulis->currentPage() - 1) * $penulis->perPage() + $index + 1 }}
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="position:relative;flex-shrink:0;">
                                <img src="{{ asset('storage/foto/' . $item->foto) }}"
                                     alt="{{ $item->nama_depan }}"
                                     style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid var(--border);"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($item->nama_depan . '+' . $item->nama_belakang) }}&background=2563EB&color=fff&size=80'">
                            </div>
                            <div>
                                <div style="font-size:13.5px;font-weight:600;color:var(--text-primary);">
                                    {{ $item->nama_depan }} {{ $item->nama_belakang }}
                                    @if($item->id === Auth::id())
                                    <span style="font-size:10px;background:rgba(16,185,129,0.1);color:var(--success);padding:1px 7px;border-radius:99px;font-weight:600;margin-left:4px;">Anda</span>
                                    @endif
                                </div>
                                <div style="font-size:12px;color:var(--text-muted);">ID: {{ $item->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <code style="font-size:12.5px;background:var(--background);padding:3px 8px;border-radius:6px;color:var(--text-secondary);">
                            {{ $item->user_name }}
                        </code>
                    </td>
                    <td>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $item->email }}</span>
                    </td>
                    <td>
                        @if($item->role === 'admin')
                        <span class="badge-custom badge-purple">
                            <i class="bi bi-lightning-charge"></i> Admin
                        </span>
                        @elseif($item->role === 'penulis')
                        <span class="badge-custom badge-primary">
                            <i class="bi bi-pencil"></i> Penulis
                        </span>
                        @else
                        <span class="badge-custom badge-success">
                            <i class="bi bi-person"></i> Tamu
                        </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <a href="{{ route('penulis.edit', $item->id) }}"
                               class="btn-edit-custom"
                               aria-label="Edit akun {{ $item->nama_depan }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('penulis.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus akun {{ addslashes($item->nama_depan . ' ' . $item->nama_belakang) }}? Tindakan ini tidak dapat dibatalkan.')"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-danger-custom"
                                        aria-label="Hapus akun {{ $item->nama_depan }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-people"></i></div>
                            <h3>Belum ada data pengguna</h3>
                            <p>Mulai dengan menambahkan akun pengguna baru</p>
                            <a href="{{ route('penulis.create') }}" class="btn-primary-custom mt-2">
                                <i class="bi bi-person-plus"></i> Tambah Akun Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($penulis, 'hasPages') && $penulis->hasPages())
    <div style="padding:16px;border-top:1px solid var(--border);background:var(--background);">
        {{ $penulis->links() }}
    </div>
    @endif
</div>
@endsection