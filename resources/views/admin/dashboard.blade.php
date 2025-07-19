@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Divisi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['divisions'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Anggota Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['members'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Blog Posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['posts'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-blog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Aspirasi Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['aspirations_pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aspirasi Terbaru (Pending)</h6>
                </div>
                <div class="card-body">
                    @if ($recentAspirations->count() > 0)
                        @foreach ($recentAspirations as $aspiration)
                            <div class="border-bottom py-2">
                                <h6 class="mb-1">{{ $aspiration->subject }}</h6>
                                <small class="text-muted">{{ $aspiration->name }} -
                                    {{ $aspiration->created_at->format('d M Y') }}</small>
                                <p class="mb-1">{{ Str::limit($aspiration->message, 100) }}</p>
                                <a href="{{ route('admin.aspirations.show', $aspiration) }}"
                                    class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Tidak ada aspirasi pending.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Post Terbaru</h6>
                </div>
                <div class="card-body">
                    @if ($recentPosts->count() > 0)
                        @foreach ($recentPosts as $post)
                            <div class="border-bottom py-2">
                                <h6 class="mb-1">{{ $post->title }}</h6>
                                <small class="text-muted">{{ $post->user->name }} -
                                    {{ $post->created_at->format('d M Y') }}</small>
                                <p class="mb-1">{{ Str::limit($post->excerpt, 100) }}</p>
                                <span class="badge bg-{{ $post->is_published ? 'success' : 'warning' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada post.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
    </style>
@endsection
