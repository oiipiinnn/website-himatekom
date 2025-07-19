@extends('admin.layouts.app')

@section('title', 'Kelola Gallery')
@section('page-title', 'Kelola Gallery')

@section('page-actions')
    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Foto
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @forelse($galleries as $gallery)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="{{ $gallery->image_url }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1">{{ $gallery->title }}</h6>
                                @if ($gallery->event_name)
                                    <small class="text-muted">{{ $gallery->event_name }}</small>
                                @endif
                                <div class="mt-2">
                                    <span class="badge bg-{{ $gallery->is_active ? 'success' : 'danger' }}">
                                        {{ $gallery->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada foto dalam gallery</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
