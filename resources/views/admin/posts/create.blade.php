@extends('admin.layouts.app')

@section('title', 'Tambah Post')
@section('page-title', 'Tambah Post')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Post *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Excerpt/Ringkasan *</label>
                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3"
                        placeholder="Ringkasan singkat untuk preview..." required>{{ old('excerpt') }}</textarea>
                    <small class="text-muted">Maksimal 500 karakter</small>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konten Post *</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10"
                        placeholder="Tulis konten post di sini..." required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    <input type="file" name="featured_image"
                        class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_published" class="form-check-input" value="1"
                            {{ old('is_published') ? 'checked' : '' }}>
                        <label class="form-check-label">Publish Sekarang</label>
                        <small class="d-block text-muted">Jika tidak dicentang, post akan disimpan sebagai draft</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
