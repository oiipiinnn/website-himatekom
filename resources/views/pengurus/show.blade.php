@extends('layouts.main')
@section('content')
    <style>
        .services-page {
            padding-top: 130px !important;
        }

        .member-card {
            background: linear-gradient(135deg, rgba(0, 103, 56, 0.15), rgba(0, 103, 56, 0.08));
            border: 2px solid rgba(0, 103, 56, 0.25);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(15px);
            cursor: pointer;
            max-width: 200px;
            margin: 0 auto;
        }

        .member-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 103, 56, 0.25);
            border-color: rgba(0, 103, 56, 0.4);
            background: rgba(255, 255, 255, 0.12);
        }

        .member-photo {
            height: 220px;
            width: 100%;
            background-position: center !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            position: relative;
            overflow: hidden;
        }
        

        .member-photo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .member-card:hover .member-photo::before {
            opacity: 1;
        }
        .member-photo::after {
            content: 'Lihat Profil';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 103, 56, 0.95);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .member-card:hover .member-photo::after {
            opacity: 1;
        }

        .member-info {
            padding: 20px 15px;
            text-align: center;
        }

        .member-name {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            font-family: "Play", sans-serif;
            line-height: 1.3;
        }

        .member-position {
            font-size: 12px;
            color: #22c55e;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(0, 103, 56, 0.15);
            padding: 4px 10px;
            border-radius: 15px;
            display: inline-block;
        }

        .leader-section {
            margin-bottom: 50px;
        }

        .leader-card {
            background: linear-gradient(135deg, rgba(0, 103, 56, 0.15), rgba(0, 103, 56, 0.08));
            border: 2px solid rgba(0, 103, 56, 0.25);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(15px);
            cursor: pointer;
            max-width: 200px;
            margin: 0 auto;
        }

        .leader-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 103, 56, 0.3);
            border-color: rgba(0, 103, 56, 0.5);
        }

        .leader-photo {
            height: 280px;
            width: 100%;
            background-position: center !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            position: relative;
        }

        .leader-photo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .leader-card:hover .leader-photo::before {
            opacity: 1;
        }

        .leader-photo::after {
            content: 'Lihat Profil';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 103, 56, 0.95);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .leader-card:hover .leader-photo::after {
            opacity: 1;
        }

        .leader-info {
            padding: 25px 20px;
            text-align: center;
        }

        .leader-name {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            font-family: "Play", sans-serif;
        }

        .leader-position {
            font-size: 14px;
            color: #22c55e;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(0, 103, 56, 0.2);
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
        }

        .description-wrapper {
            background: linear-gradient(135deg, rgba(0, 103, 56, 0.08), rgba(0, 103, 56, 0.03));
            border: 1px solid rgba(0, 103, 56, 0.2);
            padding: 30px;
            border-radius: 15px;
            margin: 30px auto 50px;
            max-width: 850px;
            backdrop-filter: blur(15px);
            position: relative;
            overflow: hidden;
        }

        .description-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #006738, #22c55e, #006738);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                background-position: 200% 0;
            }

            50% {
                background-position: -200% 0;
            }
        }

        .description-wrapper p {
            margin: 0;
            line-height: 1.8;
            font-size: 16px;
            color: #ffffff;
            text-align: justify;
            position: relative;
            z-index: 2;
        }

        .back-button {
            background: rgba(0, 103, 56, 0.9);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: rgba(0, 103, 56, 1);
            transform: translateX(-3px);
            color: white;
            text-decoration: none;
        }

        .back-button i {
            transition: transform 0.3s ease;
        }

        .back-button:hover i {
            transform: translateX(-2px);
        }

        .division-image {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
            margin-bottom: 30px;
            max-height: 300px;
            object-fit: cover;
        }

        .division-image:hover {
            transform: scale(1.02);
        }

        .section-divider {
            text-align: center;
            margin: 40px 0 30px;
            position: relative;
        }

        .section-divider h3 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
            position: relative;
            display: inline-block;
            padding: 0 25px;
            background: #0B1215;
            font-family: "Play", sans-serif;
        }

        .section-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            z-index: -1;
        }

        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .leader-grid {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }

        .member-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .member-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .section-title.center-title h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
        }

        .section-title.center-title span {
            font-size: 14px;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .services-page {
                padding-top: 110px !important;
            }

            .leader-photo {
                height: 240px;
            }

            .member-photo {
                height: 200px;
            }

            .description-wrapper {
                margin: 25px 15px 40px;
                padding: 20px 15px;
            }

            .members-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .member-info {
                padding: 15px 10px;
            }

            .leader-info {
                padding: 20px 15px;
            }

            .leader-card {
                max-width: 280px;
            }
        }

        @media (max-width: 480px) {
            .members-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }

            .member-photo {
                height: 180px;
            }

            .leader-photo {
                height: 220px;
            }
        }
    </style>

    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;"
        class="services-page spad">
        <div class="container">
            <!-- Back Button -->
            <a href="{{ route('pengurus') }}" class="back-button">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Daftar Divisi
            </a>

            <!-- Header Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Division</span>
                        <h2>{{ $division->name }}</h2>
                    </div>
                </div>
            </div>

            <!-- Division Image -->
            @if ($division->image)
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="text-center">
                            <img class="img-fluid division-image" src="{{ $division->division_image_url }}"
                                alt="{{ $division->name }}">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Division Description -->
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="description-wrapper">
                        <p>{{ $division->description }}</p>
                    </div>
                </div>
            </div>

            @if ($members->count() > 0)
                @php
                    // Filter berdasarkan posisi leadership
                    $leader = $members
                        ->filter(function ($member) {
                            $pos = strtolower($member->position);
                            return in_array($pos, [
                                'ketua himpunan',
                                'wakil ketua himpunan',
                                'ketua',
                                'wakil ketua',
                                'koordinator',
                                'kepala divisi',
                            ]);
                        })
                        ->first(); // Ambil hanya satu leader utama

                    // Sisa anggota (tidak termasuk leader)
                    $otherMembers = $members->filter(function ($member) use ($leader) {
                        return $leader ? $member->id !== $leader->id : true;
                    });
                @endphp

                <!-- Leader Section -->
                @if ($leader && $leader->student)
                    <div class="leader-section">
                        <div class="section-title center-title">
                            <h2>Pimpinan Divisi</h2>
                        </div>
                        <div class="leader-grid">
                            <div class="leader-card-wrapper">
                                <a href="{{ route('students.show', $leader->student) }}" class="member-link">
                                    <div class="leader-card">
                                        <div class="leader-photo set-bg" data-setbg="{{ $leader->photo_url }}"></div>
                                        <div class="leader-info">
                                            <h3 class="leader-name">{{ $leader->name }}</h3>
                                            <span class="leader-position">{{ $leader->position }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Other Members Section -->
                @if ($otherMembers->count() > 0)
                    <div class="section-divider">
                        <h3>Anggota Divisi</h3>
                    </div>
                    <div class="members-grid">
                        @foreach ($otherMembers as $member)
                            @if ($member->student)
                                <a href="{{ route('students.show', $member->student) }}" class="member-link">
                                    <div class="member-card">
                                        <div class="member-photo set-bg" data-setbg="{{ $member->photo_url }}"></div>
                                        <div class="member-info">
                                            <h4 class="member-name">{{ $member->name }}</h4>
                                            <span class="member-position">{{ $member->position }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="description-wrapper">
                            <p>Belum ada anggota yang terdaftar pada divisi ini.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
