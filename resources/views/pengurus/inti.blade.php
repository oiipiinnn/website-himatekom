@extends('layouts.main')
@section('content')
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    {{-- <div class="breadcrumb-option spad set-bg" data-setbg="{{asset('img/breadcrump-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Pengurus</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Pengurus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Breadcrumb End -->
    <section style="background-image: url(img/main-bg.jpg); background-size: cover; " class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Division</span>
                        <h2>Inti Presidium</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 div-container col-md-8 col-sm-10">
                            <img class="img-fluid div-img" src="{{ asset('img//pengurus/inti.png') }}" alt="">
                        </div>
                    </div>
                    <div class="about__text__desc mt-3">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum temporibus quidem reiciendis
                            officiis tempore voluptate exercitationem officia error quod dicta!</p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <h2>Member</h2>
                    </div>
                </div>
            </div>
            <div class="row  d-flex justify-content-center align-items-center">
                <div class="col-lg-3 px-3 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/arvin.JPG') }}"
                            style="background-position: center !important; background-size: cover !important;"
                            >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>M. Arvin Haravanda</h4>
                            <span>Ketua Himpunan</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-3 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/berka.JPG') }}"
                             style="background-position: top !important; background-size: cover !important;"
                            >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Berka</h4>
                            <span>Wakil Ketua Himpunan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row  d-flex justify-content-center align-items-center">
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/nanda.JPG') }}">
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Nanda</h4>
                            <span>Sekretaris I</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/elsha.JPG') }}">
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Elsha</h4>
                            <span>Sekretaris II</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/dira.JPG') }}">
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Elvira</h4>
                            <span>Bendahara I</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/yulia.JPG') }}">
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Yulia</h4>
                            <span>Bendahara II</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>


    <!-- Team Section End -->

    <!-- Footer Section Begin -->
@endsection
