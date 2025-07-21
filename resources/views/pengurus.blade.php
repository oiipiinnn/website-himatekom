@extends('layouts.main')
@section('content')
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
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
    </div>
    <!-- Breadcrumb End -->
    
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
                        <a href="{{ route('pengurus.show', $division) }}">
                            <div class="services__item d-flex flex-column align-items-center">
                                <div class="services__item__icon">
                                    @if ($division->icon)
                                        <img src="{{ asset('storage/' . $division->icon) }}" alt="{{ $division->name }}"
                                            style="width: 70%">
                                    @else
                                        <img src="{{ asset('img/icons/si-1.png') }}" alt="{{ $division->name }}">
                                    @endif
                                </div>
                                <h4>{{ $division->name }}</h4>
                                <p>{{ Str::limit($division->description, 100) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
