@extends('admin.layouts.app')

@section('title', 'Detail Anggota')
@section('page-title', 'Detail Anggota - ' . $member->student->full_name)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-cog"></i> Aksi
            </button>
            <ul class="dropdown-menu">
                <li>
                    <button class="dropdown-item" onclick="toggleActive({{ $member->id }})">
                        <i class="fas fa-{{ $member->is_active ? 'eye-slash' : 'eye' }}"></i>
                        {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </li>
                @if (!$member->is_alumni && $member->status !== 'alumni')
                    <li>
                        <button class="dropdown-item" onclick="makeAlumni({{ $member->id }})">
                            <i class="fas fa-graduation-cap"></i> Jadikan Alumni
                        </button>
                    </li>
                @endif
                @if ($member->student_id)
                    <li>
                        <button class="dropdown-item" onclick="syncFromStudent({{ $member->id }})">
                            <i class="fas fa-sync"></i> Sinkronkan Data
                        </button>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Left Column - Member Profile -->
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card profile-card shadow mb-4">
                <div class="card-body text-center">
                    <div class="profile-image-container mb-3">
                        <img src="{{ $member->student->casual_photo_url }}"
                            alt="{{ $member->name }}" class="profile-image" loading="lazy">
                        @if ($member->student_id)
                            <div class="connection-indicator">
                                <i class="fas fa-link"></i>
                                <span>Terhubung dengan Data Mahasiswa</span>
                            </div>
                        @endif
                    </div>

                    <h4 class="profile-name">{{ $member->name }}</h4>
                    <div class="profile-position">{{ $member->position }}</div>

                    <!-- Status Tags -->
                    <div class="profile-tags mt-3">
                        <span class="tag tag-division">
                            <i class="fas fa-building"></i>
                            {{ $member->division->name }}
                        </span>

                        <span class="tag tag-level-{{ $member->position_level }}">
                            @if ($member->position_level == 1)
                                <i class="fas fa-crown"></i>
                            @elseif($member->position_level == 2)
                                <i class="fas fa-star"></i>
                            @elseif($member->position_level == 3)
                                <i class="fas fa-users-cog"></i>
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                            Level {{ $member->position_level }}
                        </span>

                        <span
                            class="tag tag-status-{{ $member->status }} {{ !$member->is_active ? 'tag-inactive' : '' }}">
                            @if ($member->status == 'active')
                                <i class="fas fa-check-circle"></i>
                            @elseif($member->status == 'alumni')
                                <i class="fas fa-graduation-cap"></i>
                            @else
                                <i class="fas fa-pause-circle"></i>
                            @endif
                            {{ ucfirst($member->status) }}
                            @if (!$member->is_active)
                                (Nonaktif)
                            @endif
                        </span>
                    </div>

                    <!-- Quick Stats -->
                    <div class="profile-stats mt-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-value">{{ $member->batch }}</div>
                                <div class="stat-label">Angkatan</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-value">{{ $member->tenure ?? 0 }}</div>
                                <div class="stat-label">Bulan</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-value">{{ $member->position_level }}</div>
                                <div class="stat-label">Level</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info Card -->
            <div class="card info-card shadow mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-address-card"></i> Informasi Kontak
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-id-card"></i>
                            NIM
                        </div>
                        <div class="info-value">{{ $member->nim }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </div>
                        <div class="info-value">
                            <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                        </div>
                    </div>

                    @if ($member->phone)
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-phone"></i>
                                Telepon
                            </div>
                            <div class="info-value">
                                <a href="tel:{{ $member->phone }}">{{ $member->phone }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-venus-mars"></i>
                            Jenis Kelamin
                        </div>
                        <div class="info-value">{{ $member->gender_label }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Detailed Information -->
        <div class="col-lg-8">
            <!-- Position & Division Details -->
            <div class="card info-card shadow mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-crown"></i> Jabatan & Organisasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Posisi/Jabatan</label>
                                <div class="detail-value">{{ $member->position }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Divisi</label>
                                <div class="detail-value">
                                    <span class="badge badge-primary">{{ $member->division->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Level Posisi</label>
                                <div class="detail-value">
                                    <span class="badge badge-secondary">Level {{ $member->position_level }}</span>
                                    <small class="d-block text-muted">{{ $member->position_level_label }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Status Keanggotaan</label>
                                <div class="detail-value">
                                    {!! $member->status_badge !!}
                                    @if (!$member->is_active)
                                        <span class="badge badge-warning">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tenure Information -->
            <div class="card info-card shadow mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-alt"></i> Masa Jabatan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <label>Mulai Menjabat</label>
                                <div class="detail-value">
                                    @if ($member->start_date)
                                        {{ $member->start_date->format('d M Y') }}
                                        <small
                                            class="d-block text-muted">{{ $member->start_date->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <label>Berakhir/Target</label>
                                <div class="detail-value">
                                    @if ($member->end_date)
                                        {{ $member->end_date->format('d M Y') }}
                                        <small class="d-block text-muted">{{ $member->end_date->diffForHumans() }}</small>
                                    @else
                                        <span class="text-success">Masih Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <label>Lama Menjabat</label>
                                <div class="detail-value">
                                    @if ($member->tenure)
                                        <span class="badge badge-info">{{ $member->tenure }} Bulan</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motivation & Notes -->
            @if ($member->motivation || $member->notes)
                <div class="card info-card shadow mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-comment-alt"></i> Catatan & Motivasi
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($member->motivation)
                            <div class="detail-item mb-3">
                                <label>Motivasi Bergabung</label>
                                <div class="detail-value">
                                    <div class="motivation-text">{{ $member->motivation }}</div>
                                </div>
                            </div>
                        @endif

                        @if ($member->notes)
                            <div class="detail-item">
                                <label>Catatan Admin</label>
                                <div class="detail-value">
                                    <div class="notes-text">{{ $member->notes }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Student Bio -->
            @if ($member->student->bio)
                <div class="card info-card shadow mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-user-circle"></i> Profil Mahasiswa
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="bio-text">{{ $member->student->bio }}</div>
                    </div>
                </div>
            @endif

            <!-- Activity Timeline -->
            <div class="card info-card shadow mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history"></i> Riwayat Aktivitas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Bergabung sebagai {{ $member->position }}</h6>
                                <p class="text-muted mb-0">
                                    {{ $member->start_date ? $member->start_date->format('d M Y') : 'Tanggal tidak diketahui' }}
                                </p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6>Registrasi Data Mahasiswa</h6>
                                <p class="text-muted mb-0">
                                    {{ $member->student->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        @if ($member->end_date)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6>Berakhir Menjabat</h6>
                                    <p class="text-muted mb-0">
                                        {{ $member->end_date->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleActive(id) {
            const action = confirm('Apakah Anda yakin ingin mengubah status aktif anggota ini?');

            if (action) {
                fetch(`/admin/members/${id}/toggle-active`, {
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

        function makeAlumni(id) {
            if (confirm('Apakah Anda yakin ingin menjadikan anggota ini sebagai alumni?')) {
                fetch(`/admin/members/${id}/make-alumni`, {
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
                            alert('Terjadi kesalahan saat mengubah status alumni');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status alumni');
                    });
            }
        }

        function syncFromStudent(id) {
            if (confirm('Sinkronkan data anggota dengan data mahasiswa? Data yang ada akan ditimpa.')) {
                fetch(`/admin/members/${id}/sync-from-student`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan saat sinkronisasi data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat sinkronisasi data');
                    });
            }
        }
    </script>

    <style>
        /* Profile Card */
        .profile-card {
            border-radius: 20px;
            border: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff
        }

        .profile-image-container {
            position: relative
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, .3);
            margin: 0 auto;
            display: block
        }

        .connection-indicator {
            background: rgba(255, 255, 255, .2);
            border-radius: 20px;
            padding: 8px 12px;
            margin-top: 10px;
            font-size: .8rem;
            backdrop-filter: blur(10px)
        }

        .profile-name {
            font-weight: 700;
            margin-bottom: 5px
        }

        .profile-position {
            font-size: 1.1rem;
            opacity: .9;
            margin-bottom: 20px
        }

        .profile-tags .tag {
            margin: 3px
        }

        .profile-stats {
            border-top: 1px solid rgba(255, 255, 255, .2);
            padding-top: 20px
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700
        }

        .stat-label {
            font-size: .8rem;
            opacity: .8;
            text-transform: uppercase;
            letter-spacing: 1px
        }

        /* Info Cards */
        .info-card {
            border-radius: 15px;
            border: none
        }

        .card-title {
            color: #2c3e50;
            font-weight: 600
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f8f9fa
        }

        .info-item:last-child {
            border-bottom: none
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .info-value {
            text-align: right
        }

        .info-value a {
            color: #4e73df;
            text-decoration: none
        }

        .info-value a:hover {
            text-decoration: underline
        }

        /* Detail Items */
        .detail-item {
            margin-bottom: 20px
        }

        .detail-item label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            display: block
        }

        .detail-value {
            color: #495057
        }

        /* Text Areas */
        .motivation-text,
        .notes-text,
        .bio-text {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #4e73df;
            line-height: 1.6
        }

        /* Tags (konsisten dengan index) */
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin: 2px
        }

        .tag-division {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff
        }

        .tag-level-1 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #fff
        }

        .tag-level-2 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: #fff
        }

        .tag-level-3 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: #fff
        }

        .tag-level-4 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: #fff
        }

        .tag-status-active {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #fff
        }

        .tag-status-inactive {
            background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
            color: #fff
        }

        .tag-status-alumni {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #fff
        }

        .tag-inactive {
            opacity: .7;
            text-decoration: line-through
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 30px
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            height: 100%;
            width: 2px;
            background: #e9ecef
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px
        }

        .timeline-marker {
            position: absolute;
            left: -23px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #fff
        }

        .timeline-content h6 {
            margin-bottom: 5px;
            color: #2c3e50
        }

        /* Responsive */
        @media (max-width:768px) {
            .profile-stats .row {
                text-align: center
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px
            }

            .info-value {
                text-align: left
            }
        }
    </style>
@endsection
