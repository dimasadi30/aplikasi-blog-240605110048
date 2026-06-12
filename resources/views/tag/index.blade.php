@extends('layouts.app')
@section('title', 'Kelola Tags')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Tags</h1>
        <p>Manajemen tag untuk pengelompokan artikel</p>
    </div>
    <a href="{{ route('tags.create') }}" class="btn-primary-custom" id="btn-add-tag">
        <i class="bi bi-plus-circle"></i> Tambah Tag
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="bi bi-tags me-2" style="color:var(--success);"></i>Daftar Tags</h2>
        <span class="badge-custom badge-success">{{ method_exists($tags, 'total') ? $tags->total() : count($tags) }} tag</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="table-modern" aria-label="Tabel Tags">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Nama Tag</th>
                    <th style="width:160px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $index => $item)
                <tr>
                    <td style="font-size:13px;color:var(--text-muted);font-weight:500;">
                        {{ ($tags->currentPage() - 1) * $tags->perPage() + $index + 1 }}
                    </td>
                    <td>
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(16,185,129,0.1);color:var(--success);padding:4px 12px;border-radius:99px;font-size:13px;font-weight:600;border:1px solid rgba(16,185,129,0.2);">
                            <i class="bi bi-tag" style="font-size:11px;"></i>
                            {{ $item->nama_tag }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <a href="{{ route('tags.edit', $item->id) }}"
                               class="btn-edit-custom"
                               aria-label="Edit tag {{ $item->nama_tag }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('tags.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus tag \'{{ addslashes($item->nama_tag) }}\'?')"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-danger-custom"
                                        aria-label="Hapus tag {{ $item->nama_tag }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-tags"></i></div>
                            <h3>Belum ada tag</h3>
                            <p>Tambahkan tag untuk membantu pengorganisasian artikel</p>
                            <a href="{{ route('tags.create') }}" class="btn-primary-custom mt-2">
                                <i class="bi bi-plus-circle"></i> Tambah Tag Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($tags, 'hasPages') && $tags->hasPages())
    <div style="padding:16px;border-top:1px solid var(--border);background:var(--background);">
        {{ $tags->links() }}
    </div>
    @endif
</div>
@endsection
