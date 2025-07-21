@extends('layouts.main')
@section('content')
    <!-- Blog Hero Section -->
    <div class="blog-hero spad set-bg" data-setbg="{{ $post->featured_image_url }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog__hero__text">
                        <h2>{{ $post->title }}</h2>
                        <ul>
                            <li><i class="fa fa-calendar"></i> {{ $post->published_at->format('M d, Y') }}</li>
                            <li><i class="fa fa-user"></i> {{ $post->user->name }}</li>
                            @if ($post->reading_time)
                                <li><i class="fa fa-clock"></i> {{ $post->reading_time_text }}</li>
                            @endif
                            <li><i class="fa fa-eye"></i> {{ $post->view_count }} views</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Details Section -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <!-- Tags -->
                        @if ($post->tags)
                            <div class="blog__details__tags mb-4">
                                <span>Tags:</span>
                                @foreach ($post->tags_array as $tag)
                                    <a href="{{ route('blog.tag', $tag) }}" class="tag-badge">{{ $tag }}</a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="blog__details__text">
                            {!! nl2br(e($post->content)) !!}
                        </div>

                        <!-- Share Buttons -->
                        <div class="blog__details__share mt-5">
                            <h5>Share this article:</h5>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                                    target="_blank" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->fullUrl()) }}"
                                    target="_blank" class="share-btn whatsapp">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank" class="share-btn linkedin">
                                    <i class="fab fa-linkedin-in"></i> LinkedIn
                                </a>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="blog__details__option mt-5">
                            <div class="row">
                                <div class="col-lg-6">
                                    @php
                                        $prevPost = \App\Models\Post::published()
                                            ->where('published_at', '<', $post->published_at)
                                            ->latest('published_at')
                                            ->first();
                                    @endphp
                                    @if ($prevPost)
                                        <div class="blog__details__option__item">
                                            <h5><i class="fa fa-arrow-left"></i> Previous Post</h5>
                                            <div class="blog__details__option__item__content">
                                                <h6><a
                                                        href="{{ route('blog.show', $prevPost) }}">{{ $prevPost->title }}</a>
                                                </h6>
                                                <span>{{ $prevPost->published_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    @php
                                        $nextPost = \App\Models\Post::published()
                                            ->where('published_at', '>', $post->published_at)
                                            ->oldest('published_at')
                                            ->first();
                                    @endphp
                                    @if ($nextPost)
                                        <div class="blog__details__option__item blog__details__option__item--right">
                                            <h5>Next Post <i class="fa fa-arrow-right"></i></h5>
                                            <div class="blog__details__option__item__content">
                                                <h6><a
                                                        href="{{ route('blog.show', $nextPost) }}">{{ $nextPost->title }}</a>
                                                </h6>
                                                <span>{{ $nextPost->published_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="blog__sidebar">
                        <!-- Author Info -->
                        <div class="blog__sidebar__item">
                            <h4>About Author</h4>
                            <div class="author-info">
                                <div class="author-avatar">
                                    <i class="fa fa-user-circle fa-3x"></i>
                                </div>
                                <div class="author-details">
                                    <h5>{{ $post->user->name }}</h5>
                                    <p>Author at Himatekom Unand</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Posts -->
                        @php
                            $recentPosts = \App\Models\Post::published()
                                ->where('id', '!=', $post->id)
                                ->with('user')
                                ->latest('published_at')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if ($recentPosts->count() > 0)
                            <div class="blog__sidebar__item">
                                <h4>Recent Posts</h4>
                                <div class="blog__sidebar__recent">
                                    @foreach ($recentPosts as $recentPost)
                                        <div class="recent-post-item">
                                            @if ($recentPost->featured_image)
                                                <div class="recent-post-thumb">
                                                    <img src="{{ $recentPost->featured_image_url }}"
                                                        alt="{{ $recentPost->title }}">
                                                </div>
                                            @endif
                                            <div class="recent-post-content">
                                                <h6><a
                                                        href="{{ route('blog.show', $recentPost) }}">{{ Str::limit($recentPost->title, 50) }}</a>
                                                </h6>
                                                <p class="recent-post-meta">
                                                    <i class="fa fa-calendar"></i>
                                                    {{ $recentPost->published_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Tags -->
                        @php
                            $allTags = \App\Models\Post::published()
                                ->whereNotNull('tags')
                                ->pluck('tags')
                                ->flatten()
                                ->countBy()
                                ->sortDesc()
                                ->take(15);
                        @endphp
                        @if ($allTags->count() > 0)
                            <div class="blog__sidebar__item">
                                <h4>Popular Tags</h4>
                                <div class="blog__sidebar__tags">
                                    @foreach ($allTags as $tag => $count)
                                        <a href="{{ route('blog.tag', $tag) }}" class="tag-badge-sidebar">
                                            {{ $tag }}
                                            <span class="tag-count">({{ $count }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <style>
        /* Blog Details Styles */
        .blog-hero {
            position: relative;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .blog-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        .blog__hero__text {
            position: relative;
            z-index: 2;
        }

        .blog__hero__text h2 {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .blog__hero__text ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .blog__hero__text ul li {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog__details__content {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .blog__details__tags {
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .blog__details__tags span {
            color: #ffffff;
            font-weight: 600;
            margin-right: 10px;
        }

        .tag-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #006738;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            text-decoration: none;
            margin-right: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .tag-badge:hover {
            background: #ffffff;
            color: #006738;
            transform: scale(1.05);
        }

        .blog__details__text {
            color: #ffffff;
            line-height: 1.8;
            font-size: 16px;
            margin: 30px 0;
        }

        .blog__details__text p {
            margin-bottom: 20px;
        }

        .blog__details__share h5 {
            color: #ffffff;
            margin-bottom: 15px;
        }

        .share-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            color: white;
        }

        .share-btn.facebook {
            background: #1877f2;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.whatsapp {
            background: #25d366;
        }

        .share-btn.linkedin {
            background: #0077b5;
        }

        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            color: white;
            text-decoration: none;
        }

        .blog__details__option {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
        }

        .blog__details__option__item h5 {
            color: #006738;
            font-size: 14px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .blog__details__option__item h6 a {
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .blog__details__option__item h6 a:hover {
            color: #006738;
        }

        .blog__details__option__item span {
            color: #adadad;
            font-size: 13px;
        }

        .blog__details__option__item--right {
            text-align: right;
        }

        /* Sidebar Styles */
        .blog__sidebar {
            padding-left: 30px;
        }

        .blog__sidebar__item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .blog__sidebar__item h4 {
            color: #ffffff;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #006738;
            font-size: 18px;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            color: #006738;
        }

        .author-details h5 {
            color: #ffffff;
            margin-bottom: 5px;
        }

        .author-details p {
            color: #adadad;
            margin: 0;
            font-size: 14px;
        }

        .recent-post-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .recent-post-item:last-child {
            border-bottom: none;
        }

        .recent-post-thumb {
            flex-shrink: 0;
        }

        .recent-post-thumb img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .recent-post-content h6 a {
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .recent-post-content h6 a:hover {
            color: #006738;
        }

        .recent-post-meta {
            color: #adadad;
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 0;
        }

        .blog__sidebar__tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-badge-sidebar {
            display: inline-block;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 20px;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tag-badge-sidebar:hover {
            background: #006738;
            color: white;
            transform: scale(1.05);
        }

        .tag-count {
            font-size: 11px;
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .blog__sidebar {
                padding-left: 0;
                margin-top: 50px;
            }

            .blog__hero__text h2 {
                font-size: 1.8rem;
            }

            .blog__hero__text ul {
                justify-content: center;
                gap: 15px;
            }

            .blog__details__content {
                padding: 25px;
            }

            .share-buttons {
                justify-content: center;
            }

            .author-info {
                text-align: center;
                flex-direction: column;
            }

            .blog__details__option__item--right {
                text-align: left;
                margin-top: 20px;
            }
        }
    </style>
@endpush
