@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Kategori</h1>
        <p>Manajemen kategori untuk mengorganisir artikel</p>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn-primary-custom" id="btn-add-kategori">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="bi bi-folder2-open me-2" style="color:var(--warning);"></i>Daftar Kategori</h2>
        <span class="badge-custom badge-warning">
            {{ method_exists($kategori, 'total') ? $kategori->total() : count($kategori) }} kategori
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="table-modern" aria-label="Tabel Kategori">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Nama Kategori</th>
                    <th>Keterangan</th>
                    <th style="width:160px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $index => $item)
                <tr>
                    <td style="font-size:13px;color:var(--text-muted);font-weight:500;">
                        {{ ($kategori->currentPage() - 1) * $kategori->perPage() + $index + 1 }}
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;background:rgba(245,158,11,0.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--warning);font-size:15px;flex-shrink:0;">
                                <i class="bi bi-folder-fill"></i>
                            </div>
                            <span style="font-size:13.5px;font-weight:600;color:var(--text-primary);">{{ $item->nama_kategori }}</span>
                        </div>
                    </td>
                    <td style="font-size:13px;color:var(--text-secondary);">{{ $item->keterangan ?? '—' }}</td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <a href="{{ route('kategori.edit', $item->id) }}"
                               class="btn-edit-custom"
                               aria-label="Edit kategori {{ $item->nama_kategori }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('kategori.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus kategori \'{{ addslashes($item->nama_kategori) }}\'?')"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-danger-custom"
                                        aria-label="Hapus kategori {{ $item->nama_kategori }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-folder-x"></i></div>
                            <h3>Belum ada kategori</h3>
                            <p>Tambahkan kategori untuk mengorganisir artikel</p>
                            <a href="{{ route('kategori.create') }}" class="btn-primary-custom mt-2">
                                <i class="bi bi-plus-circle"></i> Tambah Kategori
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($kategori, 'hasPages') && $kategori->hasPages())
    <div style="padding:16px;border-top:1px solid var(--border);background:var(--background);">
        {{ $kategori->links() }}
    </div>
    @endif
</div>
@endsection