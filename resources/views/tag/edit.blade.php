@extends('layouts.app')
@section('title', 'Edit Tag')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Tag</h1>
        <p>Memperbarui tag: <strong>{{ $tag->nama_tag }}</strong></p>
    </div>
    <a href="{{ route('tags.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-tag me-2" style="color:var(--success);"></i>Edit Data Tag</h2>
            </div>
            <div class="card-body-pad">
                <form action="{{ route('tags.update', $tag->id) }}" method="POST" id="editTagForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="nama_tag" class="form-label-custom">
                            Nama Tag <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               class="form-control-custom @error('nama_tag') is-invalid @enderror"
                               id="nama_tag"
                               name="nama_tag"
                               value="{{ old('nama_tag', $tag->nama_tag) }}"
                               placeholder="Nama tag"
                               autofocus
                               required>
                        @error('nama_tag')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <a href="{{ route('tags.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editTagForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection
