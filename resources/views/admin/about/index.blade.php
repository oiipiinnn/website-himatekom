@extends('admin.layouts.app')
@section('title', 'Pengaturan About')
@section('page-title', 'Pengaturan Halaman About')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pengaturan Konten Halaman About</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- About Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Informasi Utama</h5>

                                <div class="mb-3">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $settings['title'] ?? '') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" name="subtitle"
                                        class="form-control @error('subtitle') is-invalid @enderror"
                                        value="{{ old('subtitle', $settings['subtitle'] ?? '') }}" required>
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $settings['description'] ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Logo/Gambar</label>
                                    @if (isset($settings['logo_image']))
                                        <div class="mb-2">
                                            <img src="{{ asset($settings['logo_image']) }}" width="100" height="100"
                                                class="border rounded">
                                            <small class="d-block text-muted">Gambar saat ini</small>
                                        </div>
                                    @endif
                                    <input type="file" name="logo_image"
                                        class="form-control @error('logo_image') is-invalid @enderror" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                    @error('logo_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Visi & Misi</h5>

                                <div class="mb-3">
                                    <label class="form-label">Visi</label>
                                    <textarea name="visi" class="form-control @error('visi') is-invalid @enderror" rows="3" required>{{ old('visi', $settings['visi'] ?? '') }}</textarea>
                                    @error('visi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Misi</label>
                                    <div id="misi-container">
                                        @forelse(old('misi', $misi) as $index => $misiItem)
                                            <div class="input-group mb-2 misi-item">
                                                <input type="text" name="misi[]" class="form-control"
                                                    value="{{ $misiItem }}" placeholder="Masukkan poin misi" required>
                                                <button type="button" class="btn btn-danger remove-misi">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @empty
                                            <div class="input-group mb-2 misi-item">
                                                <input type="text" name="misi[]" class="form-control"
                                                    placeholder="Masukkan poin misi" required>
                                                <button type="button" class="btn btn-danger remove-misi">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforelse
                                    </div>
                                    <button type="button" id="add-misi" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus"></i> Tambah Misi
                                    </button>
                                    @error('misi.*')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Statistics Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Statistik Manual</h5>

                                <div class="mb-3">
                                    <label class="form-label">Jumlah Program Kerja</label>
                                    <input type="number" name="program_kerja_count"
                                        class="form-control @error('program_kerja_count') is-invalid @enderror"
                                        value="{{ old('program_kerja_count', $settings['program_kerja_count'] ?? 25) }}"
                                        min="0" required>
                                    @error('program_kerja_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jumlah Main Event</label>
                                    <input type="number" name="main_event_count"
                                        class="form-control @error('main_event_count') is-invalid @enderror"
                                        value="{{ old('main_event_count', $settings['main_event_count'] ?? 3) }}"
                                        min="0" required>
                                    @error('main_event_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Lokasi</h5>

                                <div class="mb-3">
                                    <label class="form-label">Judul History</label>
                                    <input type="text" name="history_title"
                                        class="form-control @error('history_title') is-invalid @enderror"
                                        value="{{ old('history_title', $settings['history_title'] ?? '') }}" required>
                                    @error('history_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Judul Lokasi</label>
                                    <input type="text" name="location_title"
                                        class="form-control @error('location_title') is-invalid @enderror"
                                        value="{{ old('location_title', $settings['location_title'] ?? '') }}" required>
                                    @error('location_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtitle Lokasi</label>
                                    <input type="text" name="location_subtitle"
                                        class="form-control @error('location_subtitle') is-invalid @enderror"
                                        value="{{ old('location_subtitle', $settings['location_subtitle'] ?? '') }}"
                                        required>
                                    @error('location_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="location_address" class="form-control @error('location_address') is-invalid @enderror"
                                        rows="2" required>{{ old('location_address', $settings['location_address'] ?? '') }}</textarea>
                                    @error('location_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Ruang</label>
                                    <input type="text" name="location_office"
                                        class="form-control @error('location_office') is-invalid @enderror"
                                        value="{{ old('location_office', $settings['location_office'] ?? '') }}" required>
                                    @error('location_office')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add misi functionality
            document.getElementById('add-misi').addEventListener('click', function() {
                const container = document.getElementById('misi-container');
                const newItem = document.createElement('div');
                newItem.className = 'input-group mb-2 misi-item';
                newItem.innerHTML = `
            <input type="text" name="misi[]" class="form-control" placeholder="Masukkan poin misi" required>
            <button type="button" class="btn btn-danger remove-misi">
                <i class="fas fa-trash"></i>
            </button>
        `;
                container.appendChild(newItem);
            });

            // Remove misi functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-misi') || e.target.closest('.remove-misi')) {
                    const misiItems = document.querySelectorAll('.misi-item');
                    if (misiItems.length > 1) {
                        e.target.closest('.misi-item').remove();
                    } else {
                        alert('Minimal harus ada satu poin misi');
                    }
                }
            });
        });
    </script>
@endsection
