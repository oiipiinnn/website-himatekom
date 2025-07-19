@extends('layouts.main')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="hero__text">
                                <span>TEKOM UNAND IS WONDERFUL</span>
                                <h2>Himpunan Mahasiswa Teknik Komputer</h2>
                                <a href="/tentang-kami" class="primary-btn">Cari tau tentang kami</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="hero__text">
                                <span>Proudly Present</span>
                                <h2>CORE3D</h2>
                                <a href="/core3d" class="primary-btn">Tentang CORE3D 2025</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="hero__text">
                                <span>Departemen Kebanggaan Kami</span>
                                <h2>Teknik Komputer FTI UNAND</h2>
                                <a href="https://ce.fti.unand.ac.id/" class="primary-btn">Tentang Teknik Komputer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__pic">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="about__pic__item about__pic__item--center set-bg animated-image"
                                    data-setbg="{{ asset('img/logo.png') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Tentang Himatekom</span>
                            <h2>Siapa Kami?</h2>
                        </div>
                        <div class="about__text__desc">
                            <p>Himpunan Mahasiswa Teknik Komputer (Himatekom) adalah organisasi mahasiswa yang berdedikasi
                                untuk mendukung pertumbuhan akademik dan profesional anggotanya. Melalui proyek inovatif,
                                workshop, dan acara kolaboratif, kami menciptakan lingkungan yang mendukung calon insinyur
                                komputer masa depan.</p>
                        </div>
                        <a href="/tentang-kami" class="primary-btn">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Divisions Section Begin -->
    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;"
        class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Division</span>
                        <h2>Division</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($divisions as $division)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="services__item">
                            <div class="services__item__icon">
                                @if ($division->icon)
                                    <img src="{{ asset('storage/' . $division->icon) }}" alt="{{ $division->name }}">
                                @else
                                    <img src="{{ asset('img/icons/si-1.png') }}" alt="{{ $division->name }}">
                                @endif
                            </div>
                            <h4>{{ $division->name }}</h4>
                            <p>{{ Str::limit($division->description, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <a href="/pengurus" class="primary-btn text-center w-100">Meet Our Team</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Blog</span>
                        <h2>Blog Update</h2>
                    </div>
                </div>
            </div>
            @if ($latestPosts->count() > 0)
                <div class="row">
                    <div class="latest__slider owl-carousel">
                        @foreach ($latestPosts as $post)
                            <div class="col-lg-4">
                                <div class="blog__item latest__item">
                                    <h4>{{ $post->title }}</h4>
                                    <ul>
                                        <li>{{ $post->published_at->format('M d, Y') }}</li>
                                        <li>{{ $post->user->name }}</li>
                                    </ul>
                                    <p>{{ $post->excerpt }}</p>
                                    <a href="{{ route('blog.show', $post) }}">Read more <span
                                            class="arrow_right"></span></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Belum ada artikel blog yang dipublikasikan.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Latest Blog Section End -->

    <!-- Call To Action Section Begin -->
    <section class="callto spad set-bg" data-setbg="{{ asset('img/callto-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="callto__text">
                        <h2>Ruang Aspirasi</h2>
                        <p>Ruang Aspirasi adalah tempat bagi mahasiswa Teknik Komputer untuk menyampaikan ide, saran, atau
                            masukan yang dapat membantu memperbaiki kinerja Himatekom. Kami berkomitmen untuk mendengarkan
                            suara Warga Himatekom dan menjadikan setiap aspirasi sebagai langkah menuju perubahan yang lebih
                            baik.</p>
                        <a href="{{ route('aspirations.create') }}">Mulai Ber-Aspirasi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section Begin -->
    <section class="work p-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title center-title">
                    <span>Ayo Saksikan Perjalanan</span>
                    <h2>Galeri</h2>
                </div>
            </div>
        </div>
        @if ($galleries->count() > 0)
            <div class="work__gallery">
                <div class="grid-sizer"></div>
                @foreach ($galleries as $index => $gallery)
                    @php
                        $itemClass = match ($index % 7) {
                            0, 6 => 'wide__item',
                            3 => 'large__item',
                            default => 'small__item',
                        };
                    @endphp
                    <div class="work__item {{ $itemClass }} set-bg" data-setbg="{{ $gallery->image_url }}">
                        <div class="work__item__hover">
                            <h4>{{ $gallery->title }}</h4>
                            @if ($gallery->event_name)
                                <ul>
                                    <li>{{ $gallery->event_name }}</li>
                                    @if ($gallery->event_date)
                                        <li>{{ $gallery->event_date->format('M Y') }}</li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <p>Belum ada foto dalam galeri.</p>
            </div>
        @endif
    </section>
    <!-- Gallery Section End -->
@endsection
