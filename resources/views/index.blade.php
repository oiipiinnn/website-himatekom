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
                                <p>CORE3D adalah event tahunan Departemen Teknik Komputer yang berkolaborasi dengan Himpunan
                                    Mahasiswa Teknik Komputer</p>
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
                                <a href="https://ce.fti.unand.ac.id/" target="_blank" class="primary-btn">Tentang Teknik
                                    Komputer</a>
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
                        <span>Operasional HIMATEKOM</span>
                        <h2>Bidang</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($divisions as $division)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="services__item">
                            <div class="services__item__icon">
                                @if ($division->icon)
                                    <img src="{{ $division->icon_url }}" alt="{{ $division->name }}"
                                        style="width: 70%">
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
                        <span>Terbaru dari HIMATEKOM</span>
                        <h2>Blog Update</h2>
                    </div>
                </div>
            </div>
            @if ($latestPosts->count() > 0)
                <div class="row">
                    <div class="latest__slider owl-carousel">
                        @foreach ($latestPosts as $post)
                            <div class="col-lg-4">
                                <div class="blog__item latest__item"
                                    data-featured-image="{{ $post->featured_image_url }}">
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
    <section class="callto spad set-bg" data-setbg="{{ asset('img/testimonial-bg.jpg') }}">
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
                    <span>Saksikan Perjalanan Kami</span>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk blog hover effect
            function initBlogHoverEffect() {
                const blogItems = document.querySelectorAll('.blog__item.latest__item');

                blogItems.forEach(function(item) {
                    const imageUrl = item.dataset.featuredImage;
                    const defaultImage = '{{ asset('img/blog/blog-default.jpg') }}';

                    // Hanya apply hover effect jika ada gambar yang valid dan bukan default
                    if (imageUrl && imageUrl !== defaultImage) {
                        item.addEventListener('mouseenter', function() {
                            // Tambah class untuk styling via CSS
                            this.classList.add('blog-hover-active');
                            this.style.backgroundImage = `url(${imageUrl})`;
                        });

                        item.addEventListener('mouseleave', function() {
                            // Hapus class dan reset background
                            this.classList.remove('blog-hover-active');
                            this.style.backgroundImage = '';
                        });
                    }
                });
            }

            // Initialize effects
            initBlogHoverEffect();

            // Re-initialize untuk owl carousel setelah dimuat/refresh
            if ($('.latest__slider').length) {
                $('.latest__slider').on('initialized.owl.carousel refreshed.owl.carousel', function() {
                    setTimeout(function() {
                        initBlogHoverEffect();
                    }, 200);
                });

                // Initialize juga saat carousel berubah slide
                $('.latest__slider').on('changed.owl.carousel', function() {
                    setTimeout(function() {
                        initBlogHoverEffect();
                    }, 100);
                });
            }
        });
    </script>

    <style>
        /* CSS khusus untuk blog hover effect - tidak akan overwrite yang existing */
        .blog__item.latest__item.blog-hover-active {
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            transition: all 0.3s ease !important;
        }

        /* Overlay hanya muncul saat ada class blog-hover-active */
        .blog__item.latest__item.blog-hover-active::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
            pointer-events: none;
        }

        /* Text styling hanya saat hover dengan background image */
        .blog__item.latest__item.blog-hover-active h4,
        .blog__item.latest__item.blog-hover-active p,
        .blog__item.latest__item.blog-hover-active ul li,
        .blog__item.latest__item.blog-hover-active a {
            position: relative;
            z-index: 2;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .blog__item.latest__item.blog-hover-active ul li {
            color: #ffffff !important;
        }

        .blog__item.latest__item.blog-hover-active p {
            color: #ffffff !important;
        }
    </style>
@endpush
