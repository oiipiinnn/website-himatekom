@extends('layouts.main')
@section('content')
    <style>
        .services-page {
            padding-top: 150px !important;
        }

        .member-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .member-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 103, 56, 0.3);
            border-color: rgba(0, 103, 56, 0.5);
        }

        .member-photo {
            height: 280px;
            background-position: center !important;
            background-size: cover !important;
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
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .member-card:hover .member-photo::before {
            opacity: 1;
        }

        .member-info {
            padding: 25px 20px;
            text-align: center;
        }

        .member-name {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            font-family: "Play", sans-serif;
        }

        .member-position {
            font-size: 14px;
            color: #006738;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(0, 103, 56, 0.1);
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        .leader-section {
            margin-bottom: 60px;
        }

        .leader-card {
            background: linear-gradient(135deg, rgba(0, 103, 56, 0.1), rgba(0, 103, 56, 0.05));
            border: 2px solid rgba(0, 103, 56, 0.3);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(15px);
        }

        .leader-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 103, 56, 0.4);
            border-color: #006738;
        }

        .leader-photo {
            height: 350px;
            background-position: center !important;
            background-size: cover !important;
            position: relative;
        }

        .leader-info {
            padding: 30px 25px;
            text-align: center;
        }

        .leader-name {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            font-family: "Play", sans-serif;
        }

        .leader-position {
            font-size: 16px;
            color: #006738;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: rgba(0, 103, 56, 0.2);
            padding: 8px 20px;
            border-radius: 25px;
            display: inline-block;
        }

        .description-wrapper {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin: 40px auto 60px;
            max-width: 900px;
            backdrop-filter: blur(10px);
        }

        .description-wrapper p {
            margin: 0;
            line-height: 1.8;
            font-size: 16px;
            color: #333;
            text-align: justify;
        }

        .division-image {
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            margin-bottom: 40px;
        }

        .division-image:hover {
            transform: scale(1.02);
        }

        .section-divider {
            text-align: center;
            margin: 50px 0 40px;
        }

        .section-divider h3 {
            color: #ffffff;
            font-size: 22px;
            font-weight: 600;
            position: relative;
            display: inline-block;
            padding: 0 30px;
            background: #0B1215;
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
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .leader-grid {
            display: flex;
            justify-content: center;
            margin-bottom: 60px;
        }

        .leader-card-wrapper {
            max-width: 400px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .services-page {
                padding-top: 120px !important;
            }

            .leader-photo {
                height: 300px;
            }

            .member-photo {
                height: 250px;
            }

            .description-wrapper {
                margin: 30px 15px 40px;
                padding: 25px 20px;
            }

            .members-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }
        }
    </style>

    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;"
        class="services-page spad">
        <div class="container">
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
                            <img class="img-fluid division-image" src="{{ asset('storage/' . $division->image) }}"
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
                @if ($leader)
                    <div class="leader-section">
                        <div class="section-title center-title">
                            <h2>Pimpinan Divisi</h2>
                        </div>
                        <div class="leader-grid">
                            <div class="leader-card-wrapper">
                                <div class="leader-card">
                                    <div class="leader-photo set-bg" data-setbg="{{ $leader->photo_url }}"></div>
                                    <div class="leader-info">
                                        <h3 class="leader-name">{{ $leader->name }}</h3>
                                        <span class="leader-position">{{ $leader->position }}</span>
                                    </div>
                                </div>
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
                            <div class="member-card">
                                <div class="member-photo set-bg" data-setbg="{{ $member->photo_url }}"></div>
                                <div class="member-info">
                                    <h4 class="member-name">{{ $member->name }}</h4>
                                    <span class="member-position">{{ $member->position }}</span>
                                </div>
                            </div>
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
