@extends('layouts.main')
@section('content')
    <style>
        /* CORE 3D Specific Styles */
        .core3d-hero {
            min-height: 100vh;
            background: linear-gradient(45deg, #000, #1a1a2e, #16213e, #0f3460);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 120px;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: #006738;
            border-radius: 50%;
            opacity: 0.3;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) {
            width: 10px;
            height: 10px;
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 15px;
            height: 15px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 8px;
            height: 8px;
            top: 80%;
            left: 40%;
            animation-delay: 4s;
        }

        .particle:nth-child(4) {
            width: 12px;
            height: 12px;
            top: 30%;
            left: 70%;
            animation-delay: 1s;
        }

        .particle:nth-child(5) {
            width: 6px;
            height: 6px;
            top: 70%;
            left: 20%;
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(120deg);
            }

            66% {
                transform: translateY(10px) rotate(240deg);
            }
        }

        .core3d-logo-container {
            position: relative;
            z-index: 10;
        }

        .core3d-main-logo {
            font-size: 8rem;
            font-weight: 900;
            background: linear-gradient(45deg, #00ff88, #006738, #00ff88, #22c55e);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(0, 255, 136, 0.3);
            animation: textGlow 3s ease-in-out infinite alternate, gradientText 4s ease infinite;
            letter-spacing: 0.1em;
            position: relative;
        }

        @keyframes textGlow {
            from {
                text-shadow: 0 0 30px rgba(0, 255, 136, 0.3);
            }

            to {
                text-shadow: 0 0 60px rgba(0, 255, 136, 0.8), 0 0 80px rgba(0, 255, 136, 0.4);
            }
        }

        @keyframes gradientText {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .core3d-subtitle {
            font-size: 3rem;
            color: #ffffff;
            font-weight: 300;
            letter-spacing: 0.5em;
            margin-top: 1rem;
            opacity: 0.9;
            animation: fadeInUp 2s ease-out;
        }

        .core3d-tagline {
            font-size: 1.5rem;
            color: #00ff88;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-top: 2rem;
            animation: slideInFromBottom 2s ease-out 0.5s both;
        }

        .core3d-description {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 2rem auto;
            line-height: 1.8;
            animation: slideInFromBottom 2s ease-out 1s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Features Section */
        .features-showcase {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #000 100%);
            padding: 6rem 0;
            position: relative;
        }

        .feature-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            background: linear-gradient(145deg, rgba(0, 103, 56, 0.2), rgba(0, 103, 56, 0.1));
            border-color: #006738;
            box-shadow: 0 20px 40px rgba(0, 103, 56, 0.3);
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #006738, #22c55e);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            position: relative;
            overflow: hidden;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            50% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }

            100% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
        }

        .feature-icon i {
            font-size: 2.5rem;
            color: white;
            z-index: 2;
            position: relative;
        }

        .feature-title {
            font-size: 1.75rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        /* Previous Events Section */
        .events-timeline {
            background: #000;
            padding: 6rem 0;
            position: relative;
        }

        .timeline-card {
            background: linear-gradient(145deg, #1a1a2e, #16213e);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid #006738;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .timeline-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(0, 103, 56, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .timeline-card:hover::before {
            transform: translateX(100%);
        }

        .timeline-card:hover {
            transform: translateX(10px);
            border-left-color: #22c55e;
            box-shadow: 0 10px 30px rgba(0, 103, 56, 0.2);
        }

        .event-year {
            display: inline-block;
            background: linear-gradient(45deg, #006738, #22c55e);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .event-title {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .event-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 1rem;
        }

        .event-stat {
            color: #22c55e;
            font-size: 0.9rem;
        }

        .event-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(45deg, #006738, #22c55e, #006738);
            background-size: 300% 300%;
            animation: gradientShift 6s ease infinite;
            padding: 6rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-title {
            font-size: 3.5rem;
            font-weight: bold;
            color: white;
            margin-bottom: 2rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .cta-description {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 800px;
            margin: 0 auto 3rem;
            line-height: 1.7;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 1.5rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .cta-button:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        /* Social Media Section */
        .social-showcase {
            background: linear-gradient(135deg, #1a1a2e 0%, #000 100%);
            padding: 5rem 0;
        }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .social-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-card:hover {
            transform: translateY(-10px);
            text-decoration: none;
            border-color: #006738;
            box-shadow: 0 20px 40px rgba(0, 103, 56, 0.2);
        }

        .social-card.instagram:hover {
            border-color: #e1306c;
            box-shadow: 0 20px 40px rgba(225, 48, 108, 0.2);
        }

        .social-card.linkedin:hover {
            border-color: #0077b5;
            box-shadow: 0 20px 40px rgba(0, 119, 181, 0.2);
        }

        .social-card.twitter:hover {
            border-color: #1da1f2;
            box-shadow: 0 20px 40px rgba(29, 161, 242, 0.2);
        }

        .social-card.youtube:hover {
            border-color: #ff0000;
            box-shadow: 0 20px 40px rgba(255, 0, 0, 0.2);
        }

        .social-icon {
            font-size: 3rem;
            color: white;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }

        .social-card:hover .social-icon {
            color: #006738;
        }

        .social-card.instagram:hover .social-icon {
            color: #e1306c;
        }

        .social-card.linkedin:hover .social-icon {
            color: #0077b5;
        }

        .social-card.twitter:hover .social-icon {
            color: #1da1f2;
        }

        .social-card.youtube:hover .social-icon {
            color: #ff0000;
        }

        .social-handle {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .core3d-main-logo {
                font-size: 4rem;
            }

            .core3d-subtitle {
                font-size: 2rem;
                letter-spacing: 0.2em;
            }

            .core3d-tagline {
                font-size: 1.2rem;
            }

            .core3d-description {
                font-size: 1rem;
            }

            .cta-title {
                font-size: 2.5rem;
            }

            .feature-card {
                padding: 2rem 1rem;
            }

            .social-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Hero Section Begin -->
    <section class="core3d-hero">
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <div class="container">
            <div class="core3d-logo-container text-center">
                <h1 class="core3d-main-logo">CORE 3D</h1>
                <div class="core3d-subtitle">2026</div>
                <div class="core3d-tagline">The Future is Coming</div>
                <p class="core3d-description">
                    Bersiaplah untuk revolusi teknologi terbesar! Event yang akan mengubah landscape tech Indonesia dengan
                    kompetisi, workshop, dan networking yang tak terlupakan.
                </p>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Features Showcase Section Begin -->
    <section class="features-showcase">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 3rem; font-weight: bold; color: white; margin-bottom: 1rem;">
                    What Awaits You
                </h2>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto;">
                    Pengalaman teknologi yang akan mengubah perspektif dan masa depan karir kamu
                </p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-trophy"></i>
                        </div>
                        <h3 class="feature-title">Epic Competitions</h3>
                        <p class="feature-description">
                            Programming marathons, UI/UX battles, dan cybersecurity challenges dengan hadiah fantastis
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <h3 class="feature-title">Future Tech Workshops</h3>
                        <p class="feature-description">
                            AI, Blockchain, IoT, dan teknologi cutting-edge langsung dari para pionir industri
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <h3 class="feature-title">Elite Networking</h3>
                        <p class="feature-description">
                            Bertemu dengan CEO startup, venture capitalists, dan tech leaders dari seluruh Asia
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <h3 class="feature-title">Innovation Showcase</h3>
                        <p class="feature-description">
                            Platform untuk menampilkan ide revolusioner dan mendapat funding dari investor
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features Showcase Section End -->

    <!-- Previous Events Timeline Section Begin -->
    <section class="events-timeline">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 3rem; font-weight: bold; color: white; margin-bottom: 1rem;">
                    Our Legacy
                </h2>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.7);">
                    Perjalanan CORE 3D dalam menciptakan generasi tech leaders
                </p>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="timeline-card">
                        <div class="event-year">2024</div>
                        <h3 class="event-title">Innovation Summit</h3>
                        <div class="event-stats">
                            <span class="event-stat">📅 Mar 15, 2024</span>
                            <span class="event-stat">👥 500+ Peserta</span>
                        </div>
                        <p class="event-description">
                            Era AI dimulai di sini. Workshop machine learning intensif dan kompetisi data science yang
                            menghasilkan 3 startup unicorn.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="timeline-card">
                        <div class="event-year">2023</div>
                        <h3 class="event-title">Tech Revolution</h3>
                        <div class="event-stats">
                            <span class="event-stat">📅 Apr 20, 2023</span>
                            <span class="event-stat">👥 400+ Peserta</span>
                        </div>
                        <p class="event-description">
                            Blockchain breakthrough! Event yang melahirkan platform DeFi pertama di Indonesia dan 50+ NFT
                            projects.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="timeline-card">
                        <div class="event-year">2022</div>
                        <h3 class="event-title">Digital Genesis</h3>
                        <div class="event-stats">
                            <span class="event-stat">📅 May 10, 2022</span>
                            <span class="event-stat">👥 300+ Peserta</span>
                        </div>
                        <p class="event-description">
                            Awal mula revolusi. Event perdana yang mengubah mindset mahasiswa tentang teknologi dan
                            entrepreneurship.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Previous Events Timeline Section End -->

    <!-- Call To Action Section Begin -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Make History?</h2>
                <p class="cta-description">
                    CORE 3D 2026 akan menjadi event teknologi paling revolusioner yang pernah ada.
                    Bergabunglah dengan para visioner dan shape the future of technology in Indonesia!
                </p>
                <a href="#" class="cta-button">
                    <i class="fa fa-rocket" style="font-size: 1.5rem;"></i>
                    <span>JOIN THE REVOLUTION</span>
                </a>
            </div>
        </div>
    </section>
    <!-- Call To Action Section End -->

    <!-- Social Media Showcase Section Begin -->
    <section class="social-showcase">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 1rem;">
                    Stay in the Loop
                </h2>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.7);">
                    Follow our journey and be the first to know about exclusive updates
                </p>
            </div>

            <div class="social-grid">
                <a href="#" class="social-card instagram">
                    <i class="fab fa-instagram social-icon"></i>
                    <div class="social-handle">@himatekom_unand</div>
                </a>

                <a href="#" class="social-card linkedin">
                    <i class="fab fa-linkedin social-icon"></i>
                    <div class="social-handle">Himatekom UNAND</div>
                </a>

                <a href="#" class="social-card twitter">
                    <i class="fab fa-twitter social-icon"></i>
                    <div class="social-handle">@himatekom_unand</div>
                </a>

                <a href="#" class="social-card youtube">
                    <i class="fab fa-youtube social-icon"></i>
                    <div class="social-handle">Himatekom UNAND</div>
                </a>
            </div>
        </div>
    </section>
    <!-- Social Media Showcase Section End -->
@endsection
