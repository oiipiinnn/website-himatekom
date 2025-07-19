@extends('layouts.main')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Gallery</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Gallery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Gallery Section Begin -->
    <section class="work p-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Our Gallery</span>
                        <h2>Gallery</h2>
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
                                            <li>{{ $gallery->event_date->format('d M Y') }}</li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="pagination__option blog__pagi d-flex justify-content-center">
                            {{ $galleries->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Belum ada foto dalam galeri.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Gallery Section End -->
@endsection
