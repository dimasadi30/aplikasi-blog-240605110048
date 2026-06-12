@extends('layouts.app')
@section('title', 'Tambah Tag')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Tag</h1>
        <p>Buat tag baru untuk pengelompokan artikel</p>
    </div>
    <a href="{{ route('tags.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-tag me-2" style="color:var(--success);"></i>Data Tag Baru</h2>
            </div>
            <div class="card-body-pad">
                <form action="{{ route('tags.store') }}" method="POST" id="tagForm">
                    @csrf
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="nama_tag" class="form-label-custom">
                            Nama Tag <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               class="form-control-custom @error('nama_tag') is-invalid @enderror"
                               id="nama_tag"
                               name="nama_tag"
                               value="{{ old('nama_tag') }}"
                               placeholder="Masukkan nama tag"
                               autofocus
                               required>
                        @error('nama_tag')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;">
                            <i class="bi bi-info-circle me-1"></i>Gunakan nama yang singkat dan deskriptif
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <a href="{{ route('tags.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Tag
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('tagForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection
