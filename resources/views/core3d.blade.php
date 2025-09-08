@extends('layouts.main')

@push('styles')
<style>
/* Ensure navbar stays above core3d content */
.header {
    position: fixed !important;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999 !important;
    background: rgba(0, 0, 0, 0.9) !important;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.header.scrolled {
    background: rgba(0, 0, 0, 0.95) !important;
}
</style>
@endpush

@section('content')
    <style>
        /* CORE 3D Simplified Styles */
        .core3d-hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #000 0%, #1a1a2e 50%, #0f3460 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 140px; /* Increased padding to avoid navbar overlap */
            margin-top: 0;
        }

        .core3d-hero::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23006738" stroke-width="0.5" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, #006738, #22c55e);
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 200px;
            height: 200px;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 15%;
            animation-delay: 2s;
        }

        .orb-3 {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 30%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.1);
            }
        }

        .core3d-content {
            position: relative;
            z-index: 10;
            text-align: center;
        }

        .core3d-logo {
            font-size: 6rem;
            font-weight: 900;
            background: linear-gradient(45deg, #00ff88, #006738, #22c55e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 40px rgba(0, 255, 136, 0.3);
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 40px rgba(0, 255, 136, 0.3);
            }

            to {
                text-shadow: 0 0 60px rgba(0, 255, 136, 0.6);
            }
        }

        .core3d-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
            text-transform: uppercase;
            font-style: italic;
        }

        .core3d-year {
            font-size: 4rem;
            color: #ffffff;
            font-weight: 300;
            letter-spacing: 0.3em;
            margin-bottom: 2rem;
        }

        .core3d-tagline {
            font-size: 1.5rem;
            color: #00ff88;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-bottom: 2rem;
        }

        .core3d-description {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 700px;
            margin: 0 auto 3rem;
            line-height: 1.7;
        }

        /* What's New Section */
        .whats-new {
            background: linear-gradient(180deg, #000 0%, #1a1a2e 100%);
            padding: 5rem 0;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 103, 56, 0.3);
            border-radius: 15px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
            transition: left 0.5s;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #006738;
            box-shadow: 0 20px 40px rgba(0, 103, 56, 0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #006738, #22c55e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .feature-icon i {
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
        }

        .feature-desc {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        /* Legacy Section - Single Year */
        .legacy-section {
            background: #0a0a0a;
            padding: 5rem 0;
            text-align: center;
        }

        .legacy-card {
            background: linear-gradient(145deg, #1a1a2e, #16213e);
            border-radius: 20px;
            padding: 3rem;
            max-width: 600px;
            margin: 3rem auto;
            border-left: 5px solid #006738;
            position: relative;
            overflow: hidden;
        }

        .legacy-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, #006738, transparent);
            opacity: 0.1;
        }

        .legacy-year {
            display: inline-block;
            background: linear-gradient(45deg, #006738, #22c55e);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
        }

        .legacy-title {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .legacy-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            color: #22c55e;
            font-size: 2rem;
            font-weight: bold;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .legacy-desc {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
            font-size: 1.1rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(45deg, #006738, #22c55e);
            padding: 5rem 0;
            text-align: center;
            position: relative;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .cta-desc {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .cta-button:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            text-decoration: none;
        }

        /* Contact Info */
        .contact-info {
            background: #1a1a2e;
            padding: 3rem 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-item {
            text-align: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(0, 103, 56, 0.3);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            border-color: #006738;
            transform: translateY(-5px);
        }

        .contact-icon {
            font-size: 2.5rem;
            color: #22c55e;
            margin-bottom: 1rem;
        }

        .contact-title {
            color: white;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .contact-detail {
            color: rgba(255, 255, 255, 0.7);
        }

        .contact-detail a {
            color: #22c55e;
            text-decoration: none;
        }

        .contact-detail a:hover {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .core3d-hero {
                padding-top: 120px; /* Slightly less padding for mobile */
                min-height: calc(100vh - 60px);
            }
            
            .core3d-logo {
                font-size: 4rem;
            }

            .core3d-year {
                font-size: 2.5rem;
            }
            
            .core3d-tagline {
                font-size: 1.2rem;
            }
            
            .core3d-description {
                font-size: 1rem;
                padding: 0 15px;
            }

            .cta-title {
                font-size: 2rem;
            }

            .legacy-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .contact-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .core3d-hero {
                padding-top: 100px;
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .core3d-logo {
                font-size: 3rem;
            }
            
            .core3d-year {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="core3d-hero">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>

        <div class="container">
            <div class="core3d-content">
                <h1 class="core3d-logo">CORE3D</h1>
                <div class="core3d-subtitle">Computer Engineering Event, Designed Delightfully for Dedication</div>
                <div class="core3d-year">2025</div>
                <div class="core3d-tagline">Innovation • Collaboration • Excellence</div>
                <p class="core3d-description">
                    Event tahunan terbesar Departemen Teknik Komputer FTI UNAND.
                    Kompetisi programming, workshop teknologi terkini, dan networking
                    dengan para profesional industri tech Indonesia.
                </p>
            </div>
        </div>
    </section>

    <!-- What's New Section -->
    <section class="whats-new">
        <div class="container">
            <div class="text-center">
                <h2 style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 1rem;">
                    What's Coming
                </h2>
                <p style="font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto;">
                    Program dan aktivitas yang dirancang untuk mengasah skill dan memperluas network mahasiswa
                </p>
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-code"></i>
                    </div>
                    <h3 class="feature-title">Programming Contest</h3>
                    <p class="feature-desc">
                        Kompetisi programming dengan berbagai kategori: algoritma, web development, dan mobile app
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-brain"></i>
                    </div>
                    <h3 class="feature-title">Tech Workshop</h3>
                    <p class="feature-desc">
                        Workshop hands-on tentang AI, Machine Learning, Cloud Computing, dan teknologi trending
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <h3 class="feature-title">Industry Talk</h3>
                    <p class="feature-desc">
                        Seminar dan diskusi dengan praktisi dari perusahaan teknologi ternama Indonesia
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <h3 class="feature-title">Hackathon</h3>
                    <p class="feature-desc">
                        24 jam non-stop coding marathon untuk menciptakan solusi inovatif masalah nyata
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Legacy Section -->
    <section class="legacy-section">
        <div class="container">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 1rem;">
                Our Beginning
            </h2>

            <div class="legacy-card">
                <div class="legacy-year">2025</div>
                <h3 class="legacy-title">CORE3D: Digital Innovation Challenge</h3>

                <div class="legacy-stats">
                    <div class="stat-item">
                        <span class="stat-number">250+</span>
                        <span class="stat-label">Peserta</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15</span>
                        <span class="stat-label">Universitas</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10</span>
                        <span class="stat-label">Workshop</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10jt+</span>
                        <span class="stat-label">Total Hadiah</span>
                    </div>
                </div>

                <p class="legacy-desc">
                    Tahun pertama CORE3D sukses menyelenggarakan kompetisi programming,
                    UI/UX design challenge, dan hackathon dengan partisipasi mahasiswa dari
                    seluruh Sumatera Barat. Event ini menjadi platform untuk menampilkan
                    talenta muda di bidang teknologi dan memperkenalkan Teknik Komputer UNAND
                    sebagai pusat inovasi digital.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Ready for CORE3D 2025?</h2>
            <p class="cta-desc">
                Bergabunglah dengan ratusan mahasiswa terbaik Indonesia dalam event teknologi
                paling bergengsi di Sumatera Barat!
            </p>
            <a href="#" class="cta-button">
                <i class="fa fa-rocket"></i>
                <span>Cari Tahu Lebih Lanjut</span>
            </a>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="contact-info">
        <div class="container">
            <div class="text-center mb-4">
                <h2 style="font-size: 2rem; font-weight: bold; color: white; margin-bottom: 1rem;">
                    Get In Touch
                </h2>
                <p style="color: rgba(255,255,255,0.7);">
                    Ada pertanyaan? Hubungi tim kami
                </p>
            </div>

            <div class="contact-grid">
                <div class="contact-item">
                    <i class="fab fa-instagram contact-icon"></i>
                    <h4 class="contact-title">Instagram</h4>
                    <p class="contact-detail">
                        <a href="https://www.instagram.com/himatekom_unand/" target="_blank">
                            @himatekom_unand
                        </a>
                    </p>
                </div>

                <div class="contact-item">
                    <i class="fab fa-linkedin contact-icon"></i>
                    <h4 class="contact-title">LinkedIn</h4>
                    <p class="contact-detail">
                        <a href="https://www.linkedin.com/company/himatekom/" target="_blank">
                            Himatekom UNAND
                        </a>
                    </p>
                </div>

                <div class="contact-item">
                    <i class="fa fa-envelope contact-icon"></i>
                    <h4 class="contact-title">Email</h4>
                    <p class="contact-detail">
                        <a href="mailto:himatekom@fti.unand.ac.id">
                            himatekom@fti.unand.ac.id
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
