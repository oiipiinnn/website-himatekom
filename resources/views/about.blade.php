@extends('layouts.main')
@section('content')
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="img/breadcrump-bg.jpg">
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
    <!-- Services Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__pic">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-8 col-sm-10">
                                <div class="about__pic__item about__pic__item--center set-bg animated-image"
                                    data-setbg="img/logo.png"></div>
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

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Testimonial Section Begin -->
    {{-- <section class="testimonial spad set-bg" data-setbg="img/testimonial-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Loved By Clients</span>
                        <h2>What clients say?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="testimonial__slider owl-carousel">
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Delivers such a great service that it can benefit all kinds of people from any number
                                    of industries.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="img/testimonial/ta-1.jpg" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Krista Attorn</h5>
                                    <span>Web Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Videographer delivers such a great service that it can benefit all kinds of people
                                    from any number.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="img/testimonial/ta-2.jpg" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Krista Attorn</h5>
                                    <span>Web Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Videographer delivers such a great service that it can benefit all kinds of people
                                    from any number.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="img/testimonial/ta-3.jpg" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Krista Attorn</h5>
                                    <span>Web Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Delivers such a great service that it can benefit all kinds of people from any number
                                    of industries.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="img/testimonial/ta-1.jpg" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Krista Attorn</h5>
                                    <span>Web Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <div class="testimonial__text">
                                <p>Videographer delivers such a great service that it can benefit all kinds of people
                                    from any number.</p>
                            </div>
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="img/testimonial/ta-2.jpg" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Krista Attorn</h5>
                                    <span>Web Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Testimonial Section End -->

    <!-- Counter Section Begin -->
    <section style="background-image: url(img/main-bg.jpg); background-size: cover; " class="counter spad">
        <div class="container">
            <div class="counter__content">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-1.png" alt="">
                                <h2 class="counter_num">8</h2>
                                <p>Divisi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item second__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-2.png" alt="">
                                <h2 class="counter_num">48</h2>
                                <p>Anggota</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item third__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-3.png" alt="">
                                <h2 class="counter_num">30</h2>
                                <p>Program Kerja</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item four__item">
                            <div class="counter__item__text">
                                <img src="img/icons/ci-4.png" alt="">
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

    <!-- Team Section Begin -->
    <section class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Our History</span>
                        <h2>History</h2>
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
                            <!-- Event Two -->
                            <li class="list-inline-item items-list">
                                <div class="px-4">
                                    <div class="event-date badge bg-warning">2009</div>
                                    <h5 class="pt-2">Event Two</h5>
                                    <p class="text-muted">Everyone realizes why a new common language one could refuse
                                        translators.</p>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#eventTwoModal">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item items-list">
                                <div class="px-4">
                                    <div class="event-date badge bg-success">2010</div>
                                    <h5 class="pt-2">Event Two</h5>
                                    <p class="text-muted">Everyone realizes why a new common language one could refuse
                                        translators.</p>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#eventThreeModal">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item items-list">
                                <div class="px-4">
                                    <div class="event-date badge bg-info">2012</div>
                                    <h5 class="pt-2">Event Two</h5>
                                    <p class="text-muted">Everyone realizes why a new common language one could refuse
                                        translators.</p>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#eventFourModal">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item items-list">
                                <div class="px-4">
                                    <div class="event-date badge bg-warning">2020</div>
                                    <h5 class="pt-2">Event Two</h5>
                                    <p class="text-muted">Everyone realizes why a new common language one could refuse
                                        translators.</p>
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#eventFiveModal">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </li>

                            <!-- Add more events here if needed -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Event One -->
        <div class="modal fade" id="eventOneModal" tabindex="-1" aria-labelledby="eventOneModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventOneModalLabel">Event One Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Detail informasi tentang Event One. Anda dapat mengganti teks ini dengan konten yang relevan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Event Two -->
        <div class="modal fade" id="eventTwoModal" tabindex="-1" aria-labelledby="eventTwoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventTwoModalLabel">Event Two Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Detail informasi tentang Event Two. Anda dapat mengganti teks ini dengan konten yang relevan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Event Three -->
        <div class="modal fade" id="eventThreeModal" tabindex="-1" aria-labelledby="eventThreeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventThreeModalLabel">Event Three Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Detail informasi tentang Event Three. Anda dapat mengganti teks ini dengan konten yang relevan.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Event Four -->
        <div class="modal fade" id="eventFourModal" tabindex="-1" aria-labelledby="eventFourModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventFourModalLabel">Event Four Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Detail informasi tentang Event Four. Anda dapat mengganti teks ini dengan konten yang relevan.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Event Five -->
        <div class="modal fade" id="eventFiveModal" tabindex="-1" aria-labelledby="eventFiveModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventFiveModalLabel">Event Five Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Detail informasi tentang Event Five. Anda dapat mengganti teks ini dengan konten yang relevan.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </section>
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Our Location</span>
                            <h2>Find Us</h2>
                        </div>

                        <div class="about__text__desc">
                            <ul>
                                <li><strong>Universitas Andalas</strong></li>
                                <li>Jalan Limau Manis No. 50, Padang, Sumatera Barat</li>
                                <li><strong>Sekretariat Himatekom, Fakultas Teknologi Informasi Lt 1</strong></li>
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



    <!-- Team Section End -->

    <!-- Footer Section Begin -->
@endsection
