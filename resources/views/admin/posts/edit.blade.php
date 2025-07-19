@extends('admin.layouts.app')

@section('title', 'Edit Post')
@section('page-title', 'Edit Post')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Judul Post *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Excerpt/Ringkasan *</label>
                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                    <small class="text-muted">Maksimal 500 karakter</small>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konten Post *</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    @if ($post->featured_image)
                        <div class="mb-2">
                            <img src="{{ $post->featured_image_url }}" width="200" height="120" class="border rounded">
                            <small class="d-block text-muted">Gambar saat ini</small>
                        </div>
                    @endif
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
                            {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label">Publish</label>
                        <small class="d-block text-muted">
                            @if ($post->is_published && $post->published_at)
                                Dipublish pada: {{ $post->published_at->format('d M Y H:i') }}
                            @else
                                Belum dipublish (draft)
                            @endif
                        </small>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
