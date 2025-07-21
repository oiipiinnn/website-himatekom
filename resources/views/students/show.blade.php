@extends('layouts.main')

@section('content')
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $student->full_name }}</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <a href="{{ route('students.index') }}">Data Mahasiswa</a>
                            <span>{{ $student->full_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Student Profile Section Begin -->
    <section class="about spad">
        <div class="container">
            <!-- Back Button -->
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('students.index') }}" class="back-btn">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Mahasiswa
                    </a>
                </div>
            </div>

            <!-- Profile Header -->
            <div class="row profile-header">
                <div class="col-lg-4 col-md-4 text-center">
                    <div class="student-photo-container">
                        <img src="{{ $student->casual_photo_url }}" alt="{{ $student->full_name }}" class="profile-photo">

                        @if ($student->work_photo_url)
                            <div class="work-photo-section">
                                <h6>Foto Baju Kerja Himatekom</h6>
                                <img src="{{ $student->work_photo_url }}" alt="Foto Kerja {{ $student->full_name }}"
                                    class="work-photo">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="student-info">
                        <h1 class="student-name">{{ $student->full_name }}</h1>
                        <span class="student-nim">{{ $student->nim }}</span>
                        <div class="batch-info">Angkatan {{ $student->batch }}</div>

                        @if ($student->bio)
                            <p class="student-bio">{{ $student->bio }}</p>
                        @endif

                        @if ($student->life_motto)
                            <div class="motto-section">
                                <i class="fa fa-quote-left"></i>
                                {{ $student->life_motto }}
                                <i class="fa fa-quote-right"></i>
                            </div>
                        @endif

                        <div class="student-details">
                            @if ($student->current_job)
                                <div class="detail-item">
                                    <i class="fa fa-briefcase"></i>
                                    <span>{{ $student->current_job }}</span>
                                </div>
                            @endif

                            @if ($student->hometown)
                                <div class="detail-item">
                                    <i class="fa fa-map-marker-alt"></i>
                                    <span>{{ $student->hometown }}</span>
                                </div>
                            @endif

                            @if ($student->age)
                                <div class="detail-item">
                                    <i class="fa fa-birthday-cake"></i>
                                    <span>{{ $student->age }} tahun</span>
                                </div>
                            @endif
                        </div>

                        <!-- Social Links -->
                        @if ($student->instagram || $student->linkedin || $student->tiktok || $student->github || $student->portfolio_url)
                            <div class="social-links">
                                @if ($student->instagram)
                                    <a href="{{ $student->instagram }}" target="_blank" class="social-link">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if ($student->linkedin)
                                    <a href="{{ $student->linkedin }}" target="_blank" class="social-link">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                @endif
                                @if ($student->tiktok)
                                    <a href="{{ $student->tiktok }}" target="_blank" class="social-link">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                @endif
                                @if ($student->github)
                                    <a href="{{ $student->github }}" target="_blank" class="social-link">
                                        <i class="fab fa-github"></i>
                                    </a>
                                @endif
                                @if ($student->portfolio_url)
                                    <a href="{{ $student->portfolio_url }}" target="_blank" class="social-link">
                                        <i class="fa fa-globe"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Student Profile Section End -->

    <!-- Student Details Section Begin -->
    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;"
        class="services-page spad">
        <div class="container">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Skills Section -->
                    @if ($student->skills && count($student->skills) > 0)
                        <div class="info-card">
                            <h5><i class="fa fa-code"></i> Keahlian</h5>
                            <div class="tags-container">
                                @foreach ($student->skills as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Hobbies Section -->
                    @if ($student->hobbies && count($student->hobbies) > 0)
                        <div class="info-card">
                            <h5><i class="fa fa-heart"></i> Hobi</h5>
                            <div class="tags-container">
                                @foreach ($student->hobbies as $hobby)
                                    <span class="hobby-tag">{{ $hobby }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Career Goal Section -->
                    @if ($student->career_goal)
                        <div class="info-card">
                            <h5><i class="fa fa-target"></i> Tujuan Karir</h5>
                            <p>{{ $student->career_goal }}</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Contact Information -->
                    <div class="info-card">
                        <h5><i class="fa fa-address-card"></i> Informasi Kontak</h5>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fa fa-envelope"></i>
                                <span>{{ $student->email }}</span>
                            </div>
                            @if ($student->phone)
                                <div class="contact-item">
                                    <i class="fa fa-phone"></i>
                                    <span>{{ $student->phone }}</span>
                                </div>
                            @endif
                            <div class="contact-item">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Angkatan {{ $student->batch }}</span>
                            </div>
                            @if ($student->gender)
                                <div class="contact-item">
                                    <i class="fa fa-user"></i>
                                    <span>{{ $student->gender_label }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Academic Info -->
                    <div class="info-card">
                        <h5><i class="fa fa-university"></i> Informasi Akademik</h5>
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fa fa-id-card"></i>
                                <span>{{ $student->nim }}</span>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-book"></i>
                                <span>Teknik Komputer</span>
                            </div>
                            <div class="contact-item">
                                <i class="fa fa-building"></i>
                                <span>FTI UNAND</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    @if ($student->hometown || $student->birth_date)
                        <div class="info-card">
                            <h5><i class="fa fa-info-circle"></i> Informasi Tambahan</h5>
                            <div class="contact-info">
                                @if ($student->hometown)
                                    <div class="contact-item">
                                        <i class="fa fa-map-marker-alt"></i>
                                        <span>{{ $student->hometown }}</span>
                                    </div>
                                @endif
                                @if ($student->birth_date)
                                    <div class="contact-item">
                                        <i class="fa fa-calendar"></i>
                                        <span>{{ $student->birth_date->format('d F Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Student Details Section End -->

    <!-- Similar Students Section Begin -->
    <section class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Mahasiswa Lainnya</span>
                        <h2>Dari Angkatan {{ $student->batch }}</h2>
                    </div>
                </div>
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
                        <div class="services__item similar-student">
                            <div class="similar-photo">
                                <img src="{{ $similar->casual_photo_url }}" alt="{{ $similar->full_name }}">
                            </div>
                            <h4>{{ $similar->full_name }}</h4>
                            <p>{{ $similar->nim }}</p>
                            <a href="{{ route('students.show', $similar) }}" class="read__more">
                                Lihat Profil <span class="arrow_right"></span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <div class="no-similar text-center">
                            <p>Tidak ada mahasiswa lain dari angkatan ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Similar Students Section End -->

@endsection

<style>
    .back-btn {
        background: transparent;
        border: 2px solid #f39c12;
        color: #f39c12;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 30px;
    }

    .back-btn:hover {
        background: #f39c12;
        color: #ffffff;
        text-decoration: none;
    }

    .profile-header {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 40px;
        margin-bottom: 0;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .student-photo-container {
        text-align: center;
    }

    .profile-photo {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f39c12;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        margin-bottom: 20px;
    }

    .work-photo-section {
        text-align: center;
        padding: 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        margin-top: 20px;
    }

    .work-photo-section h6 {
        color: #f39c12;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .work-photo {
        width: 150px;
        height: 200px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .student-info {
        color: white;
    }

    .student-name {
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 10px;
        font-family: "Play", sans-serif;
    }

    .student-nim {
        font-size: 1.2rem;
        color: #f39c12;
        font-weight: 600;
        background: rgba(243, 156, 18, 0.2);
        padding: 8px 20px;
        border-radius: 25px;
        display: inline-block;
        margin-bottom: 15px;
    }

    .batch-info {
        font-size: 1.1rem;
        color: #adadad;
        margin-bottom: 20px;
    }

    .student-bio {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 20px;
        color: #ffffff;
    }

    .motto-section {
        background: rgba(243, 156, 18, 0.1);
        padding: 15px;
        border-left: 4px solid #f39c12;
        border-radius: 5px;
        font-style: italic;
        margin-bottom: 20px;
        color: #ffffff;
    }

    .student-details {
        margin: 20px 0;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        color: #adadad;
    }

    .detail-item i {
        color: #f39c12;
        width: 20px;
    }

    .social-links {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .social-link {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .social-link:hover {
        background: #f39c12;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-3px);
    }

    .info-card {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(243, 156, 18, 0.2);
    }

    .info-card h5 {
        color: #f39c12;
        font-weight: 700;
        margin-bottom: 15px;
        font-family: "Play", sans-serif;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card p {
        color: #ffffff;
        margin-bottom: 0;
        line-height: 1.6;
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .skill-tag,
    .hobby-tag {
        background: rgba(243, 156, 18, 0.2);
        color: #ffffff;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .skill-tag:hover,
    .hobby-tag:hover {
        background: #f39c12;
        transform: translateY(-2px);
    }

    .contact-info {
        color: #ffffff;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: #ffffff;
    }

    .contact-item i {
        color: #f39c12;
        width: 20px;
    }

    .similar-student {
        text-align: center;
        transition: all 0.3s ease;
    }

    .similar-student:hover {
        transform: translateY(-10px);
    }

    .similar-photo {
        width: 80px;
        height: 80px;
        margin: 0 auto 15px;
        border-radius: 50%;
        overflow: hidden;
    }

    .similar-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-similar {
        padding: 40px;
        color: #adadad;
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 25px;
            text-align: center;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }

        .student-name {
            font-size: 2rem;
        }

        .social-links {
            justify-content: center;
        }

        .tags-container {
            justify-content: center;
        }
    }
</style>
