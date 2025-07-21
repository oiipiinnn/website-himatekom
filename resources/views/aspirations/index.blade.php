@extends('layouts.main')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Ruang Aspirasi</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Ruang Aspirasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Aspirations Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Aspirasi Mahasiswa</span>
                        <h2>Ruang Aspirasi</h2>
                    </div>
                    <div class="about__text__desc text-center mb-4">
                        <p>Ruang Aspirasi adalah tempat bagi mahasiswa Teknik Komputer untuk menyampaikan ide, saran, atau
                            masukan yang dapat membantu memperbaiki kinerja Himatekom. Kami berkomitmen untuk mendengarkan
                            suara Warga Himatekom dan menjadikan setiap aspirasi sebagai langkah menuju perubahan yang lebih
                            baik.</p>
                        <a href="{{ route('aspirations.create') }}" class="primary-btn">Kirim Aspirasi</a>
                    </div>
                </div>
            </div>

            @if ($aspirations->count() > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title center-title">
                            <h2>Forum Aspirasi</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($aspirations as $aspiration)
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="blog__item">
                                <h4>{{ $aspiration->subject }}</h4>
                                <ul>
                                    <li>{{ $aspiration->approved_at->format('M d, Y') }}</li>
                                    <li>{{ $aspiration->name }}</li>
                                </ul>
                                <p>{{ Str::limit($aspiration->message, 150) }}</p>
                                <div class="mt-2">
                                    <small class="text-muted">Oleh: {{ $aspiration->name }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pagination__option blog__pagi">
                            {{ $aspirations->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Belum ada aspirasi yang dikumandangkan.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Aspirations Section End -->
@endsection
