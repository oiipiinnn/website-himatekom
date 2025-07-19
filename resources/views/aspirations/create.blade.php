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

    <!-- Contact Form Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="contact__form">
                        <h3>Kirim Aspirasi Anda</h3>
                        <p>Sampaikan ide, saran, atau masukan Anda untuk kemajuan Himatekom. Aspirasi Anda akan direview
                            oleh admin sebelum dipublikasikan.</p>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('aspirations.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="name" placeholder="Nama Lengkap *"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" name="email" placeholder="Email *" value="{{ old('email') }}"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" name="nim" placeholder="NIM (Opsional)"
                                        value="{{ old('nim') }}">
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" name="subject" placeholder="Subjek Aspirasi *"
                                        value="{{ old('subject') }}" required>
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="message" placeholder="Tulis aspirasi Anda di sini... *" required>{{ old('message') }}</textarea>
                                    <button type="submit" class="site-btn">Kirim Aspirasi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Form Section End -->

    <style>
        .contact__form {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 10px;
        }

        .contact__form h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .contact__form input,
        .contact__form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .contact__form textarea {
            height: 150px;
            resize: vertical;
        }

        .site-btn {
            background: #006738;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .site-btn:hover {
            background: #004d28;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
@endsection
