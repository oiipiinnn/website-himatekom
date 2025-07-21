@extends('admin.layouts.app')

@section('title', 'Data Mahasiswa')

@section('page-title', 'Data Mahasiswa')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Mahasiswa
        </a>
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-download"></i> Export
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.students.export') }}">Export Semua</a></li>
            @foreach ($batches as $batch)
                <li><a class="dropdown-item" href="{{ route('admin.students.export') }}?batch={{ $batch }}">Export
                        Angkatan {{ $batch }}</a></li>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Mahasiswa</div>
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
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Approval</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
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
            <form method="GET" action="{{ route('admin.students.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, NIM, email..."
                            value="{{ request('search') }}">
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
                        <select name="sort" class="form-control">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru
                            </option>
                            <option value="full_name" {{ request('sort') == 'full_name' ? 'selected' : '' }}>Nama</option>
                            <option value="nim" {{ request('sort') == 'nim' ? 'selected' : '' }}>NIM</option>
                            <option value="batch" {{ request('sort') == 'batch' ? 'selected' : '' }}>Angkatan</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="order" class="form-control">
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A</option>
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                @if (request()->hasAny(['search', 'status', 'batch', 'sort', 'order']))
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset Filter
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card shadow mb-4" id="bulkActionsCard" style="display: none;">
        <div class="card-header py-3 bg-info">
            <h6 class="m-0 font-weight-bold text-white">
                <span id="selectedCount">0</span> mahasiswa dipilih
            </h6>
        </div>
        <div class="card-body">
            <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="bulkApprove()">
                    <i class="fas fa-check"></i> Setujui Semua
                </button>
                <button type="button" class="btn btn-danger" onclick="bulkReject()">
                    <i class="fas fa-times"></i> Tolak Semua
                </button>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Daftar Mahasiswa ({{ $students->total() }} total)
                </h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">
                        Pilih Semua
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="masterCheck">
                                </th>
                                <th width="80">Foto</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Angkatan</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="student-checkbox" value="{{ $student->id }}">
                                    </td>
                                    <td>
                                        <img src="{{ $student->casual_photo_url }}" alt="{{ $student->full_name }}"
                                            class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $student->full_name }}</strong>
                                        @if ($student->bio)
                                            <br><small class="text-muted">{{ Str::limit($student->bio, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $student->nim }}</td>
                                    <td>{{ $student->batch }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        @if ($student->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($student->status == 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                        @if (!$student->is_active)
                                            <br><span class="badge badge-secondary">Inactive</span>
                                        @endif
                                        @if (!$student->show_in_public)
                                            <br><span class="badge badge-dark">Hidden</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.students.show', $student) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.students.edit', $student) }}"
                                                class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($student->isPending())
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="approveStudent({{ $student->id }})" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="rejectStudent({{ $student->id }})" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item"
                                                            onclick="toggleActive({{ $student->id }})">
                                                            <i
                                                                class="fas fa-{{ $student->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                            {{ $student->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item"
                                                            onclick="togglePublic({{ $student->id }})">
                                                            <i
                                                                class="fas fa-{{ $student->show_in_public ? 'lock' : 'unlock' }}"></i>
                                                            {{ $student->show_in_public ? 'Sembunyikan' : 'Tampilkan' }}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteStudent({{ $student->id }})">
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
                    {{ $students->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data mahasiswa</h5>
                    <p class="text-muted">Belum ada mahasiswa yang mendaftar atau sesuai dengan filter Anda.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan</label>
                            <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan..."
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Reject Modal -->
    <div class="modal fade" id="bulkRejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Beberapa Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="bulkRejectForm" method="POST" action="{{ route('admin.students.bulk-reject') }}">
                    @csrf
                    <input type="hidden" name="student_ids" id="bulkRejectIds">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan</label>
                            <textarea name="bulk_rejection_reason" class="form-control" rows="4"
                                placeholder="Jelaskan alasan penolakan untuk semua mahasiswa yang dipilih..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Checkbox handling
            const masterCheck = document.getElementById('masterCheck');
            const studentCheckboxes = document.querySelectorAll('.student-checkbox');
            const bulkActionsCard = document.getElementById('bulkActionsCard');
            const selectedCount = document.getElementById('selectedCount');

            function updateBulkActions() {
                const checked = document.querySelectorAll('.student-checkbox:checked');
                if (checked.length > 0) {
                    bulkActionsCard.style.display = 'block';
                    selectedCount.textContent = checked.length;
                } else {
                    bulkActionsCard.style.display = 'none';
                }
            }

            masterCheck?.addEventListener('change', function() {
                studentCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });

            studentCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });
        });

        // Individual actions
        function approveStudent(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran mahasiswa ini?')) {
                fetch(`/admin/students/${id}/approve`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(() => location.reload());
            }
        }

        function rejectStudent(id) {
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            document.getElementById('rejectForm').action = `/admin/students/${id}/reject`;
            modal.show();
        }

        function toggleActive(id) {
            fetch(`/admin/students/${id}/toggle-active`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => location.reload());
        }

        function togglePublic(id) {
            fetch(`/admin/students/${id}/toggle-public`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => location.reload());
        }

        function deleteStudent(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini? Tindakan ini tidak dapat dibatalkan.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/students/${id}`;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Bulk actions
        function bulkApprove() {
            const checked = Array.from(document.querySelectorAll('.student-checkbox:checked')).map(cb => cb.value);
            if (checked.length === 0) return;

            if (confirm(`Apakah Anda yakin ingin menyetujui ${checked.length} pendaftaran mahasiswa?`)) {
                fetch('/admin/students/bulk-approve', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        student_ids: checked
                    })
                }).then(() => location.reload());
            }
        }

        function bulkReject() {
            const checked = Array.from(document.querySelectorAll('.student-checkbox:checked')).map(cb => cb.value);
            if (checked.length === 0) return;

            document.getElementById('bulkRejectIds').value = JSON.stringify(checked);
            const modal = new bootstrap.Modal(document.getElementById('bulkRejectModal'));
            modal.show();
        }
    </script>
@endsection

<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
</style>
