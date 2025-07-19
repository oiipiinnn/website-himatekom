@extends('layouts.main')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Our Blog</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            @if ($posts->count() > 0)
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <h4>{{ $post->title }}</h4>
                                <ul>
                                    <li>{{ $post->published_at->format('M d, Y') }}</li>
                                    <li>{{ $post->user->name }}</li>
                                </ul>
                                <p>{{ $post->excerpt }}</p>
                                <a href="{{ route('blog.show', $post) }}">Read more <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="pagination__option blog__pagi">
                            {{ $posts->links() }}
                        </div>
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
    <!-- Blog Section End -->
@endsection
