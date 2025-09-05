@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-3">
    <h4 class="fw-bold mb-4">📌 Detail Aspirasi</h4>

    <div class="card shadow-sm border-0 border-start border-4 border-primary w-75">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <tr>
                    <th style="width: 120px;">Nama</th>
                    <td>{{ $aspiration->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $aspiration->email }}</td>
                </tr>
                <tr>
                    <th>Pesan</th>
                    <td>{{ $aspiration->message }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($aspiration->status == 'approved')
                            <span class="badge bg-success px-3 py-2">Disetujui</span>
                        @elseif($aspiration->status == 'rejected')
                            <span class="badge bg-danger px-3 py-2">Ditolak</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">Pending</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="btn-group" role="group">
                <form action="{{ route('admin.aspirations.approve', $aspiration->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="btn btn-success btn-sm">✔ Setujui</button>
                </form>
                <form action="{{ route('admin.aspirations.reject', $aspiration->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="btn btn-warning btn-sm">✖ Tolak</button>
                </form>
                <form action="{{ route('admin.aspirations.destroy', $aspiration->id) }}" method="POST" 
                      onsubmit="return confirm('Yakin hapus aspirasi ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">🗑 Hapus</button>
                </form>
            </div>

            <a href="{{ route('admin.aspirations.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
        </div>
    </div>
</div>
@endsection
