@extends('admin.layouts.app')

@section('title', 'Data Anggota Pengurus')
@section('page-title', 'Data Anggota Pengurus')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-download"></i> Export
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.members.export') }}">Export Semua</a></li>
            @foreach ($divisions as $division)
                <li>
                    <a class="dropdown-item" href="{{ route('admin.members.export') }}?division={{ $division->id }}">
                        Export {{ $division->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pimpinan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['leaders'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-crown fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alumni</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['alumni'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.members.index') }}">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, NIM..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="division" class="form-control">
                            <option value="">Semua Divisi</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ request('division') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="batch" class="form-control">
                            <option value="">Semua Angkatan</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>
                                    {{ $batch }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="position_level" class="form-control">
                            <option value="">Semua Level</option>
                            @foreach ($positionLevels as $level => $label)
                                <option value="{{ $level }}"
                                    {{ request('position_level') == $level ? 'selected' : '' }}>
                                    Level {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Urutkan:</label>
                            <select name="sort" class="form-control me-2" style="width:auto;">
                                <option value="position_level" {{ request('sort') == 'position_level' ? 'selected' : '' }}>
                                    Level Posisi</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="nim" {{ request('sort') == 'nim' ? 'selected' : '' }}>NIM</option>
                                <option value="batch" {{ request('sort') == 'batch' ? 'selected' : '' }}>Angkatan</option>
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal
                                    Bergabung</option>
                            </select>
                            <select name="order" class="form-control" style="width:auto;">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        @if (request()->hasAny(['search', 'division', 'batch', 'status', 'position_level', 'sort', 'order']))
                            <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Members Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Anggota Pengurus ({{ $members->total() }} total)
            </h6>
        </div>
        <div class="card-body">
            @if ($members->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="80">Foto</th>
                                <th>Nama & Posisi</th>
                                <th>NIM</th>
                                <th>Divisi</th>
                                <th>Level</th>
                                <th>Angkatan</th>
                                <th>Status</th>
                                <th>Masa Jabatan</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr class="{{ !$member->is_active ? 'table-secondary' : '' }}">
                                    <td>
                                        <div class="position-relative">
                                            <img src="{{ $member->student->casual_photo_url }}"
                                                alt="{{ $member->name }}" class="rounded-circle" loading="lazy"
                                                style="width:50px;height:50px;object-fit:cover;">
                                            @if ($member->student_id)
                                                <span class="badge bg-success position-absolute"
                                                    style="top:-5px;right:-5px;font-size:10px;"
                                                    title="Terhubung dengan data mahasiswa">
                                                    <i class="fas fa-link"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $member->name }}</strong>
                                        <br><span class="text-primary">{{ $member->position }}</span>
                                        @if (optional($member->student)->bio)
                                            <br><small
                                                class="text-muted">{{ \Illuminate\Support\Str::limit($member->student->bio, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $member->nim }}</td>
                                    <td><span class="badge bg-primary">{{ $member->division->name }}</span></td>
                                    <td>
                                        @if ($member->position_level == 1)
                                            <span class="badge bg-danger"><i class="fas fa-crown"></i> Level
                                                {{ $member->position_level }}</span>
                                        @elseif($member->position_level == 2)
                                            <span class="badge bg-warning"><i class="fas fa-star"></i> Level
                                                {{ $member->position_level }}</span>
                                        @elseif($member->position_level == 3)
                                            <span class="badge bg-info"><i class="fas fa-users-cog"></i> Level
                                                {{ $member->position_level }}</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-user"></i> Level
                                                {{ $member->position_level }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $member->batch }}</td>
                                    <td>
                                        @if ($member->status == 'active')
                                            <span class="badge bg-success"><i class="fas fa-check-circle"></i>
                                                Aktif</span>
                                        @elseif($member->status == 'alumni')
                                            <span class="badge bg-info"><i class="fas fa-graduation-cap"></i>
                                                Alumni</span>
                                        @else
                                            <span class="badge bg-warning"><i class="fas fa-pause-circle"></i> Tidak
                                                Aktif</span>
                                        @endif

                                        @if (!$member->is_active)
                                            <br><span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($member->start_date)
                                            <small>
                                                Mulai: {{ $member->start_date->format('M Y') }}
                                                @if ($member->end_date)
                                                    <br>Berakhir: {{ $member->end_date->format('M Y') }}
                                                @endif
                                                @if ($member->tenure)
                                                    <br><span class="badge bg-info">{{ $member->tenure }} bulan</span>
                                                @endif
                                            </small>
                                        @else
                                            <small class="text-muted">Tidak diketahui</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.members.show', $member) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.members.edit', $member) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item"
                                                            onclick="toggleActive({{ $member->id }})">
                                                            <i
                                                                class="fas fa-{{ $member->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                            {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                        </button>
                                                    </li>
                                                    @if (!$member->is_alumni && $member->status !== 'alumni')
                                                        <li>
                                                            <button class="dropdown-item"
                                                                onclick="makeAlumni({{ $member->id }})">
                                                                <i class="fas fa-graduation-cap"></i> Jadikan Alumni
                                                            </button>
                                                        </li>
                                                    @endif
                                                    @if ($member->student_id)
                                                        <li>
                                                            <button class="dropdown-item"
                                                                onclick="syncFromStudent({{ $member->id }})">
                                                                <i class="fas fa-sync"></i> Sinkronkan Data
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.students.show', $member->student) }}">
                                                                <i class="fas fa-external-link-alt"></i> Lihat Data
                                                                Mahasiswa
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteMember({{ $member->id }})">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $members->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h5>Tidak ada data anggota</h5>
                        <p>Belum ada anggota yang terdaftar atau sesuai dengan filter Anda.</p>
                        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Anggota Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleActive(id) {
            if (!confirm('Apakah Anda yakin ingin mengubah status aktif anggota ini?')) return;
            fetch(`/admin/members/${id}/toggle-active`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(r => r.ok ? location.reload() : alert('Terjadi kesalahan saat mengubah status'))
                .catch(() => alert('Terjadi kesalahan saat mengubah status'));
        }

        function makeAlumni(id) {
            if (!confirm('Apakah Anda yakin ingin menjadikan anggota ini sebagai alumni?')) return;
            fetch(`/admin/members/${id}/make-alumni`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(r => r.ok ? location.reload() : alert('Terjadi kesalahan saat mengubah status alumni'))
                .catch(() => alert('Terjadi kesalahan saat mengubah status alumni'));
        }

        function syncFromStudent(id) {
            if (!confirm('Sinkronkan data anggota dengan data mahasiswa? Data yang ada akan ditimpa.')) return;
            fetch(`/admin/members/${id}/sync-from-student`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(r => r.ok ? location.reload() : alert('Terjadi kesalahan saat sinkronisasi data'))
                .catch(() => alert('Terjadi kesalahan saat sinkronisasi data'));
        }

        function deleteMember(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data anggota ini? Tindakan ini tidak dapat dibatalkan.'))
        return;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/members/${id}`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <style>
        .border-left-primary {
            border-left: .25rem solid #4e73df !important
        }

        .border-left-success {
            border-left: .25rem solid #1cc88a !important
        }

        .border-left-info {
            border-left: .25rem solid #36b9cc !important
        }

        .border-left-warning {
            border-left: .25rem solid #f6c23e !important
        }
    </style>
@endsection
