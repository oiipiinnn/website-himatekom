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
                        <h2>Riset dan Pengembangan</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 div-container col-md-8 col-sm-10">
                            <img class="img-fluid div-img" src="{{ asset('img/pengurus/risbang.png') }}" alt="">
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
                            data-setbg="{{ asset('img/pengurus/anisa.JPG') }}"
                            style="background-position: center !important; background-size: cover !important;"
                            >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Anisa Nur Fitri</h4>
                            <span>Koordinator Divisi Riset dan Pengembangan</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row  d-flex justify-content-center align-items-center">
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/muti.JPG') }}"

                            >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Mutiara</h4>
                            <span>Staff Riset dan Pengembangan</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/pera.JPG') }}">
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Pera</h4>
                            <span>Staff Riset dan Pengembangan</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/tiffani.JPG') }}"
                           >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Tiffani</h4>
                            <span>Staff Riset dan Pengembangan</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row  d-flex justify-content-center align-items-center">
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/prima.JPG') }}"
                            style="background-position: inherit !important; background-size: cover !important;"
                            >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Prima</h4>
                            <span>Staff Riset dan Pengembangan</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 px-1 col-md-6 col-sm-6 p-0">
                    <div class="portfolio__item">
                        <div class="portfolio__item__video set-bg"
                            data-setbg="{{ asset('img/pengurus/rafif.JPG') }}"
                            >
                            <a href="#"></a>
                        </div>
                        <div class="portfolio__item__text">
                            <h4>Rafif</h4>
                            <span>Staff Riset dan Pengembangan</span>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </section>


    <!-- Team Section End -->

    <!-- Footer Section Begin -->
@endsection
