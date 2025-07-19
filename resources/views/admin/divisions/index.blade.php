@extends('admin.layouts.app')

@section('title', 'Kelola Divisi')
@section('page-title', 'Kelola Divisi')

@section('page-actions')
    <a href="{{ route('admin.divisions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Divisi
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Anggota</th>
                            <th>Status</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisions as $index => $division)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($division->icon)
                                        <img src="{{ asset('storage/' . $division->icon) }}" width="30" height="30"
                                            class="me-2">
                                    @endif
                                    {{ $division->name }}
                                </td>
                                <td><code>{{ $division->slug }}</code></td>
                                <td>{{ $division->members_count ?? $division->members->count() }}</td>
                                <td>
                                    <span class="badge bg-{{ $division->is_active ? 'success' : 'danger' }}">
                                        {{ $division->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>{{ $division->sort_order }}</td>
                                <td>
                                    <a href="{{ route('admin.divisions.edit', $division) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.divisions.destroy', $division) }}" method="POST"
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
                                <td colspan="7" class="text-center">Belum ada divisi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
