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

    <!-- Forum Aspirasi Section -->
    <section class="forum-section spad">
        <div class="container">
            <!-- Forum Header -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title">
                        <span>Forum Diskusi</span>
                        <h2>Aspirasi Mahasiswa Teknik Komputer</h2>
                    </div>
                    <div class="forum-description">
                        <p>Berikut adalah kumpulan aspirasi yang telah disetujui dan dipublikasikan. Setiap aspirasi
                            merupakan suara mahasiswa untuk kemajuan Himatekom yang lebih baik.</p>
                    </div>
                </div>
            </div>

            <!-- Forum Statistics -->
            <div class="row mb-5">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="forum-stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $aspirations->total() }}</div>
                            <div class="stat-label">Total Aspirasi</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="forum-stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $aspirations->unique('email')->count() }}</div>
                            <div class="stat-label">Kontributor</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="forum-stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">
                                {{ $aspirations->where('approved_at', '>=', now()->subDays(30))->count() }}</div>
                            <div class="stat-label">Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($aspirations->count() > 0)
                <!-- Aspirations List -->
                <div class="row">
                    @foreach ($aspirations as $aspiration)
                        <div class="col-lg-12 mb-4">
                            <div class="aspiration-forum-card">
                                <div class="forum-card-header">
                                    <div class="aspiration-meta">
                                        <div class="aspiration-subject">
                                            <h4>{{ $aspiration->subject }}</h4>
                                        </div>
                                        <div class="aspiration-info">
                                            <span class="author-name">
                                                <i class="fas fa-user"></i>
                                                {{ $aspiration->name }}
                                            </span>
                                            @if ($aspiration->nim)
                                                <span class="author-nim">
                                                    <i class="fas fa-id-card"></i>
                                                    {{ $aspiration->nim }}
                                                </span>
                                            @endif
                                            <span class="aspiration-date">
                                                <i class="fas fa-calendar"></i>
                                                {{ $aspiration->approved_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="aspiration-status">
                                        <span class="status-badge approved">
                                            <i class="fas fa-check-circle"></i>
                                            Disetujui
                                        </span>
                                    </div>
                                </div>

                                <div class="forum-card-body">
                                    <div class="aspiration-content">
                                        <p class="message-preview">{{ Str::limit($aspiration->message, 300) }}</p>
                                        @if (strlen($aspiration->message) > 300)
                                            <div class="full-message" id="full-{{ $aspiration->id }}"
                                                style="display: none;">
                                                <p class="message-full">{{ $aspiration->message }}</p>
                                            </div>
                                            <button class="toggle-message-btn"
                                                onclick="toggleMessage({{ $aspiration->id }})">
                                                <span class="toggle-text">Baca Selengkapnya</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="forum-card-footer">
                                    <div class="interaction-stats">
                                        <span class="time-ago">
                                            <i class="fas fa-clock"></i>
                                            {{ $aspiration->approved_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="forum-actions">
                                        <button class="forum-action-btn"
                                            onclick="shareAspiration('{{ $aspiration->subject }}')">
                                            <i class="fas fa-share-alt"></i>
                                            Bagikan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($aspirations->hasPages())
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="forum-pagination">
                                {{ $aspirations->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="empty-forum">
                            <div class="empty-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h3>Belum Ada Aspirasi</h3>
                            <p>Forum aspirasi masih kosong. Jadilah yang pertama untuk menyuarakan aspirasi Anda!</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Call to Action -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="forum-cta">
                        <div class="cta-content">
                            <h3>Punya Aspirasi untuk Himatekom?</h3>
                            <p>Sampaikan ide, saran, atau masukan Anda untuk kemajuan organisasi. Setiap aspirasi akan
                                direview oleh admin sebelum dipublikasikan di forum ini.</p>
                            <a href="{{ route('aspirations.create') }}" class="cta-button">
                                <i class="fas fa-plus-circle"></i>
                                Kirim Aspirasi Anda
                            </a>
                        </div>
                        <div class="cta-illustration">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Forum Section */
        .forum-section {
            background: #0b1215;
        }

        .forum-description {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 50px;
        }

        .forum-description p {
            color: #e0e0e0;
            font-size: 1.1rem;
            line-height: 1.6;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Forum Statistics */
        .forum-stat-card {
            background: rgba(42, 26, 77, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid #333333;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .forum-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 103, 56, 0.2);
            border-color: #006738;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #006738, #00a653);
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(0, 103, 56, 0.3);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .stat-label {
            color: #d0d0d0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Aspiration Forum Cards */
        .aspiration-forum-card {
            background: rgba(26, 8, 61, 0.95);
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
            border: 1px solid #333333;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .aspiration-forum-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 103, 56, 0.2);
            border-color: #006738;
        }

        .forum-card-header {
            padding: 25px 30px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #333333;
        }

        .aspiration-subject h4 {
            color: #ffffff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.4;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .aspiration-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }

        .aspiration-info span {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #c0c0c0;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .aspiration-info i {
            color: #00a653;
            font-size: 0.8rem;
        }

        .author-name {
            font-weight: 600;
            color: #e0e0e0 !important;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge.approved {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #006738;
        }

        .forum-card-body {
            padding: 0 30px 25px;
        }

        .message-preview,
        .message-full {
            color: #d0d0d0;
            line-height: 1.7;
            font-size: 1rem;
            margin-bottom: 15px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .toggle-message-btn {
            background: none;
            border: none;
            color: #00a653;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 0;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .toggle-message-btn:hover {
            color: #ffffff;
            transform: translateX(5px);
        }

        .toggle-message-btn i {
            transition: transform 0.3s ease;
        }

        .toggle-message-btn.expanded i {
            transform: rotate(180deg);
        }

        .forum-card-footer {
            padding: 20px 30px;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #333333;
        }

        .time-ago {
            color: #a0a0a0;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .forum-action-btn {
            background: rgba(0, 103, 56, 0.2);
            border: 1px solid #006738;
            color: #00a653;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .forum-action-btn:hover {
            background: #006738;
            color: #ffffff;
            border-color: #00a653;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-forum {
            text-align: center;
            padding: 60px 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .empty-icon {
            font-size: 4rem;
            color: #444444;
            margin-bottom: 25px;
        }

        .empty-forum h3 {
            color: #d0d0d0;
            font-size: 1.8rem;
            margin-bottom: 15px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .empty-forum p {
            color: #a0a0a0;
            font-size: 1.1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Call to Action */
        .forum-cta {
            background: linear-gradient(135deg, #006738, #00a653);
            color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border: 1px solid #333333;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .forum-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .cta-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .forum-cta h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .forum-cta p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #e8f5e8;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            color: #006738;
            padding: 15px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            color: #004d27;
        }

        .cta-illustration {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }

        /* Pagination */
        .forum-pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .forum-pagination .pagination {
            gap: 5px;
        }

        .forum-pagination .page-link {
            color: #00a653;
            background: rgba(26, 8, 61, 0.9);
            border: 1px solid #333333;
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .forum-pagination .page-link:hover {
            background: #006738;
            color: #ffffff;
            border-color: #00a653;
            transform: translateY(-1px);
        }

        .forum-pagination .page-item.active .page-link {
            background: #006738;
            border-color: #00a653;
            color: #ffffff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .forum-card-header {
                flex-direction: column;
                gap: 15px;
            }

            .aspiration-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .forum-card-footer {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .forum-cta {
                flex-direction: column;
                text-align: center;
                gap: 30px;
            }

            .cta-illustration {
                order: -1;
            }

            .aspiration-forum-card {
                margin: 0 15px;
            }

            .forum-stat-card {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
    </style>

    <script>
        function toggleMessage(aspirationId) {
            const fullMessage = document.getElementById(`full-${aspirationId}`);
            const toggleBtn = fullMessage.parentElement.querySelector('.toggle-message-btn');
            const toggleText = toggleBtn.querySelector('.toggle-text');
            const toggleIcon = toggleBtn.querySelector('i');
            const preview = fullMessage.parentElement.querySelector('.message-preview');

            if (fullMessage.style.display === 'none') {
                fullMessage.style.display = 'block';
                preview.style.display = 'none';
                toggleText.textContent = 'Tampilkan Lebih Sedikit';
                toggleBtn.classList.add('expanded');
            } else {
                fullMessage.style.display = 'none';
                preview.style.display = 'block';
                toggleText.textContent = 'Baca Selengkapnya';
                toggleBtn.classList.remove('expanded');
            }
        }

        function shareAspiration(subject) {
            if (navigator.share) {
                navigator.share({
                    title: `Aspirasi: ${subject}`,
                    text: `Lihat aspirasi menarik dari mahasiswa Teknik Komputer: ${subject}`,
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(`${window.location.href} - Aspirasi: ${subject}`).then(() => {
                    alert('Link berhasil disalin ke clipboard!');
                });
            }
        }

        // Smooth animations on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.aspiration-forum-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@endsection
