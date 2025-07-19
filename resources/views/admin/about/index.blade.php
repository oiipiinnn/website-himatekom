@extends('admin.layouts.app')

@section('title', 'Pengaturan About')
@section('page-title', 'Pengaturan About')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Judul About *</label>
                            <input type="text" name="about_title"
                                class="form-control @error('about_title') is-invalid @enderror"
                                value="{{ old('about_title', $settings['about_title']->value ?? '') }}" required>
                            @error('about_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Subtitle About *</label>
                            <input type="text" name="about_subtitle"
                                class="form-control @error('about_subtitle') is-invalid @enderror"
                                value="{{ old('about_subtitle', $settings['about_subtitle']->value ?? '') }}" required>
                            @error('about_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi About *</label>
                    <textarea name="about_description" class="form-control @error('about_description') is-invalid @enderror" rows="4"
                        required>{{ old('about_description', $settings['about_description']->value ?? '') }}</textarea>
                    @error('about_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul History *</label>
                    <input type="text" name="history_title"
                        class="form-control @error('history_title') is-invalid @enderror"
                        value="{{ old('history_title', $settings['history_title']->value ?? '') }}" required>
                    @error('history_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Judul Lokasi *</label>
                            <input type="text" name="location_title"
                                class="form-control @error('location_title') is-invalid @enderror"
                                value="{{ old('location_title', $settings['location_title']->value ?? '') }}" required>
                            @error('location_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Subtitle Lokasi *</label>
                            <input type="text" name="location_subtitle"
                                class="form-control @error('location_subtitle') is-invalid @enderror"
                                value="{{ old('location_subtitle', $settings['location_subtitle']->value ?? '') }}"
                                required>
                            @error('location_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat *</label>
                    <input type="text" name="location_address"
                        class="form-control @error('location_address') is-invalid @enderror"
                        value="{{ old('location_address', $settings['location_address']->value ?? '') }}" required>
                    @error('location_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi Kantor *</label>
                    <input type="text" name="location_office"
                        class="form-control @error('location_office') is-invalid @enderror"
                        value="{{ old('location_office', $settings['location_office']->value ?? '') }}" required>
                    @error('location_office')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Logo About</label>
                    @if (isset($settings['about_logo']) && $settings['about_logo']->value)
                        <div class="mb-2">
                            <img src="{{ asset($settings['about_logo']->value) }}" width="100" height="100"
                                class="border rounded">
                            <small class="d-block text-muted">Logo saat ini</small>
                        </div>
                    @endif
                    <input type="file" name="about_logo" class="form-control @error('about_logo') is-invalid @enderror"
                        accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                    @error('about_logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
