@extends('layouts.main')
@section('content')
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>About us</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>About</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__pic">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="about__pic__item about__pic__item--center set-bg animated-image"
                                    data-setbg="{{ $aboutData['logo_image'] }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>{{ $aboutData['subtitle'] }}</span>
                            <h2>{{ $aboutData['title'] }}</h2>
                        </div>
                        <div class="about__text__desc">
                            <p>{{ $aboutData['description'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Counter Section Begin -->
    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;" class="counter spad">
        <div class="container">
            <div class="counter__content">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-1.png') }}" alt="">
                                <h2 class="counter_num">8</h2>
                                <p>Divisi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item second__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-2.png') }}" alt="">
                                <h2 class="counter_num">48</h2>
                                <p>Anggota</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item third__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-3.png') }}" alt="">
                                <h2 class="counter_num">30</h2>
                                <p>Program Kerja</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item four__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-4.png') }}" alt="">
                                <h2 class="counter_num">3</h2>
                                <p>Main Event</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- History Section Begin -->
    <section class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Our History</span>
                        <h2>{{ $aboutData['history_title'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="horizontal-timeline">
                        <ul class="list-inline items">
                            <!-- Event One -->
                            <li class="list-inline-item items-list">
                                <div class="px-4">
                                    <div class="event-date badge bg-info">2008</div>
                                    <h5 class="pt-2">Event One</h5>
                                    <p class="text-muted">Himatekom awalnya dibangun oleh Ary Zona</p>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#eventOneModal">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <!-- Add more events here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>{{ $aboutData['location_subtitle'] }}</span>
                            <h2>{{ $aboutData['location_title'] }}</h2>
                        </div>
                        <div class="about__text__desc">
                            <ul>
                                <li><strong>Universitas Andalas</strong></li>
                                <li>{{ $aboutData['location_address'] }}</li>
                                <li><strong>{{ $aboutData['location_office'] }}</strong></li>
                            </ul>
                            <p class="mt-3">Our Social Media :</p>
                            <div style="text-align: start!important" class="footer__top__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__pic">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.3090413657255!2d100.45834427349827!3d-0.9154688353301946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b7963ede35cf%3A0x10ce49f24233a8ae!2sSekretariat%20Himpunan%20Mahasiswa%20Sistem%20Komputer%20Universitas%20Andalas!5e0!3m2!1sid!2sid!4v1735065233606!5m2!1sid!2sid"
                                    width="450" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
