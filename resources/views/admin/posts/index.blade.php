@extends('admin.layouts.app')
@section('title', 'Kelola Blog Posts')
@section('page-title', 'Kelola Blog Posts')
@section('page-actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Post
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Penulis</th>
                            <th width="10%">Tags</th>
                            <th width="10%">Status</th>
                            <th width="10%">Views</th>
                            <th width="10%">Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $index => $post)
                            <tr>
                                <td>{{ $posts->firstItem() + $index }}</td>
                                <td>
                                    @if ($post->featured_image)
                                        <img src="{{ $post->featured_image_url }}" width="50" height="40"
                                            class="rounded object-fit-cover" alt="{{ $post->title }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ Str::limit($post->title, 40) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($post->excerpt, 60) }}</small>
                                        @if ($post->reading_time)
                                            <br>
                                            <small class="badge bg-info">{{ $post->reading_time_text }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $post->user->name }}</td>
                                <td>
                                    @if ($post->tags)
                                        @foreach ($post->tags_array as $tag)
                                            <span class="badge bg-secondary mb-1">{{ $tag }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $post->is_published ? 'success' : 'warning' }}">
                                        {{ $post->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-eye"></i> {{ $post->view_count }}
                                    </span>
                                </td>
                                <td>
                                    @if ($post->published_at)
                                        {{ $post->published_at->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">{{ $post->published_at->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if ($post->is_published)
                                            <a href="{{ route('blog.show', $post) }}" class="btn btn-sm btn-info"
                                                target="_blank" title="Lihat Post">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning"
                                            title="Edit Post">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus post ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Post">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <h5>Belum ada post</h5>
                                        <p>Mulai menulis artikel pertama Anda!</p>
                                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Buat Post Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($posts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>

    @if ($posts->count() > 0)
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">{{ $posts->total() }}</h5>
                                <small>Total Posts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">{{ $posts->where('is_published', true)->count() }}</h5>
                                <small>Published</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">{{ $posts->where('is_published', false)->count() }}</h5>
                                <small>Drafts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-eye fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">{{ $posts->sum('view_count') }}</h5>
                                <small>Total Views</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
