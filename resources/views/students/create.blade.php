@extends('layouts.main')

@section('content')
    <style>
        .registration-page {
            background: #0B1215;
            min-height: 100vh;
            padding-top: 150px;
            padding-bottom: 80px;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(15px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .form-section {
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            border-left: 4px solid #006738;
        }

        .section-title {
            color: #006738;
            font-weight: 700;
            margin-bottom: 25px;
            font-family: "Play", sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
        }

        .form-control-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #ffffff;
            padding: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #006738;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(0, 103, 56, 0.25);
        }

        .form-control-custom::placeholder {
            color: #adadad;
        }

        .form-label-custom {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .file-upload-area {
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.05);
        }

        .file-upload-area:hover {
            border-color: #006738;
            background: rgba(0, 103, 56, 0.1);
        }

        .btn-submit {
            background: linear-gradient(45deg, #006738, #00a651);
            border: none;
            color: #ffffff;
            padding: 18px 40px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 103, 56, 0.3);
            width: 100%;
            margin-top: 30px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 103, 56, 0.4);
            background: linear-gradient(45deg, #00a651, #006738);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            transform: none;
            cursor: not-allowed;
        }

        .skill-input-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 15px;
            min-height: 60px;
        }

        .skill-tag {
            background: #006738;
            color: #ffffff;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .skill-tag .remove-skill {
            cursor: pointer;
            font-weight: bold;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .skill-tag .remove-skill:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .skill-input {
            border: none;
            background: transparent;
            color: #ffffff;
            outline: none;
            flex-grow: 1;
            min-width: 150px;
            padding: 8px;
            font-size: 16px;
        }

        .skill-input::placeholder {
            color: #adadad;
        }

        .form-help-text {
            color: #adadad;
            font-size: 14px;
            margin-top: 8px;
            line-height: 1.4;
        }

        .required-field::after {
            content: " *";
            color: #ff6b6b;
            font-weight: bold;
        }

        .file-preview {
            margin-top: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: none;
        }

        .file-preview img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 10px;
            object-fit: cover;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-header h1 {
            color: #ffffff;
            font-family: "Play", sans-serif;
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .page-header p {
            color: #adadad;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-elements::before {
            content: '';
            position: absolute;
            top: 20%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: rgba(0, 103, 56, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-elements::after {
            content: '';
            position: absolute;
            top: 60%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: rgba(0, 103, 56, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 768px) {
            .registration-page {
                padding-top: 120px;
                padding-bottom: 60px;
            }

            .form-card {
                padding: 25px;
            }

            .form-section {
                padding: 20px;
            }

            .page-header h1 {
                font-size: 2.2rem;
            }
        }
    </style>

    <div class="registration-page">
        <div class="floating-elements"></div>

        <div class="container">
            <!-- Header -->
            <div class="page-header">
                <h1>Pendaftaran Mahasiswa</h1>
                <p>Bergabunglah dengan database mahasiswa Teknik Komputer UNAND. Isi formulir di bawah dengan lengkap dan
                    benar.</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success"
                            style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #ffffff; border-radius: 15px; padding: 20px;">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger"
                            style="background: rgba(231, 74, 59, 0.2); border: 1px solid #e74a3b; color: #ffffff; border-radius: 15px; padding: 20px;">
                            <h6><i class="fas fa-exclamation-triangle"></i> Ada kesalahan dalam formulir:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-card">
                        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data"
                            id="registrationForm">
                            @csrf

                            <!-- Section 1: Informasi Dasar -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user"></i> Informasi Dasar
                                </h4>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom required-field">Nama Lengkap</label>
                                        <input type="text" name="full_name" class="form-control form-control-custom"
                                            placeholder="Masukkan nama lengkap Anda" value="{{ old('full_name') }}"
                                            required>
                                        @error('full_name')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom required-field">NIM</label>
                                        <input type="text" name="nim" class="form-control form-control-custom"
                                            placeholder="Contoh: 2211513024" value="{{ old('nim') }}" required>
                                        @error('nim')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom required-field">Email</label>
                                        <input type="email" name="email" class="form-control form-control-custom"
                                            placeholder="email@example.com" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Nomor Telepon</label>
                                        <input type="text" name="phone" class="form-control form-control-custom"
                                            placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label-custom required-field">Angkatan</label>
                                        <input type="text" name="batch" class="form-control form-control-custom"
                                            placeholder="Contoh: 2022" value="{{ old('batch') }}" required>
                                        @error('batch')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label-custom">Jenis Kelamin</label>
                                        <select name="gender" class="form-control form-control-custom">
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label-custom">Tanggal Lahir</label>
                                        <input type="date" name="birth_date" class="form-control form-control-custom"
                                            value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label-custom">Asal Daerah</label>
                                        <input type="text" name="hometown" class="form-control form-control-custom"
                                            placeholder="Contoh: Padang, Sumatera Barat" value="{{ old('hometown') }}">
                                        @error('hometown')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Foto & Dokumen -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-camera"></i> Foto & Dokumen
                                </h4>

                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label-custom required-field">Foto Baju Kerja Himatekom</label>
                                        <div class="form-help-text mb-2">
                                            Wajib, akan ditampilkan sebagai cover
                                        </div>
                                        <div class="file-upload-area"
                                            onclick="document.getElementById('work_photo').click()">
                                            <i class="fas fa-camera fa-2x text-muted mb-3"></i>
                                            <p class="text-white mb-2">Klik untuk upload foto</p>
                                            <p class="text-muted small">Format: JPG, PNG (Max: 5MB)</p>
                                        </div>
                                        <input type="file" id="work_photo" name="work_photo" accept="image/*"
                                            style="display: none;" required>
                                        <div class="file-preview" id="work_photo_preview"></div>
                                        @error('work_photo')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label-custom">Foto Bebas</label>
                                        <div class="form-help-text mb-2">
                                            Opsional, supaya tambah keren
                                        </div>
                                        <div class="file-upload-area"
                                            onclick="document.getElementById('casual_photo').click()">
                                            <i class="fas fa-user fa-2x text-muted mb-3"></i>
                                            <p class="text-white mb-2">Klik untuk upload foto</p>
                                            <p class="text-muted small">Format: JPG, PNG (Max: 5MB)</p>
                                        </div>
                                        <input type="file" id="casual_photo" name="casual_photo" accept="image/*"
                                            style="display: none;" required>
                                        <div class="file-preview" id="casual_photo_preview"></div>
                                        @error('casual_photo')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label-custom required-field">KRS / KTM</label>
                                        <div class="form-help-text mb-2">
                                            Upload KRS atau KTM untuk validasi
                                        </div>
                                        <div class="file-upload-area"
                                            onclick="document.getElementById('validation_document').click()">
                                            <i class="fas fa-file-alt fa-2x text-muted mb-3"></i>
                                            <p class="text-white mb-2">Klik untuk upload</p>
                                            <p class="text-muted small">JPG, PNG, PDF (Max: 10MB)</p>
                                        </div>
                                        <input type="file" id="validation_document" name="validation_document"
                                            accept="image/*,application/pdf" style="display: none;" required>
                                        <div class="file-preview" id="validation_document_preview"></div>
                                        @error('validation_document')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Keahlian & Minat -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-code"></i> Keahlian & Minat
                                </h4>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-custom">Keahlian</label>
                                        <div class="form-help-text mb-2">
                                            Ketik keahlian dan tekan Enter untuk menambahkan
                                        </div>
                                        <div class="skill-input-container" id="skillsContainer">
                                            <input type="text" class="skill-input"
                                                placeholder="Contoh: HTML, CSS, JavaScript..." id="skillInput">
                                        </div>
                                        <input type="hidden" name="skills" id="skillsHidden">
                                        @error('skills')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-custom">Hobi</label>
                                        <div class="form-help-text mb-2">
                                            Ketik hobi dan tekan Enter untuk menambahkan
                                        </div>
                                        <div class="skill-input-container" id="hobbiesContainer">
                                            <input type="text" class="skill-input"
                                                placeholder="Contoh: Membaca, Gaming, Olahraga..." id="hobbyInput">
                                        </div>
                                        <input type="hidden" name="hobbies" id="hobbiesHidden">
                                        @error('hobbies')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Tujuan Karir</label>
                                        <input type="text" name="career_goal" class="form-control form-control-custom"
                                            placeholder="Contoh: Full Stack Developer" value="{{ old('career_goal') }}">
                                        @error('career_goal')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Pekerjaan Saat Ini</label>
                                        <input type="text" name="current_job" class="form-control form-control-custom"
                                            placeholder="Kosongkan jika tidak bekerja" value="{{ old('current_job') }}">
                                        @error('current_job')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label-custom">Bio Singkat</label>
                                        <textarea name="bio" class="form-control form-control-custom" rows="4"
                                            placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio') }}</textarea>
                                        @error('bio')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Media Sosial & Portfolio -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-share-alt"></i> Media Sosial & Portfolio
                                </h4>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">Instagram</label>
                                        <input type="url" name="instagram" class="form-control form-control-custom"
                                            placeholder="https://instagram.com/username" value="{{ old('instagram') }}">
                                        @error('instagram')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">LinkedIn</label>
                                        <input type="url" name="linkedin" class="form-control form-control-custom"
                                            placeholder="https://linkedin.com/in/username" value="{{ old('linkedin') }}">
                                        @error('linkedin')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">TikTok</label>
                                        <input type="url" name="tiktok" class="form-control form-control-custom"
                                            placeholder="https://tiktok.com/@username" value="{{ old('tiktok') }}">
                                        @error('tiktok')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom">GitHub</label>
                                        <input type="url" name="github" class="form-control form-control-custom"
                                            placeholder="https://github.com/username" value="{{ old('github') }}">
                                        @error('github')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label-custom">Portfolio Website</label>
                                        <input type="url" name="portfolio_url"
                                            class="form-control form-control-custom"
                                            placeholder="https://yourportfolio.com" value="{{ old('portfolio_url') }}">
                                        @error('portfolio_url')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="alert"
                                    style="background: rgba(0, 103, 56, 0.1); border: 1px solid #006738; color: #ffffff; border-radius: 15px; padding: 20px;">
                                    <h6 style="color: #e74a3b; margin-bottom:10px;"><i class="fas fa-info-circle"></i>
                                        Informasi Penting</h6>
                                    <ul>
                                        <li>Data akan direview oleh admin sebelum ditampilkan di website</li>
                                        <li>Pastikan semua informasi yang dimasukkan benar dan valid</li>
                                        <li>Foto dan dokumen harus jelas dan dapat dibaca</li>
                                        <li>Akan sulit untuk merubah data dikemudian hari (Harus melalui admin), sehingga
                                            pastikan semua benar terlebih dahulu</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="fas fa-paper-plane"></i> Daftar Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript - LENGKAP SAMPAI SELESAI -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Simple registration form loaded');

            const skills = [];
            const hobbies = [];

            // File upload handler - LENGKAP
            function setupFileUpload(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                if (input && preview) {
                    input.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const maxSize = inputId === 'validation_document' ? 10 * 1024 * 1024 : 5 *
                                1024 * 1024;
                            if (file.size > maxSize) {
                                alert(
                                    `File terlalu besar. Maksimal ${inputId === 'validation_document' ? '10MB' : '5MB'}.`
                                );
                                this.value = '';
                                preview.style.display = 'none';
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.innerHTML = `
                                    <div class="d-flex align-items-center gap-3">
                                        ${file.type.startsWith('image/') ?
                                            `<img src="${e.target.result}" alt="Preview">` :
                                            `<i class="fas fa-file-pdf fa-3x text-danger"></i>`
                                        }
                                        <div>
                                            <h6 class="text-white mb-1">${file.name}</h6>
                                            <p class="text-muted mb-0">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeFile('${inputId}')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                `;
                                preview.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            }

            // Global remove file function - LENGKAP
            window.removeFile = function(inputId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(inputId + '_preview');
                if (input) input.value = '';
                if (preview) preview.style.display = 'none';
            };

            // Setup file uploads - LENGKAP
            setupFileUpload('work_photo', 'work_photo_preview');
            setupFileUpload('casual_photo', 'casual_photo_preview');
            setupFileUpload('validation_document', 'validation_document_preview');

            // Skills input handler - LENGKAP
            function setupTagInput(inputId, containerId, hiddenId, array) {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            const value = this.value.trim();
                            if (value && !array.includes(value)) {
                                array.push(value);
                                updateTagDisplay(containerId, array, hiddenId);
                                document.getElementById(hiddenId).value = JSON.stringify(array);
                                this.value = '';
                            }
                        }
                    });

                    // Also handle comma separation - LENGKAP
                    input.addEventListener('input', function(e) {
                        const value = this.value;
                        if (value.includes(',')) {
                            const tags = value.split(',').map(tag => tag.trim()).filter(tag => tag);
                            tags.forEach(tag => {
                                if (tag && !array.includes(tag)) {
                                    array.push(tag);
                                }
                            });
                            updateTagDisplay(containerId, array, hiddenId);
                            document.getElementById(hiddenId).value = JSON.stringify(array);
                            this.value = '';
                        }
                    });
                }
            }

            // Update tag display function - LENGKAP
            function updateTagDisplay(containerId, array, hiddenId) {
                const container = document.getElementById(containerId);
                if (!container) return;

                const placeholder = containerId === 'skillsContainer' ? 'Tambah keahlian...' : 'Tambah hobi...';
                const inputId = containerId === 'skillsContainer' ? 'skillInput' : 'hobbyInput';

                const tags = array.map((item, index) => `
                    <span class="skill-tag">
                        ${item}
                        <span class="remove-skill" onclick="removeTag(${index}, '${containerId}', '${hiddenId}')">&times;</span>
                    </span>
                `).join('');

                container.innerHTML = tags +
                    `<input type="text" class="skill-input" placeholder="${placeholder}" id="${inputId}">`;

                // Re-setup event listener for new input - LENGKAP
                setupTagInput(inputId, containerId, hiddenId, array);
            }

            // Global remove tag function - LENGKAP
            window.removeTag = function(index, containerId, hiddenId) {
                const array = containerId === 'skillsContainer' ? skills : hobbies;
                array.splice(index, 1);
                document.getElementById(hiddenId).value = JSON.stringify(array);
                updateTagDisplay(containerId, array, hiddenId);
            };

            // Setup tag inputs - LENGKAP
            setupTagInput('skillInput', 'skillsContainer', 'skillsHidden', skills);
            setupTagInput('hobbyInput', 'hobbiesContainer', 'hobbiesHidden', hobbies);

            // Form submission - LENGKAP
            const form = document.getElementById('registrationForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Update hidden fields
                    document.getElementById('skillsHidden').value = JSON.stringify(skills);
                    document.getElementById('hobbiesHidden').value = JSON.stringify(hobbies);

                    // Show loading state
                    const submitBtn = document.getElementById('submitBtn');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim Data...';
                    submitBtn.disabled = true;

                    // Re-enable if there's an error (form doesn't submit)
                    setTimeout(() => {
                        if (submitBtn.disabled) {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }
                    }, 10000);

                    console.log('📤 Form submitted with skills:', skills, 'hobbies:', hobbies);
                });
            }

            // Smooth scroll to form sections on error - LENGKAP
            if (window.location.hash) {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }

            // Auto-resize textareas - LENGKAP
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            });

            // Animate form sections on scroll - LENGKAP
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeIn 0.6s ease forwards';
                    }
                });
            });

            document.querySelectorAll('.form-section').forEach(section => {
                observer.observe(section);
            });

            // Add focus effects to inputs - LENGKAP
            document.querySelectorAll('.form-control-custom').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            console.log('✅ Registration form initialized successfully - COMPLETE!');
        });
    </script>
@endsection
