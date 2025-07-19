@extends('admin.layouts.app')

@section('title', 'Kelola Aspirasi')
@section('page-title', 'Kelola Aspirasi')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Subjek</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aspirations as $index => $aspiration)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $aspiration->name }}</td>
                                <td>{{ $aspiration->subject }}</td>
                                <td>
                                    @if ($aspiration->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($aspiration->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $aspiration->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.aspirations.show', $aspiration) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if ($aspiration->status == 'pending')
                                        <form action="{{ route('admin.aspirations.approve', $aspiration) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success"
                                                onclick="return confirm('Setujui aspirasi ini?')">
                                                <i class="fas fa-check"></i> Setuju
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.aspirations.reject', $aspiration) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning"
                                                onclick="return confirm('Tolak aspirasi ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.aspirations.destroy', $aspiration) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada aspirasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
