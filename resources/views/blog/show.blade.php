@extends('layouts.main')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $post->title }}</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <a href="{{ route('blog') }}">Blog</a>
                            <span>{{ Str::limit($post->title, 30) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="blog__details__content">
                        @if ($post->featured_image)
                            <div class="blog__details__pic">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="img-fluid">
                            </div>
                        @endif
                        <div class="blog__details__text">
                            <h2>{{ $post->title }}</h2>
                            <ul class="blog__details__meta">
                                <li>{{ $post->published_at->format('M d, Y') }}</li>
                                <li>By {{ $post->user->name }}</li>
                            </ul>
                            <div class="blog__details__desc">
                                <p><strong>{{ $post->excerpt }}</strong></p>
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-8 offset-lg-2">
                    <div class="blog__details__navigation">
                        <a href="{{ route('blog') }}" class="primary-btn">← Kembali ke Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <style>
        .blog__details__pic {
            margin-bottom: 30px;
        }

        .blog__details__pic img {
            border-radius: 10px;
        }

        .blog__details__meta {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            display: flex;
            gap: 20px;
        }

        .blog__details__meta li {
            color: #666;
            font-size: 14px;
        }

        .blog__details__desc {
            line-height: 1.8;
            font-size: 16px;
            color: #333;
        }

        .blog__details__navigation {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eee;
        }
    </style>
@endsection
