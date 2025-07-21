@extends('layouts.main')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Data Mahasiswa</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Data Mahasiswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Hero Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Warga Himatekom</span>
                        <h2>Teknik Komputer UNAND</h2>
                        <p style="max-width: 700px; margin: 0 auto; color: #adadad; font-size: 16px; line-height: 1.6;">
                            Temukan dan kenali mahasiswa Teknik Komputer Universitas Andalas.
                            Jelajahi profil, keahlian, dan prestasi dari komunitas tech terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Filter Section Begin -->
    <section class="services-page" style="padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-wrapper">
                        <div class="filter-header">
                            <h3><i class="fa fa-search"></i> Pencarian & Filter</h3>
                            <p>Temukan mahasiswa berdasarkan kriteria yang Anda inginkan</p>
                        </div>

                        <form method="GET" action="{{ route('students.index') }}" class="filter-form">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label>Pencarian</label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-search"></i>
                                            <input type="text" name="search" placeholder="Nama, NIM, atau email..."
                                                value="{{ request('search') }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label>Angkatan</label>
                                        <select name="batch" class="form-control">
                                            <option value="">Semua</option>
                                            @foreach ($batches as $batch)
                                                <option value="{{ $batch }}"
                                                    {{ request('batch') == $batch ? 'selected' : '' }}>
                                                    {{ $batch }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label>Keahlian</label>
                                        <select name="skill" class="form-control">
                                            <option value="">Semua</option>
                                            @foreach ($skills as $skill)
                                                <option value="{{ $skill }}"
                                                    {{ request('skill') == $skill ? 'selected' : '' }}>
                                                    {{ $skill }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label>Urutkan</label>
                                        <select name="sort" class="form-control">
                                            <option value="full_name"
                                                {{ request('sort') == 'full_name' ? 'selected' : '' }}>Nama</option>
                                            <option value="nim" {{ request('sort') == 'nim' ? 'selected' : '' }}>NIM
                                            </option>
                                            <option value="batch" {{ request('sort') == 'batch' ? 'selected' : '' }}>
                                                Angkatan</option>
                                            <option value="created_at"
                                                {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-6">
                                    <div class="form-group">
                                        <label>Urutan</label>
                                        <select name="order" class="form-control">
                                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z
                                            </option>
                                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label style="opacity: 0;">Action</label>
                                        <div class="filter-actions">
                                            <button type="submit" class="btn-filter">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            @if (request()->hasAny(['search', 'batch', 'skill', 'sort', 'order']))
                                                <a href="{{ route('students.index') }}" class="btn-reset">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Filter Section End -->

    <!-- Students Section Begin -->
    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;"
        class="services-page spad">
        <div class="container">
            <!-- Results Header with View Toggle -->
            <div class="results-header">
                <div class="results-info">
                    <h3>{{ $students->count() }} dari {{ $students->total() }} mahasiswa</h3>
                    @if (request('search'))
                        <p>untuk pencarian "<span class="search-term">{{ request('search') }}</span>"</p>
                    @endif
                </div>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid" title="Grid View">
                        <i class="fa fa-th"></i>
                    </button>
                    <button class="view-btn" data-view="list" title="List View">
                        <i class="fa fa-list"></i>
                    </button>
                    <button class="view-btn" data-view="horizontal" title="Horizontal Cards">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>

            @if ($students->count() > 0)
                <!-- Grid View -->
                <div class="students-grid view-mode active" id="gridView">
                    <div class="row">
                        @foreach ($students as $student)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="student-card-grid">
                                    <div class="student-photo-wrapper">
                                        <img src="{{ $student->work_photo_url }}" alt="{{ $student->full_name }}">
                                        <div class="photo-overlay">
                                            <span>Lihat Profil</span>
                                        </div>
                                    </div>
                                    <div class="student-content">
                                        <h4>{{ $student->full_name }}</h4>
                                        <div class="student-meta">
                                            <span class="nim-badge">{{ $student->nim }}</span>
                                            <span class="batch-info">Angkatan {{ $student->batch }}</span>
                                        </div>

                                        @if ($student->bio)
                                            <p class="bio">{{ Str::limit($student->bio, 80) }}</p>
                                        @endif

                                        @if ($student->life_motto)
                                            <div class="motto">
                                                <i class="fa fa-quote-left"></i>
                                                {{ Str::limit($student->life_motto, 60) }}
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        @endif

                                        @if ($student->skills && count($student->skills) > 0)
                                            <div class="skills">
                                                @foreach (array_slice($student->skills, 0, 3) as $skill)
                                                    <span class="skill-tag">{{ $skill }}</span>
                                                @endforeach
                                                @if (count($student->skills) > 3)
                                                    <span class="skill-tag more">+{{ count($student->skills) - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        <a href="{{ route('students.show', $student) }}" class="view-profile-btn">
                                            Lihat Profil <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- List View -->
                <div class="students-list view-mode" id="listView">
                    @foreach ($students as $student)
                        <div class="student-card-list">
                            <div class="student-photo-small">
                                <img src="{{ $student->work_photo_url }}" alt="{{ $student->full_name }}">
                            </div>
                            <div class="student-info-list">
                                <div class="student-header">
                                    <h4>{{ $student->full_name }}</h4>
                                    <div class="student-badges">
                                        <span class="nim-badge">{{ $student->nim }}</span>
                                        <span class="batch-badge">{{ $student->batch }}</span>
                                    </div>
                                </div>

                                @if ($student->bio)
                                    <p class="bio">{{ Str::limit($student->bio, 120) }}</p>
                                @endif

                                @if ($student->skills && count($student->skills) > 0)
                                    <div class="skills-list">
                                        @foreach (array_slice($student->skills, 0, 5) as $skill)
                                            <span class="skill-tag">{{ $skill }}</span>
                                        @endforeach
                                        @if (count($student->skills) > 5)
                                            <span class="skill-tag more">+{{ count($student->skills) - 5 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="student-actions">
                                <a href="{{ route('students.show', $student) }}" class="btn-view-profile">
                                    <i class="fa fa-eye"></i>
                                    Lihat Profil
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Horizontal Cards View -->
                <div class="students-horizontal view-mode" id="horizontalView">
                    @foreach ($students as $student)
                        <div class="student-card-horizontal">
                            <div class="student-photo-horizontal">
                                <img src="{{ $student->work_photo_url }}" alt="{{ $student->full_name }}">
                            </div>
                            <div class="student-content-horizontal">
                                <div class="student-basic-info">
                                    <h4>{{ $student->full_name }}</h4>
                                    <div class="meta-info">
                                        <span class="nim">{{ $student->nim }}</span>
                                        <span class="batch">Angkatan {{ $student->batch }}</span>
                                        @if ($student->current_job)
                                            <span class="job">{{ $student->current_job }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="student-details">
                                    @if ($student->bio)
                                        <p class="bio">{{ Str::limit($student->bio, 150) }}</p>
                                    @endif

                                    @if ($student->life_motto)
                                        <div class="motto">
                                            <i class="fa fa-quote-left"></i>
                                            {{ Str::limit($student->life_motto, 80) }}
                                            <i class="fa fa-quote-right"></i>
                                        </div>
                                    @endif

                                    @if ($student->skills && count($student->skills) > 0)
                                        <div class="skills-horizontal">
                                            @foreach (array_slice($student->skills, 0, 6) as $skill)
                                                <span class="skill-tag">{{ $skill }}</span>
                                            @endforeach
                                            @if (count($student->skills) > 6)
                                                <span class="skill-tag more">+{{ count($student->skills) - 6 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="student-actions-horizontal">
                                <a href="{{ route('students.show', $student) }}" class="btn-profile-horizontal">
                                    <i class="fa fa-user"></i>
                                    <span>Lihat Profil</span>
                                </a>
                                @if ($student->linkedin)
                                    <a href="{{ $student->linkedin }}" target="_blank" class="btn-social">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                @endif
                                @if ($student->github)
                                    <a href="{{ $student->github }}" target="_blank" class="btn-social">
                                        <i class="fab fa-github"></i>
                                    </a>
                                @endif
                                @if ($student->portfolio_url)
                                    <a href="{{ $student->portfolio_url }}" target="_blank" class="btn-social">
                                        <i class="fa fa-globe"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-results">
                    <i class="fa fa-search"></i>
                    <h4>Tidak ada mahasiswa ditemukan</h4>
                    <p>Coba ubah filter pencarian atau kata kunci Anda</p>
                    <a href="{{ route('students.index') }}" class="btn-primary">Lihat Semua Mahasiswa</a>
                </div>
            @endif
        </div>
    </section>
    <!-- Students Section End -->

    <!-- Statistics Section Begin -->
    <section class="statistics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2>Statistik Mahasiswa</h2>
                    <p>Data terkini mengenai mahasiswa Teknik Komputer UNAND</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $students->total() }}</h3>
                            <p class="stat-label">Total Mahasiswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <a href="{{ route('students.create') }}" class="cta-link">
                        <div class="stat-card cta-card">
                            <div class="stat-icon">
                                <i class="fa fa-plus-circle"></i>
                            </div>
                            <div class="stat-content">
                                <p>Daftar Sekarang</p>
                                <p style="font-size: 12px">Tambahkan data dirimu disini untuk dapat masuk ke database
                                    Himpunan tercinta kita ini.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ count($batches) }}</h3>
                            <p class="stat-label">Angkatan</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Statistics Section End -->

@endsection

<style>
    /* Enhanced Styles */
    .filter-wrapper {
        background: linear-gradient(135deg, rgba(0, 103, 56, 0.1), rgba(0, 103, 56, 0.05));
        border: 1px solid rgba(0, 103, 56, 0.2);
        border-radius: 20px;
        padding: 30px;
        backdrop-filter: blur(15px);
        margin-bottom: 50px;
    }

    .filter-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .filter-header h3 {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 10px;
        font-family: "Play", sans-serif;
    }

    .filter-header p {
        color: #adadad;
        margin: 0;
    }

    .filter-form .form-group {
        margin-bottom: 20px;
    }

    .filter-form label {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #006738;
        z-index: 2;
    }

    .input-with-icon input {
        padding-left: 45px;
    }

    .filter-form .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: #ffffff;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .filter-form .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #006738;
        color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(0, 103, 56, 0.25);
    }

    .filter-form .form-control::placeholder {
        color: #adadad;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-filter {
        background: #006738;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        background: #00a651;
        transform: translateY(-2px);
    }

    .btn-reset {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-reset:hover {
        background: #c0392b;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Results Header */
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: rgba(255, 255, 255, 0.05);
        padding: 20px 25px;
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }

    .results-info h3 {
        color: #ffffff;
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
    }

    .results-info p {
        color: #adadad;
        margin: 5px 0 0 0;
    }

    .search-term {
        color: #006738;
        font-weight: 600;
    }

    .view-toggle {
        display: flex;
        gap: 5px;
        background: rgba(255, 255, 255, 0.1);
        padding: 5px;
        border-radius: 12px;
    }

    .view-btn {
        background: transparent;
        border: none;
        color: #adadad;
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 16px;
    }

    .view-btn.active,
    .view-btn:hover {
        background: #006738;
        color: white;
    }

    /* View Modes */
    .view-mode {
        display: none;
    }

    .view-mode.active {
        display: block;
    }

    /* Grid View Styles */
    .students-grid .row {
        margin: 0 -10px;
    }

    .students-grid [class*="col-"] {
        padding: 0 10px;
        margin-bottom: 25px;
    }

    .student-card-grid {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(10px);
    }

    .student-card-grid:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 103, 56, 0.3);
        border-color: rgba(0, 103, 56, 0.5);
    }

    .student-photo-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .student-photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .student-card-grid:hover .student-photo-wrapper img {
        transform: scale(1.1);
    }

    .photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 103, 56, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .student-card-grid:hover .photo-overlay {
        opacity: 1;
    }

    .photo-overlay span {
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .student-content {
        padding: 25px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .student-content h4 {
        color: #ffffff;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
        font-family: "Play", sans-serif;
    }

    .student-meta {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .nim-badge {
        background: #006738;
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .batch-info {
        color: #adadad;
        font-size: 13px;
    }

    .bio {
        color: #ffffff;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .motto {
        background: rgba(0, 103, 56, 0.1);
        padding: 12px;
        border-left: 3px solid #006738;
        border-radius: 5px;
        font-style: italic;
        font-size: 13px;
        margin-bottom: 15px;
        color: #ffffff;
    }

    .skills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 20px;
    }

    .skill-tag {
        background: rgba(0, 103, 56, 0.2);
        color: #22c55e;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .skill-tag.more {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
    }

    .view-profile-btn {
        background: #006738;
        color: white;
        padding: 12px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .view-profile-btn:hover {
        background: #00a651;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* List View Styles */
    .student-card-list {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .student-card-list:hover {
        transform: translateX(10px);
        border-color: rgba(0, 103, 56, 0.5);
        box-shadow: 0 10px 30px rgba(0, 103, 56, 0.2);
    }

    .student-photo-small {
        flex-shrink: 0;
    }

    .student-photo-small img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(0, 103, 56, 0.3);
    }

    .student-info-list {
        flex: 1;
    }

    .student-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .student-header h4 {
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
    }

    .student-badges {
        display: flex;
        gap: 8px;
    }

    .batch-badge {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .skills-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 10px;
    }

    .student-actions {
        flex-shrink: 0;
    }

    .btn-view-profile {
        background: #006738;
        color: white;
        padding: 10px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-view-profile:hover {
        background: #00a651;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Horizontal Cards View Styles */
    .student-card-horizontal {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 25px;
        transition: all 0.4s ease;
        backdrop-filter: blur(15px);
        min-height: 200px;
    }

    .student-card-horizontal:hover {
        transform: translateY(-5px);
        border-color: rgba(0, 103, 56, 0.5);
        box-shadow: 0 15px 35px rgba(0, 103, 56, 0.3);
    }

    .student-photo-horizontal {
        flex-shrink: 0;
    }

    .student-photo-horizontal img {
        width: 120px;
        height: 150px;
        border-radius: 15px;
        object-fit: cover;
        border: 3px solid rgba(0, 103, 56, 0.3);
        transition: transform 0.3s ease;
    }

    .student-card-horizontal:hover .student-photo-horizontal img {
        transform: scale(1.05);
    }

    .student-content-horizontal {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .student-basic-info h4 {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 8px;
        font-family: "Play", sans-serif;
    }

    .meta-info {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .meta-info .nim {
        background: #006738;
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .meta-info .batch {
        color: #22c55e;
        font-weight: 500;
        font-size: 14px;
    }

    .meta-info .job {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }

    .student-details .bio {
        color: #ffffff;
        line-height: 1.6;
        font-size: 15px;
        margin-bottom: 12px;
    }

    .student-details .motto {
        background: rgba(0, 103, 56, 0.1);
        padding: 15px;
        border-left: 4px solid #006738;
        border-radius: 8px;
        font-style: italic;
        color: #ffffff;
        margin-bottom: 15px;
    }

    .skills-horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .student-actions-horizontal {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    .btn-profile-horizontal {
        background: linear-gradient(45deg, #006738, #00a651);
        color: white;
        padding: 15px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        min-width: 120px;
        text-align: center;
    }

    .btn-profile-horizontal:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 103, 56, 0.4);
    }

    .btn-social {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .btn-social:hover {
        background: #006738;
        color: white;
        text-decoration: none;
        transform: scale(1.1);
    }

    /* Statistics Section */
    .statistics-section {
        background: linear-gradient(135deg, #0B1215 0%, #1a1a2e 100%);
        padding: 80px 0;
        position: relative;
    }

    .statistics-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #006738, transparent);
    }

    .statistics-section h2 {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        font-family: "Play", sans-serif;
        margin-bottom: 15px;
    }

    .statistics-section p {
        color: #adadad;
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(0, 103, 56, 0.3);
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.4s ease;
        backdrop-filter: blur(15px);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        border-color: #006738;
        box-shadow: 0 20px 40px rgba(0, 103, 56, 0.3);
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(45deg, #006738, #00a651);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    .stat-icon i {
        font-size: 2rem;
        color: white;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 10px;
        font-family: "Play", sans-serif;
    }

    .stat-label {
        color: #adadad;
        font-size: 1.1rem;
        font-weight: 500;
        margin: 0;
    }

    .cta-card {
        background: linear-gradient(135deg, rgba(0, 103, 56, 0.2), rgba(0, 103, 56, 0.1));
        border-color: #006738;
    }

    .cta-link {
        color: inherit;
        text-decoration: none;
        display: block;
    }

    .cta-link:hover {
        color: inherit;
        text-decoration: none;
    }

    .cta-card:hover {
        background: linear-gradient(135deg, rgba(0, 103, 56, 0.3), rgba(0, 103, 56, 0.2));
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 50px;
        text-align: center;
    }

    .pagination-wrapper .pagination {
        display: inline-flex;
        gap: 5px;
    }

    .pagination .page-link {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover,
    .pagination .page-item.active .page-link {
        background: #006738;
        border-color: #006738;
        color: white;
        transform: translateY(-2px);
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 80px 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        backdrop-filter: blur(15px);
    }

    .no-results i {
        font-size: 4rem;
        color: #006738;
        margin-bottom: 25px;
    }

    .no-results h4 {
        color: #ffffff;
        font-size: 1.8rem;
        margin-bottom: 15px;
        font-family: "Play", sans-serif;
    }

    .no-results p {
        color: #adadad;
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    .no-results .btn-primary {
        background: #006738;
        color: white;
        padding: 15px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .no-results .btn-primary:hover {
        background: #00a651;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .filter-form .row {
            margin: 0 -5px;
        }

        .filter-form [class*="col-"] {
            padding: 0 5px;
            margin-bottom: 15px;
        }

        .results-header {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .student-card-horizontal {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .student-photo-horizontal img {
            width: 100px;
            height: 125px;
        }

        .student-actions-horizontal {
            flex-direction: row;
            justify-content: center;
        }

        .meta-info {
            justify-content: center;
        }

        .statistics-section {
            padding: 60px 0;
        }

        .stat-card {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 480px) {
        .students-grid [class*="col-"] {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .filter-header h3 {
            font-size: 1.5rem;
        }

        .student-content h4 {
            font-size: 1.1rem;
        }

        .stat-number {
            font-size: 2.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View Toggle Functionality
        const viewButtons = document.querySelectorAll('.view-btn');
        const viewModes = document.querySelectorAll('.view-mode');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetView = this.dataset.view;

                // Remove active class from all buttons and views
                viewButtons.forEach(btn => btn.classList.remove('active'));
                viewModes.forEach(mode => mode.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Show target view
                const targetElement = document.getElementById(targetView + 'View');
                if (targetElement) {
                    targetElement.classList.add('active');
                }

                // Store preference in localStorage
                localStorage.setItem('studentViewMode', targetView);
            });
        });

        // Restore saved view mode
        const savedView = localStorage.getItem('studentViewMode');
        if (savedView) {
            const savedButton = document.querySelector(`[data-view="${savedView}"]`);
            if (savedButton) {
                savedButton.click();
            }
        }

        // Smooth animations for cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                }
            });
        }, observerOptions);

        // Observe all student cards
        document.querySelectorAll('.student-card-grid, .student-card-list, .student-card-horizontal').forEach(
            card => {
                observer.observe(card);
            });

        // Add CSS animation keyframes
        const style = document.createElement('style');
        style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .student-card-grid,
        .student-card-list,
        .student-card-horizontal {
            opacity: 0;
        }
    `;
        document.head.appendChild(style);

        console.log('✅ Enhanced students index loaded successfully');
    });
</script>
