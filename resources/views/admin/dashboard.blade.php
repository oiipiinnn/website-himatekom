@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistics Cards Row 1 -->
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pengurus Aktif</div>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Data Mahasiswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['students_approved'] }}</div>
                            <small class="text-muted">{{ $stats['students_total'] }} total</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['students_pending'] }}</div>
                            <small class="text-muted">Mahasiswa</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Row 2 -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Blog Posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['posts_published'] }}</div>
                            <small class="text-muted">{{ $stats['posts'] }} total</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-blog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Gallery Photos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['galleries'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Aspirasi Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['aspirations_pending'] }}</div>
                            <small class="text-muted">{{ $stats['aspirations_total'] }} total</small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mahasiswa Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['students_rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pending Students -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Mahasiswa Pending Approval</h6>
                    <a href="{{ route('admin.students.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentStudents->count() > 0)
                        @foreach ($recentStudents as $student)
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img src="{{ $student->casual_photo_url }}" alt="{{ $student->full_name }}"
                                    class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $student->full_name }}</h6>
                                    <small class="text-muted">{{ $student->nim }} - Angkatan {{ $student->batch }}</small>
                                    <br><small class="text-muted">{{ $student->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('admin.students.show', $student) }}"
                                        class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-success"
                                        onclick="quickApprove({{ $student->id }})" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-muted">Tidak ada mahasiswa yang menunggu persetujuan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Post Terbaru</h6>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentPosts->count() > 0)
                        @foreach ($recentPosts as $post)
                            <div class="border-bottom py-3">
                                <h6 class="mb-1">{{ $post->title }}</h6>
                                <small class="text-muted">{{ $post->user->name }} -
                                    {{ $post->created_at->format('d M Y') }}</small>
                                <p class="mb-1 mt-2">{{ Str::limit($post->excerpt, 100) }}</p>
                                <span class="badge bg-{{ $post->is_published ? 'success' : 'warning' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada post.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Students by Batch Chart -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mahasiswa per Angkatan</h6>
                </div>
                <div class="card-body">
                    @if ($studentsByBatch->count() > 0)
                        <canvas id="batchChart" width="400" height="200"></canvas>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data mahasiswa</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Skills -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Skills Mahasiswa</h6>
                </div>
                <div class="card-body">
                    @if ($topSkills->count() > 0)
                        @foreach ($topSkills as $skill => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-primary p-2">{{ $skill }}</span>
                                <span class="text-muted">{{ $count }} mahasiswa</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-code fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data skills</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Aspirations -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Aspirasi Terbaru (Pending)</h6>
                    <a href="{{ route('admin.aspirations.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentAspirations->count() > 0)
                        <div class="row">
                            @foreach ($recentAspirations as $aspiration)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h6 class="mb-1">{{ $aspiration->subject }}</h6>
                                        <small class="text-muted">{{ $aspiration->name }} -
                                            {{ $aspiration->created_at->format('d M Y') }}</small>
                                        <p class="mb-2 mt-2">{{ Str::limit($aspiration->message, 100) }}</p>
                                        <a href="{{ route('admin.aspirations.show', $aspiration) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-success mb-3"></i>
                            <p class="text-muted">Tidak ada aspirasi pending.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Students by Batch Chart
        @if ($studentsByBatch->count() > 0)
            const batchCtx = document.getElementById('batchChart').getContext('2d');
            const batchChart = new Chart(batchCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($studentsByBatch->pluck('batch')->toArray()) !!},
                    datasets: [{
                        label: 'Jumlah Mahasiswa',
                        data: {!! json_encode($studentsByBatch->pluck('count')->toArray()) !!},
                        backgroundColor: 'rgba(0, 103, 56, 0.8)',
                        borderColor: 'rgba(0, 103, 56, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        @endif

        // Quick approve function
        function quickApprove(studentId) {
            if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran mahasiswa ini?')) {
                fetch(`/admin/students/${studentId}/approve`, {
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
    </script>

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

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .border-left-secondary {
            border-left: 0.25rem solid #858796 !important;
        }

        .border-left-dark {
            border-left: 0.25rem solid #5a5c69 !important;
        }
    </style>
@endsection
