@extends('layouts.main')
@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Kirim Aspirasi</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <a href="{{ route('aspirations.index') }}">Ruang Aspirasi</a>
                            <span>Kirim Aspirasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Hero Section for Aspiration -->


    <!-- Contact Form Section Begin -->
    <section class="aspiration-form-section">
        <div class="container">
            <div class="row">
                <!-- Form Column -->
                <div class="col-lg-7">
                    <div class="aspiration-form">
                        <div class="form-header">
                            <h3><i class="fas fa-paper-plane"></i> Form Aspirasi</h3>
                            <p>Lengkapi form di bawah ini untuk mengirimkan aspirasi Anda</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <strong>Berhasil!</strong>
                                    <p>{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong>Terjadi Kesalahan!</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('aspirations.store') }}" method="POST" class="modern-form">
                            @csrf
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-user"></i>
                                        Nama Lengkap *
                                    </label>
                                    <input type="text" id="name" name="name"
                                        placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i>
                                        Email *
                                    </label>
                                    <input type="email" id="email" name="email" placeholder="email@example.com"
                                        value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group full-width">
                                    <label for="nim">
                                        <i class="fas fa-id-card"></i>
                                        NIM (Opsional)
                                    </label>
                                    <input type="text" id="nim" name="nim" placeholder="Contoh: 2001234567"
                                        value="{{ old('nim') }}">
                                </div>

                                <div class="form-group full-width">
                                    <label for="subject">
                                        <i class="fas fa-tag"></i>
                                        Subjek Aspirasi *
                                    </label>
                                    <input type="text" id="subject" name="subject"
                                        placeholder="Ringkasan singkat aspirasi Anda" value="{{ old('subject') }}" required>
                                </div>

                                <div class="form-group full-width">
                                    <label for="message">
                                        <i class="fas fa-comment-alt"></i>
                                        Aspirasi Anda *
                                    </label>
                                    <textarea id="message" name="message" placeholder="Sampaikan ide, saran, atau masukan Anda secara detail..." required>{{ old('message') }}</textarea>
                                    <div class="char-counter">
                                        <span id="charCount">0</span> karakter
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="submit-btn">
                                    <i class="fas fa-paper-plane"></i>
                                    Kirim Aspirasi
                                </button>
                                <a href="{{ route('aspirations.index') }}" class="cancel-btn">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-lg-5">
                    <div class="aspiration-info">
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h4>Tips Menulis Aspirasi</h4>
                            <ul>
                                <li><i class="fas fa-check"></i> Gunakan bahasa yang jelas dan sopan</li>
                                <li><i class="fas fa-check"></i> Sertakan konteks yang memadai</li>
                                <li><i class="fas fa-check"></i> Berikan solusi jika memungkinkan</li>
                                <li><i class="fas fa-check"></i> Fokus pada satu topik per aspirasi</li>
                            </ul>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4>Proses Review</h4>
                            <div class="process-steps">
                                <div class="step">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <h5>Aspirasi Dikirim</h5>
                                        <p>Aspirasi Anda masuk ke sistem</p>
                                    </div>
                                </div>
                                <div class="step">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <h5>Review Admin</h5>
                                        <p>Tim admin melakukan peninjauan</p>
                                    </div>
                                </div>
                                <div class="step">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <h5>Publikasi</h5>
                                        <p>Aspirasi yang disetujui akan dipublikasikan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-card contact-card">
                            <div class="info-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h4>Butuh Bantuan?</h4>
                            <p>Jika Anda memiliki pertanyaan tentang proses aspirasi, jangan ragu untuk menghubungi kami.
                            </p>
                            <div class="contact-methods">
                                <a href="mailto:info@himatekom.com" class="contact-method">
                                    <i class="fas fa-envelope"></i>
                                    <span>info@himatekom.com</span>
                                </a>
                                <a href="#" class="contact-method">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>WhatsApp Admin</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Form Section End -->

    <section class="aspiration-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="aspiration-hero__content">
                        <div class="aspiration-hero__icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h2>Suarakan Aspirasi Anda</h2>
                        <p>Setiap ide, saran, dan masukan Anda adalah langkah menuju Himatekom yang lebih baik</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Aspiration Hero Section */
        .aspiration-hero {
            background: linear-gradient(135deg, #006738 0%, #004d27 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .aspiration-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .aspiration-hero__content {
            position: relative;
            z-index: 2;
        }

        .aspiration-hero__icon {
            font-size: 4rem;
            color: #ffffff;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        .aspiration-hero h2 {
            color: #ffffff;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .aspiration-hero p {
            color: #e8f5e8;
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Form Section */
        .aspiration-form-section {
            padding: 80px 0;
            background: #0b1215;
            position: relative;
        }

        .aspiration-form {
            background: rgba(26, 8, 61, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            border: 1px solid #333333;
            backdrop-filter: blur(10px);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .form-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #006738, #00a653);
            border-radius: 2px;
        }

        .form-header h3 {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .form-header h3 i {
            color: #00a653;
            margin-right: 10px;
        }

        .form-header p {
            color: #d0d0d0;
            font-size: 1rem;
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Modern Form Styles */
        .modern-form .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            color: #e0e0e0;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .form-group label i {
            color: #00a653;
            margin-right: 8px;
            width: 16px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #333333;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(0, 0, 0, 0.4);
            color: #ffffff;
            backdrop-filter: blur(5px);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #888888;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #00a653;
            box-shadow: 0 0 0 3px rgba(0, 166, 83, 0.2);
            transform: translateY(-1px);
            background: rgba(0, 0, 0, 0.6);
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
            font-family: inherit;
        }

        .char-counter {
            text-align: right;
            color: #a0a0a0;
            font-size: 0.85rem;
            margin-top: 5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Alert Styles */
        .alert {
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            border: none;
        }

        .alert i {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid #006738;
        }

        .alert-success i {
            color: #28a745;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid #721c24;
        }

        .alert-danger i {
            color: #dc3545;
        }

        .alert strong {
            display: block;
            margin-bottom: 5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert p {
            color: inherit;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .submit-btn,
        .cancel-btn {
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .submit-btn {
            background: linear-gradient(135deg, #006738, #00a653);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 103, 56, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 103, 56, 0.4);
            color: #ffffff;
        }

        .cancel-btn {
            background: rgba(108, 117, 125, 0.3);
            color: #d0d0d0;
            border: 1px solid #6c757d;
        }

        .cancel-btn:hover {
            background: #6c757d;
            transform: translateY(-1px);
            color: #ffffff;
        }

        /* Info Section */
        .aspiration-info {
            padding-left: 30px;
        }

        .info-card {
            background: rgba(26, 8, 61, 0.95);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid #333333;
            transition: transform 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 103, 56, 0.2);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #006738, #00a653);
            color: #ffffff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 103, 56, 0.3);
        }

        .info-card h4 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .info-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-card ul li {
            color: #d0d0d0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .info-card ul li i {
            color: #00a653;
            font-size: 0.8rem;
        }

        .info-card p {
            color: #c0c0c0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Process Steps */
        .process-steps {
            margin-top: 20px;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .step:last-child {
            margin-bottom: 0;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #006738, #00a653);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 103, 56, 0.3);
        }

        .step-content h5 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .step-content p {
            color: #c0c0c0;
            margin: 0;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        /* Contact Methods */
        .contact-methods {
            margin-top: 20px;
        }

        .contact-method {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #00a653;
            text-decoration: none;
            padding: 12px 0;
            border-bottom: 1px solid #333333;
            transition: all 0.3s ease;
        }

        .contact-method:last-child {
            border-bottom: none;
        }

        .contact-method:hover {
            color: #ffffff;
            transform: translateX(5px);
        }

        .contact-method i {
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .aspiration-hero h2 {
                font-size: 2.2rem;
            }

            .aspiration-hero p {
                font-size: 1rem;
            }

            .aspiration-form {
                padding: 25px;
                margin: 0 15px;
            }

            .modern-form .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .aspiration-info {
                padding-left: 0;
                margin-top: 40px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .submit-btn,
            .cancel-btn {
                justify-content: center;
            }
        }
    </style>

    <script>
        // Character counter for textarea
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('message');
            const charCount = document.getElementById('charCount');

            function updateCharCount() {
                const count = textarea.value.length;
                charCount.textContent = count;

                if (count > 500) {
                    charCount.style.color = '#dc3545';
                } else if (count > 300) {
                    charCount.style.color = '#ffc107';
                } else {
                    charCount.style.color = '#6c757d';
                }
            }

            textarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count

            // Form validation enhancement
            const form = document.querySelector('.modern-form');
            const inputs = form.querySelectorAll('input[required], textarea[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.style.borderColor = '#dc3545';
                    } else {
                        this.style.borderColor = '#28a745';
                    }
                });

                input.addEventListener('input', function() {
                    if (this.style.borderColor === 'rgb(220, 53, 69)') { // red
                        this.style.borderColor = '#e9ecef';
                    }
                });
            });

            // Smooth scroll animation for form
            const formSection = document.querySelector('.aspiration-form-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            formSection.style.opacity = '0';
            formSection.style.transform = 'translateY(30px)';
            formSection.style.transition = 'all 0.8s ease';
            observer.observe(formSection);
        });
    </script>
@endsection
