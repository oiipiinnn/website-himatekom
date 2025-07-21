@extends('layouts.main')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ isset($currentTag) ? 'Tag: ' . $currentTag : 'Our Blog' }}</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Blog</span>
                            @if (isset($currentTag))
                                <span>{{ $currentTag }}</span>
                            @endif
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
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Search Form -->
                    <div class="blog__search mb-4">
                        <form action="{{ route('blog') }}" method="GET" class="d-flex">
                            <input type="text" name="search" placeholder="Search articles..."
                                value="{{ request('search') }}" class="form-control me-2">
                            <button type="submit" class="btn btn-outline-light">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>

                    @if ($posts->count() > 0)
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-6 col-md-12 mb-4">
                                    <div class="blog__item"
                                        data-featured-image="{{ $post->featured_image ? $post->featured_image_url : '' }}"
                                        data-has-image="{{ $post->featured_image ? 'true' : 'false' }}">
                                        @if ($post->featured_image)
                                            <div class="blog__item__pic">
                                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
                                            </div>
                                        @endif
                                        <div class="blog__item__content">
                                            <h4><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h4>
                                            <ul class="blog__item__meta">
                                                <li><i class="fa fa-calendar"></i>
                                                    {{ $post->published_at->format('M d, Y') }}</li>
                                                <li><i class="fa fa-user"></i> {{ $post->user->name }}</li>
                                                @if ($post->view_count > 0)
                                                    <li><i class="fa fa-eye"></i> {{ $post->view_count }} views</li>
                                                @endif
                                                @if ($post->reading_time)
                                                    <li><i class="fa fa-clock"></i> {{ $post->reading_time_text }}</li>
                                                @endif
                                            </ul>

                                            @if ($post->tags)
                                                <div class="blog__item__tags mb-3">
                                                    @foreach ($post->tags_array as $tag)
                                                        <a href="{{ route('blog.tag', $tag) }}" class="tag-badge">
                                                            {{ $tag }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <p>{{ $post->excerpt }}</p>
                                            <a href="{{ route('blog.show', $post) }}" class="read-more-btn">
                                                Read more <span class="arrow_right"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pagination__option blog__pagi">
                                    {{ $posts->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-12 text-center py-5">
                                <div class="no-posts">
                                    <i class="fa fa-file-text fa-4x mb-3" style="color: #006738;"></i>
                                    <h4>No Articles Found</h4>
                                    <p class="text-muted">
                                        @if (request('search'))
                                            No articles match your search for "{{ request('search') }}"
                                        @elseif(isset($currentTag))
                                            No articles found with tag "{{ $currentTag }}"
                                        @else
                                            No articles have been published yet
                                        @endif
                                    </p>
                                    @if (request('search') || isset($currentTag))
                                        <a href="{{ route('blog') }}" class="btn btn-primary mt-3">View All Articles</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="blog__sidebar">
                        @if ($allTags->count() > 0)
                            <div class="blog__sidebar__item">
                                <h4>Popular Tags</h4>
                                <div class="blog__sidebar__tags">
                                    @foreach ($allTags as $tag => $count)
                                        <a href="{{ route('blog.tag', $tag) }}"
                                            class="tag-badge-sidebar {{ isset($currentTag) && $currentTag == $tag ? 'active' : '' }}">
                                            {{ $tag }}
                                            <span class="tag-count">({{ $count }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Archive or Recent Stats -->
                        <div class="blog__sidebar__item">
                            <h4>Blog Stats</h4>
                            <div class="blog__sidebar__stats">
                                <div class="stat-item">
                                    <i class="fa fa-file-alt"></i>
                                    <span>{{ \App\Models\Post::published()->count() }} Articles Published</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa fa-eye"></i>
                                    <span>{{ \App\Models\Post::published()->sum('view_count') }} Total Views</span>
                                </div>
                                @if ($allTags->count() > 0)
                                    <div class="stat-item">
                                        <i class="fa fa-tags"></i>
                                        <span>{{ $allTags->count() }} Different Tags</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Blog hover effect
            function initBlogHoverEffect() {
                const blogItems = document.querySelectorAll('.blog__item');

                blogItems.forEach(function(item) {
                    const imageUrl = item.dataset.featuredImage;
                    const hasImage = item.dataset.hasImage === 'true';
                    const hasPicElement = item.querySelector('.blog__item__pic');

                    // Only apply hover effect if:
                    // 1. Item has a featured image
                    // 2. Item doesn't already have a .blog__item__pic element (to avoid double background)
                    if (hasImage && imageUrl && !hasPicElement) {
                        item.addEventListener('mouseenter', function() {
                            this.classList.add('blog-hover-active');
                            this.style.backgroundImage = `url(${imageUrl})`;
                        });

                        item.addEventListener('mouseleave', function() {
                            this.classList.remove('blog-hover-active');
                            this.style.backgroundImage = '';
                        });
                    }
                });
            }

            initBlogHoverEffect();
        });
    </script>

    <style>
        /* Blog Styles */
        .blog__search {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .blog__search input {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            border-radius: 25px;
            padding: 12px 20px;
        }

        .blog__search input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .blog__search .btn {
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 12px 20px;
        }

        .blog__item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog__item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .blog__item__pic {
            overflow: hidden;
        }

        .blog__item__pic img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .blog__item:hover .blog__item__pic img {
            transform: scale(1.1);
        }

        .blog__item__content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .blog__item__content h4 {
            margin-bottom: 15px;
        }

        .blog__item__content h4 a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .blog__item__content h4 a:hover {
            color: #006738;
        }

        .blog__item__meta {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .blog__item__meta li {
            color: #adadad;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog__item__tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 15px;
        }

        .tag-badge {
            display: inline-block;
            padding: 4px 10px;
            background: #006738;
            color: white;
            border-radius: 15px;
            font-size: 11px;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-weight: 500;
        }

        .tag-badge:hover {
            background: #ffffff;
            color: #006738;
            transform: scale(1.05);
        }

        .blog__item__content p {
            flex: 1;
            margin-bottom: 20px;
            color: #adadad;
            line-height: 1.6;
        }

        .read-more-btn {
            color: #006738;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .read-more-btn:hover {
            color: #ffffff;
            text-decoration: none;
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

        .tag-badge-sidebar:hover,
        .tag-badge-sidebar.active {
            background: #006738;
            color: white;
            transform: scale(1.05);
        }

        .tag-count {
            font-size: 11px;
            opacity: 0.7;
        }

        .blog__sidebar__stats {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #adadad;
            font-size: 14px;
        }

        .stat-item i {
            color: #006738;
            width: 20px;
        }

        .no-posts {
            padding: 60px 20px;
        }

        .no-posts h4 {
            color: #ffffff;
            margin-bottom: 15px;
        }

        /* Blog hover effect styles - Only apply to items WITHOUT .blog__item__pic */
        .blog__item.blog-hover-active:not(:has(.blog__item__pic)) {
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }

        .blog__item.blog-hover-active:not(:has(.blog__item__pic))::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .blog__item.blog-hover-active:not(:has(.blog__item__pic)) .blog__item__content {
            position: relative;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .blog__sidebar {
                padding-left: 0;
                margin-top: 50px;
            }

            .blog__item__meta {
                gap: 8px;
                font-size: 12px;
            }

            .blog__search form {
                flex-direction: column;
                gap: 10px;
            }

            .blog__item__content {
                padding: 20px;
            }
        }
    </style>
@endpush
