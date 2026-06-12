@extends('layouts.app')
@section('title', 'Kelola Artikel')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Artikel</h1>
        <p>Daftar semua artikel yang dapat Anda kelola</p>
    </div>
    <a href="{{ route('artikel.create') }}" class="btn-primary-custom" id="btn-add-article">
        <i class="bi bi-plus-circle"></i> Tambah Artikel
    </a>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="bi bi-file-earmark-richtext me-2" style="color:var(--primary);"></i>Daftar Artikel</h2>
        <span class="badge-custom badge-primary">
            {{ count($artikel) }} artikel
        </span>
    </div>

    <div style="overflow-x: auto;">
        <table class="table-modern" aria-label="Tabel Artikel">
            <thead>
                <tr>
                    <th style="width:56px;">#</th>
                    <th>Judul Artikel</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th style="width:140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artikel as $item)
                <tr>
                    <td>
                        @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}"
                             alt="{{ $item->judul }}"
                             style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid var(--border);">
                        @else
                        <div style="width:48px;height:48px;background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#93C5FD;font-size:16px;">
                            <i class="bi bi-image"></i>
                        </div>
                        @endif
                    </td>
                    <td>
                        <div style="max-width:240px;">
                            <span style="font-size:13.5px;font-weight:600;color:var(--text-primary);display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $item->judul }}
                            </span>
                            <span style="font-size:11.5px;color:var(--text-muted);">
                                {{ Str::limit(strip_tags($item->isi), 60) }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="badge-custom badge-info">
                            <i class="bi bi-folder"></i>
                            {{ $item->kategori->nama_kategori }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($item->penulis->nama_depan, 0, 1)) }}
                            </div>
                            <span style="font-size:13px;">{{ $item->penulis->nama_depan }}</span>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:13px;color:var(--text-muted);display:flex;align-items:center;gap:4px;">
                            <i class="bi bi-calendar3"></i>
                            {{ $item->hari_tanggal }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <a href="{{ route('artikel.edit', $item->id) }}"
                               class="btn-edit-custom"
                               title="Edit Artikel"
                               aria-label="Edit artikel {{ $item->judul }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('artikel.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus artikel \'{{ addslashes($item->judul) }}\'? Tindakan ini tidak dapat dibatalkan.')"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-danger-custom"
                                        title="Hapus Artikel"
                                        aria-label="Hapus artikel {{ $item->judul }}">
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
                            <div class="empty-state-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <h3>Belum ada artikel</h3>
                            <p>Mulai dengan membuat artikel baru untuk ditampilkan di blog.</p>
                            <a href="{{ route('artikel.create') }}" class="btn-primary-custom mt-2" id="btn-add-first-article">
                                <i class="bi bi-plus-circle"></i> Tambah Artikel Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection