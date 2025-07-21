@extends('admin.layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa - ' . $student->full_name)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Data
        </a>

        @if ($student->isPending())
            <button type="button" class="btn btn-success" onclick="approveStudent({{ $student->id }})">
                <i class="fas fa-check"></i> Setujui
            </button>
            <button type="button" class="btn btn-danger" onclick="rejectStudent({{ $student->id }})">
                <i class="fas fa-times"></i> Tolak
            </button>
        @endif

        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-cog"></i> Lainnya
            </button>
            <ul class="dropdown-menu">
                <li>
                    <button class="dropdown-item" onclick="toggleActive({{ $student->id }})">
                        <i class="fas fa-{{ $student->is_active ? 'eye-slash' : 'eye' }}"></i>
                        {{ $student->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </li>
                <li>
                    <button class="dropdown-item" onclick="togglePublic({{ $student->id }})">
                        <i class="fas fa-{{ $student->show_in_public ? 'lock' : 'unlock' }}"></i>
                        {{ $student->show_in_public ? 'Sembunyikan dari Publik' : 'Tampilkan ke Publik' }}
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('students.show', $student) }}" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Lihat di Frontend
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <button class="dropdown-item text-danger" onclick="deleteStudent({{ $student->id }})">
                        <i class="fas fa-trash"></i> Hapus Data
                    </button>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <!-- Status Alert -->
    <div class="row mb-4">
        <div class="col-lg-12">
            @if ($student->status == 'pending')
                <div class="alert alert-warning">
                    <i class="fas fa-clock"></i> Pendaftaran ini masih menunggu persetujuan.
                </div>
            @elseif($student->status == 'approved')
                <div class="alert alert-success">
                    <i class="fas fa-check"></i> Pendaftaran telah disetujui
                    @if ($student->approver)
                        oleh {{ $student->approver->name }}
                    @endif
                    pada {{ $student->approved_at->format('d F Y, H:i') }}.
                </div>
            @else
                <div class="alert alert-danger">
                    <i class="fas fa-times"></i> Pendaftaran ditolak.
                    @if ($student->rejection_reason)
                        <br><strong>Alasan:</strong> {{ $student->rejection_reason }}
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Photos -->
        <div class="col-lg-4">
            <!-- Profile Photo -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Profil</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $student->casual_photo_url }}" alt="{{ $student->full_name }}"
                        class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    <h5 class="font-weight-bold">{{ $student->full_name }}</h5>
                    <p class="text-muted">{{ $student->nim }} - Angkatan {{ $student->batch }}</p>
                </div>
            </div>

            <!-- Work Photo -->
            @if ($student->work_photo_url)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Foto Baju Kerja Himatekom</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $student->work_photo_url }}" alt="Foto Kerja {{ $student->full_name }}"
                            class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                    </div>
                </div>
            @endif

            <!-- Validation Document -->
            @if ($student->validation_document_url)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Dokumen Validasi</h6>
                    </div>
                    <div class="card-body text-center">
                        @if (Str::endsWith($student->validation_document, '.pdf'))
                            <div class="mb-3">
                                <i class="fas fa-file-pdf fa-5x text-danger"></i>
                                <p class="mt-2">Dokumen PDF</p>
                            </div>
                            <a href="{{ $student->validation_document_url }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-download"></i> Lihat/Download PDF
                            </a>
                        @else
                            <img src="{{ $student->validation_document_url }}" alt="Dokumen Validasi"
                                class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                            <br>
                            <a href="{{ $student->validation_document_url }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-external-link-alt"></i> Lihat Full Size
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column - Information -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Dasar</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Nama Lengkap</strong></td>
                                    <td>: {{ $student->full_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>NIM</strong></td>
                                    <td>: {{ $student->nim }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>: {{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telepon</strong></td>
                                    <td>: {{ $student->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Angkatan</strong></td>
                                    <td>: {{ $student->batch }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Jenis Kelamin</strong></td>
                                    <td>: {{ $student->gender_label }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td>: {{ $student->birth_date ? $student->birth_date->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Umur</strong></td>
                                    <td>: {{ $student->age ?? '-' }} tahun</td>
                                </tr>
                                <tr>
                                    <td><strong>Asal Daerah</strong></td>
                                    <td>: {{ $student->hometown ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pekerjaan</strong></td>
                                    <td>: {{ $student->current_job ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bio -->
            @if ($student->bio)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Bio</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $student->bio }}</p>
                    </div>
                </div>
            @endif

            <!-- Skills -->
            @if ($student->skills && count($student->skills) > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Keahlian</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($student->skills as $skill)
                            <span class="badge badge-primary mr-2 mb-2 p-2">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Hobbies -->
            @if ($student->hobbies && count($student->hobbies) > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hobi</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($student->hobbies as $hobby)
                            <span class="badge badge-info mr-2 mb-2 p-2">{{ $hobby }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Career Goal -->
            @if ($student->career_goal)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tujuan Karir</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $student->career_goal }}</p>
                    </div>
                </div>
            @endif

            <!-- Social Links -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Media Sosial & Portfolio</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if ($student->instagram)
                            <div class="col-md-6 mb-2">
                                <i class="fab fa-instagram text-danger"></i>
                                <a href="{{ $student->instagram }}" target="_blank" class="ml-2">Instagram</a>
                            </div>
                        @endif
                        @if ($student->linkedin)
                            <div class="col-md-6 mb-2">
                                <i class="fab fa-linkedin text-primary"></i>
                                <a href="{{ $student->linkedin }}" target="_blank" class="ml-2">LinkedIn</a>
                            </div>
                        @endif
                        @if ($student->tiktok)
                            <div class="col-md-6 mb-2">
                                <i class="fab fa-tiktok text-dark"></i>
                                <a href="{{ $student->tiktok }}" target="_blank" class="ml-2">TikTok</a>
                            </div>
                        @endif
                        @if ($student->github)
                            <div class="col-md-6 mb-2">
                                <i class="fab fa-github text-dark"></i>
                                <a href="{{ $student->github }}" target="_blank" class="ml-2">GitHub</a>
                            </div>
                        @endif
                        @if ($student->portfolio_url)
                            <div class="col-md-6 mb-2">
                                <i class="fas fa-globe text-info"></i>
                                <a href="{{ $student->portfolio_url }}" target="_blank" class="ml-2">Portfolio</a>
                            </div>
                        @endif
                        @if (!$student->instagram && !$student->linkedin && !$student->tiktok && !$student->github && !$student->portfolio_url)
                            <div class="col-12">
                                <p class="text-muted mb-0">Tidak ada media sosial yang didaftarkan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Registration Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Status</strong></td>
                                    <td>: {!! $student->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Daftar</strong></td>
                                    <td>: {{ $student->created_at->format('d F Y, H:i') }}</td>
                                </tr>
                                @if ($student->approved_at)
                                    <tr>
                                        <td><strong>Tanggal Disetujui</strong></td>
                                        <td>: {{ $student->approved_at->format('d F Y, H:i') }}</td>
                                    </tr>
                                @endif
                                @if ($student->approver)
                                    <tr>
                                        <td><strong>Disetujui Oleh</strong></td>
                                        <td>: {{ $student->approver->name }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Status Aktif</strong></td>
                                    <td>:
                                        @if ($student->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tampil di Publik</strong></td>
                                    <td>:
                                        @if ($student->show_in_public)
                                            <span class="badge badge-success">Ya</span>
                                        @else
                                            <span class="badge badge-warning">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Terakhir Update</strong></td>
                                    <td>: {{ $student->updated_at->format('d F Y, H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($student->rejection_reason)
                        <div class="alert alert-danger mt-3">
                            <strong>Alasan Penolakan:</strong><br>
                            {{ $student->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>
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
                <form id="rejectForm" method="POST" action="{{ route('admin.students.reject', $student) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan</label>
                            <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan..."
                                required></textarea>
                            <div class="form-text">Alasan ini akan dikirim ke email mahasiswa.</div>
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

@endsection

@section('scripts')
    <script>
        function approveStudent(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran mahasiswa ini?')) {
                fetch(`/admin/students/${id}/approve`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan saat menyetujui pendaftaran');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyetujui pendaftaran');
                    });
            }
        }

        function rejectStudent(id) {
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        function toggleActive(id) {
            const action = '{{ $student->is_active ? 'nonaktifkan' : 'aktifkan' }}';

            if (confirm(`Apakah Anda yakin ingin ${action} mahasiswa ini?`)) {
                fetch(`/admin/students/${id}/toggle-active`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan saat mengubah status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status');
                    });
            }
        }

        function togglePublic(id) {
            const action = '{{ $student->show_in_public ? 'sembunyikan dari' : 'tampilkan ke' }}';

            if (confirm(`Apakah Anda yakin ingin ${action} publik mahasiswa ini?`)) {
                fetch(`/admin/students/${id}/toggle-public`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan saat mengubah visibility');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah visibility');
                    });
            }
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
    </script>
@endsection
