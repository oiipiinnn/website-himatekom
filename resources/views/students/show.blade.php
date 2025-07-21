@extends('layouts.main')

@section('content')
    <!-- Hero Profile Section -->
    <div class="profile-hero" style="background-image: url({{ asset('img/breadcrump-bg.jpg') }});">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="profile-hero-content">
                        <div class="back-navigation">
                            <a href="{{ route('students.index') }}" class="back-btn">
                                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Mahasiswa
                            </a>
                        </div>
                        <h1 class="profile-name">{{ $student->full_name }}</h1>
                        <div class="profile-meta">
                            <span class="nim-badge">{{ $student->nim }}</span>
                            <span class="batch-badge">Angkatan {{ $student->batch }}</span>
                            @if ($student->current_job)
                                <span class="job-badge">{{ $student->current_job }}</span>
                            @endif
                        </div>
                        @if ($student->life_motto)
                            <div class="profile-motto">
                                <i class="fa fa-quote-left"></i>
                                {{ $student->life_motto }}
                                <i class="fa fa-quote-right"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="profile-photos">
                        <div class="main-photo">
                            <img src="{{ $student->work_photo_url }}" alt="{{ $student->full_name }}">
                        </div>
                        @if ($student->work_photo_url)
                            <div class="work-photo">
                                <img src="{{ $student->casual_photo_url }}" alt="Foto Kerja {{ $student->full_name }}">
                                <span class="photo-label">{{ $student->full_name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="profile-content">
        <div class="container">
            <div class="row">
                <!-- Left Column - Main Info -->
                <div class="col-lg-8">
                    <!-- Bio Section -->
                    @if ($student->bio)
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fa fa-user"></i> Tentang Saya</h3>
                            </div>
                            <div class="card-body">
                                <p class="bio-text">{{ $student->bio }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Skills & Hobbies -->
                    <div class="row">
                        @if ($student->skills && count($student->skills) > 0)
                            <div class="col-md-6">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h3><i class="fa fa-code"></i> Keahlian</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="skills-grid">
                                            @foreach ($student->skills as $skill)
                                                <span class="skill-badge">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($student->hobbies && count($student->hobbies) > 0)
                            <div class="col-md-6">
                                <div class="content-card">
                                    <div class="card-header">
                                        <h3><i class="fa fa-heart"></i> Hobi</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="hobbies-grid">
                                            @foreach ($student->hobbies as $hobby)
                                                <span class="hobby-badge">{{ $hobby }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Career Goal -->
                    @if ($student->career_goal)
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fa fa-target"></i> Tujuan Karir</h3>
                            </div>
                            <div class="card-body">
                                <div class="career-goal">
                                    <p>{{ $student->career_goal }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Social Media Links -->
                    @if ($student->instagram || $student->linkedin || $student->tiktok || $student->github || $student->portfolio_url)
                        <div class="content-card">
                            <div class="card-header">
                                <h3><i class="fa fa-share-alt"></i> Koneksi</h3>
                            </div>
                            <div class="card-body">
                                <div class="social-links-grid">
                                    @if ($student->instagram)
                                        <a href="{{ $student->instagram }}" target="_blank" class="social-link instagram">
                                            <i class="fab fa-instagram"></i>
                                            <span>Instagram</span>
                                        </a>
                                    @endif
                                    @if ($student->linkedin)
                                        <a href="{{ $student->linkedin }}" target="_blank" class="social-link linkedin">
                                            <i class="fab fa-linkedin"></i>
                                            <span>LinkedIn</span>
                                        </a>
                                    @endif
                                    @if ($student->github)
                                        <a href="{{ $student->github }}" target="_blank" class="social-link github">
                                            <i class="fab fa-github"></i>
                                            <span>GitHub</span>
                                        </a>
                                    @endif
                                    @if ($student->portfolio_url)
                                        <a href="{{ $student->portfolio_url }}" target="_blank"
                                            class="social-link portfolio">
                                            <i class="fa fa-globe"></i>
                                            <span>Portfolio</span>
                                        </a>
                                    @endif
                                    @if ($student->tiktok)
                                        <a href="{{ $student->tiktok }}" target="_blank" class="social-link tiktok">
                                            <i class="fab fa-tiktok"></i>
                                            <span>TikTok</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="col-lg-4">
                    <!-- Contact Info -->
                    <div class="sidebar-card">
                        <div class="card-header">
                            <h3><i class="fa fa-address-card"></i> Informasi Kontak</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-list">
                                <div class="info-item">
                                    <i class="fa fa-envelope"></i>
                                    <div class="info-content">
                                        <span class="info-label">Email</span>
                                        <span class="info-value">{{ $student->email }}</span>
                                    </div>
                                </div>
                                @if ($student->phone)
                                    <div class="info-item">
                                        <i class="fa fa-phone"></i>
                                        <div class="info-content">
                                            <span class="info-label">Telepon</span>
                                            <span class="info-value">{{ $student->phone }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if ($student->hometown)
                                    <div class="info-item">
                                        <i class="fa fa-map-marker-alt"></i>
                                        <div class="info-content">
                                            <span class="info-label">Asal Daerah</span>
                                            <span class="info-value">{{ $student->hometown }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if ($student->birth_date)
                                    <div class="info-item">
                                        <i class="fa fa-birthday-cake"></i>
                                        <div class="info-content">
                                            <span class="info-label">Tanggal Lahir</span>
                                            <span class="info-value">{{ $student->birth_date->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                @endif
                                @if ($student->gender)
                                    <div class="info-item">
                                        <i class="fa fa-user"></i>
                                        <div class="info-content">
                                            <span class="info-label">Jenis Kelamin</span>
                                            <span class="info-value">{{ $student->gender_label }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Academic Info -->
                    <div class="sidebar-card">
                        <div class="card-header">
                            <h3><i class="fa fa-graduation-cap"></i> Akademik</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-list">
                                <div class="info-item">
                                    <i class="fa fa-id-card"></i>
                                    <div class="info-content">
                                        <span class="info-label">NIM</span>
                                        <span class="info-value">{{ $student->nim }}</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fa fa-calendar"></i>
                                    <div class="info-content">
                                        <span class="info-label">Angkatan</span>
                                        <span class="info-value">{{ $student->batch }}</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fa fa-book"></i>
                                    <div class="info-content">
                                        <span class="info-label">Program Studi</span>
                                        <span class="info-value">Teknik Komputer</span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fa fa-university"></i>
                                    <div class="info-content">
                                        <span class="info-label">Fakultas</span>
                                        <span class="info-value">FTI UNAND</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="sidebar-card">
                        <div class="card-header">
                            <h3><i class="fa fa-rocket"></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                @if ($student->email)
                                    <a href="mailto:{{ $student->email }}" class="action-btn email">
                                        <i class="fa fa-envelope"></i>
                                        <span>Kirim Email</span>
                                    </a>
                                @endif
                                @if ($student->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone) }}"
                                        target="_blank" class="action-btn whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                        <span>WhatsApp</span>
                                    </a>
                                @endif
                                <a href="{{ route('students.index') }}" class="action-btn explore">
                                    <i class="fa fa-users"></i>
                                    <span>Jelajahi Lainnya</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Students Section -->
    <section class="similar-students">
        <div class="container">
            <div class="section-header">
                <h2>Mahasiswa Lainnya dari Angkatan {{ $student->batch }}</h2>
                <p>Kenali teman-teman seangkatan</p>
            </div>

            <div class="row">
                @php
                    $similarStudents = \App\Models\Student::approved()
                        ->active()
                        ->public()
                        ->where('batch', $student->batch)
                        ->where('id', '!=', $student->id)
                        ->limit(3)
                        ->get();
                @endphp

                @forelse($similarStudents as $similar)
                    <div class="col-lg-4 col-md-6">
                        <div class="similar-card">
                            <div class="similar-photo">
                                <img src="{{ $similar->casual_photo_url }}" alt="{{ $similar->full_name }}">
                            </div>
                            <div class="similar-content">
                                <h4>{{ $similar->full_name }}</h4>
                                <p class="similar-nim">{{ $similar->nim }}</p>
                                @if ($similar->current_job)
                                    <p class="similar-job">{{ $similar->current_job }}</p>
                                @endif
                                <a href="{{ route('students.show', $similar) }}" class="similar-btn">
                                    Lihat Profil <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <div class="no-similar">
                            <i class="fa fa-users"></i>
                            <p>Tidak ada mahasiswa lain dari angkatan ini yang terdaftar.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection

<style>
    /* Profile Hero Section */
    .profile-hero {
        min-height: 600px;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: center;
        padding: 120px 0 80px;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(0, 103, 56, 0.6));
    }

    .profile-hero .container {
        position: relative;
        z-index: 2;
    }

    .back-navigation {
        margin-bottom: 30px;
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        backdrop-filter: blur(10px);
    }

    .back-btn:hover {
        background: rgba(0, 103, 56, 0.8);
        border-color: #006738;
        color: #ffffff;
        text-decoration: none;
        transform: translateX(-5px);
    }

    .profile-name {
        font-size: 3.5rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 20px;
        font-family: "Play", sans-serif;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        line-height: 1.2;
    }

    .profile-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        align-items: center;
    }

    .nim-badge {
        background: linear-gradient(45deg, #006738, #00a651);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0, 103, 56, 0.3);
    }

    .batch-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .job-badge {
        background: rgba(52, 152, 219, 0.8);
        color: white;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 600;
    }

    .profile-motto {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px 25px;
        border-left: 4px solid #006738;
        border-radius: 10px;
        font-style: italic;
        color: #ffffff;
        font-size: 1.2rem;
        line-height: 1.6;
        backdrop-filter: blur(10px);
        margin-top: 20px;
    }

    .profile-photos {
        display: flex;
        gap: 20px;
        justify-content: center;
        align-items: flex-start;
    }

    .main-photo {
        position: relative;
    }

    .main-photo img {
        width: 200px;
        height: 250px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
    }

    .main-photo:hover img {
        transform: scale(1.05);
    }

    .work-photo {
        position: relative;
        text-align: center;
    }

    .work-photo img {
        width: 120px;
        height: 150px;
        border-radius: 15px;
        object-fit: cover;
        border: 3px solid rgba(0, 103, 56, 0.5);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .photo-label {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #006738;
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Main Content */
    .profile-content {
        background: linear-gradient(135deg, #0B1215 0%, #1a1a2e 100%);
        padding: 80px 0;
        min-height: 100vh;
    }

    .content-card,
    .sidebar-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        margin-bottom: 30px;
        backdrop-filter: blur(15px);
        transition: all 0.3s ease;
    }

    .content-card:hover,
    .sidebar-card:hover {
        transform: translateY(-5px);
        border-color: rgba(0, 103, 56, 0.3);
        box-shadow: 0 15px 35px rgba(0, 103, 56, 0.2);
    }

    .card-header {
        padding: 25px 30px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 25px;
    }

    .card-header h3 {
        color: #ffffff;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 20px;
        font-family: "Play", sans-serif;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-header i {
        color: #006738;
        font-size: 1.2rem;
    }

    .card-body {
        padding: 0 30px 30px;
    }

    .bio-text {
        color: #ffffff;
        font-size: 1.1rem;
        line-height: 1.8;
        margin: 0;
        text-align: justify;
    }

    /* Skills & Hobbies */
    .skills-grid,
    .hobbies-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .skill-badge {
        background: linear-gradient(45deg, #006738, #00a651);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .skill-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 103, 56, 0.4);
    }

    .hobby-badge {
        background: linear-gradient(45deg, #e74c3c, #ec7063);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .hobby-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
    }

    .career-goal p {
        color: #ffffff;
        font-size: 1.1rem;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        background: rgba(0, 103, 56, 0.1);
        border-radius: 15px;
        border-left: 4px solid #006738;
    }

    /* Social Links */
    .social-links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .social-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-3px);
    }

    .social-link.instagram:hover {
        background: linear-gradient(45deg, #e1306c, #fd1d1d);
        border-color: #e1306c;
    }

    .social-link.linkedin:hover {
        background: #0077b5;
        border-color: #0077b5;
    }

    .social-link.github:hover {
        background: #333;
        border-color: #333;
    }

    .social-link.portfolio:hover {
        background: #006738;
        border-color: #006738;
    }

    .social-link.tiktok:hover {
        background: #000;
        border-color: #000;
    }

    .social-link i {
        font-size: 1.5rem;
        width: 24px;
    }

    .social-link span {
        font-weight: 600;
    }

    /* Sidebar */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item i {
        color: #006738;
        font-size: 1.2rem;
        width: 20px;
        margin-top: 2px;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        display: block;
        color: #adadad;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        display: block;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
    }

    /* Quick Actions */
    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .action-btn.email {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
        border-color: rgba(52, 152, 219, 0.3);
    }

    .action-btn.email:hover {
        background: #3498db;
        color: white;
        text-decoration: none;
    }

    .action-btn.whatsapp {
        background: rgba(37, 211, 102, 0.2);
        color: #25d366;
        border-color: rgba(37, 211, 102, 0.3);
    }

    .action-btn.whatsapp:hover {
        background: #25d366;
        color: white;
        text-decoration: none;
    }

    .action-btn.explore {
        background: rgba(0, 103, 56, 0.2);
        color: #006738;
        border-color: rgba(0, 103, 56, 0.3);
    }

    .action-btn.explore:hover {
        background: #006738;
        color: white;
        text-decoration: none;
    }

    /* Similar Students */
    .similar-students {
        background: #000;
        padding: 80px 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-header h2 {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        font-family: "Play", sans-serif;
    }

    .section-header p {
        color: #adadad;
        font-size: 1.1rem;
        margin: 0;
    }

    .similar-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        transition: all 0.4s ease;
        backdrop-filter: blur(15px);
        margin-bottom: 30px;
    }

    .similar-card:hover {
        transform: translateY(-10px);
        border-color: rgba(0, 103, 56, 0.5);
        box-shadow: 0 20px 40px rgba(0, 103, 56, 0.3);
    }

    .similar-photo {
        margin-bottom: 20px;
    }

    .similar-photo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(0, 103, 56, 0.3);
        transition: transform 0.3s ease;
    }

    .similar-card:hover .similar-photo img {
        transform: scale(1.1);
    }

    .similar-content h4 {
        color: #ffffff;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 8px;
        font-family: "Play", sans-serif;
    }

    .similar-nim {
        color: #006738;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .similar-job {
        color: #adadad;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .similar-btn {
        background: #006738;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .similar-btn:hover {
        background: #00a651;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .no-similar {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
    }

    .no-similar i {
        font-size: 3rem;
        color: #006738;
        margin-bottom: 20px;
    }

    .no-similar p {
        color: #adadad;
        font-size: 1.1rem;
        margin: 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .profile-hero {
            min-height: 500px;
            padding: 100px 0 60px;
        }

        .profile-hero .row {
            flex-direction: column-reverse;
            text-align: center;
        }

        .profile-photos {
            margin-bottom: 30px;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .main-photo img {
            width: 150px;
            height: 180px;
        }

        .work-photo img {
            width: 100px;
            height: 120px;
        }

        .profile-name {
            font-size: 2.5rem;
        }

        .profile-meta {
            justify-content: center;
        }

        .card-header,
        .card-body {
            padding-left: 20px;
            padding-right: 20px;
        }

        .social-links-grid {
            grid-template-columns: 1fr;
        }

        .skills-grid,
        .hobbies-grid {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .profile-name {
            font-size: 2rem;
        }

        .nim-badge,
        .batch-badge,
        .job-badge {
            font-size: 14px;
            padding: 6px 15px;
        }

        .similar-students {
            padding: 60px 0;
        }

        .section-header h2 {
            font-size: 2rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth animations
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

        // Observe cards
        document.querySelectorAll('.content-card, .sidebar-card, .similar-card').forEach(card => {
            observer.observe(card);
        });

        // Add CSS animation
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

        .content-card,
        .sidebar-card,
        .similar-card {
            opacity: 0;
        }
    `;
        document.head.appendChild(style);

        console.log('✅ Enhanced student profile loaded');
    });
</script>
