@extends('admin.layouts.app')

@section('title', 'Tambah Mahasiswa Baru')
@section('page-title', 'Tambah Mahasiswa Baru')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
@endsection

@section('content')
    <style>
        .form-section {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #4e73df;
        }

        .section-title {
            color: #4e73df;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
        }

        .form-control-custom {
            border-radius: 8px;
            border: 2px solid #e3e6f0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .file-upload-area {
            border: 2px dashed #d1d3e2;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: #f8f9fc;
        }

        .file-upload-area:hover {
            border-color: #4e73df;
            background: #eef2ff;
        }

        .file-upload-area.dragover {
            border-color: #4e73df;
            background: #eef2ff;
        }

        .skill-input-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            padding: 12px;
            min-height: 50px;
            background: white;
        }

        .skill-tag {
            background: #4e73df;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .skill-tag .remove-skill {
            cursor: pointer;
            font-weight: bold;
            width: 18px;
            height: 18px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .skill-tag .remove-skill:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .skill-input {
            border: none;
            outline: none;
            flex-grow: 1;
            min-width: 120px;
            padding: 5px;
        }

        .file-preview {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
            display: none;
        }

        .file-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            object-fit: cover;
        }

        .btn-submit {
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }

        .required-field::after {
            content: " *";
            color: #e74a3b;
            font-weight: bold;
        }

        .admin-note {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .status-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .status-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-option:hover {
            border-color: #4e73df;
            background: #eef2ff;
        }

        .status-option.selected {
            border-color: #4e73df;
            background: #4e73df;
            color: white;
        }

        .status-option input[type="radio"] {
            margin: 0;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="admin-note">
                <h6><i class="fas fa-info-circle text-info"></i> Catatan Admin</h6>
                <p class="mb-0">Sebagai admin, Anda dapat langsung menambahkan mahasiswa dengan status "Approved" atau
                    "Pending" sesuai kebutuhan. Data yang ditambahkan akan langsung masuk ke database tanpa perlu proses
                    review.</p>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger">
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

    <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" id="adminStudentForm">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Section 1: Informasi Dasar -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-user"></i> Informasi Dasar
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control form-control-custom"
                                placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">NIM</label>
                            <input type="text" name="nim" class="form-control form-control-custom"
                                placeholder="Contoh: 2211513024" value="{{ old('nim') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Email</label>
                            <input type="email" name="email" class="form-control form-control-custom"
                                placeholder="email@example.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control form-control-custom"
                                placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required-field">Angkatan</label>
                            <input type="text" name="batch" class="form-control form-control-custom"
                                placeholder="Contoh: 2021" value="{{ old('batch') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-control form-control-custom">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control form-control-custom"
                                value="{{ old('birth_date') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Asal Daerah</label>
                            <input type="text" name="hometown" class="form-control form-control-custom"
                                placeholder="Contoh: Padang, Sumatera Barat" value="{{ old('hometown') }}">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Keahlian & Minat -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-code"></i> Keahlian & Minat
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Keahlian</label>
                            <small class="text-muted d-block mb-2">Ketik dan tekan Enter untuk menambah</small>
                            <div class="skill-input-container" id="skillsContainer">
                                <input type="text" class="skill-input" placeholder="Contoh: HTML, CSS, JavaScript..."
                                    id="skillInput">
                            </div>
                            <input type="hidden" name="skills" id="skillsHidden">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hobi</label>
                            <small class="text-muted d-block mb-2">Ketik dan tekan Enter untuk menambah</small>
                            <div class="skill-input-container" id="hobbiesContainer">
                                <input type="text" class="skill-input" placeholder="Contoh: Membaca, Gaming..."
                                    id="hobbyInput">
                            </div>
                            <input type="hidden" name="hobbies" id="hobbiesHidden">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tujuan Karir</label>
                            <input type="text" name="career_goal" class="form-control form-control-custom"
                                placeholder="Contoh: Full Stack Developer" value="{{ old('career_goal') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pekerjaan Saat Ini</label>
                            <input type="text" name="current_job" class="form-control form-control-custom"
                                placeholder="Kosongkan jika tidak bekerja" value="{{ old('current_job') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Bio Singkat</label>
                            <textarea name="bio" class="form-control form-control-custom" rows="3"
                                placeholder="Ceritakan sedikit tentang mahasiswa ini...">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Media Sosial -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-share-alt"></i> Media Sosial & Portfolio
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instagram</label>
                            <input type="url" name="instagram" class="form-control form-control-custom"
                                placeholder="https://instagram.com/username" value="{{ old('instagram') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control form-control-custom"
                                placeholder="https://linkedin.com/in/username" value="{{ old('linkedin') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">TikTok</label>
                            <input type="url" name="tiktok" class="form-control form-control-custom"
                                placeholder="https://tiktok.com/@username" value="{{ old('tiktok') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">GitHub</label>
                            <input type="url" name="github" class="form-control form-control-custom"
                                placeholder="https://github.com/username" value="{{ old('github') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Portfolio Website</label>
                            <input type="url" name="portfolio_url" class="form-control form-control-custom"
                                placeholder="https://portfolio.com" value="{{ old('portfolio_url') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Section 4: Foto & Dokumen -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-camera"></i> Foto & Dokumen
                    </h5>

                    <div class="mb-4">
                        <label class="form-label required-field">Foto Baju Kerja Himatekom</label>
                        <div class="file-upload-area" onclick="document.getElementById('work_photo').click()">
                            <i class="fas fa-camera fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Klik untuk upload</p>
                            <small class="text-muted">JPG, PNG (Max: 5MB)</small>
                        </div>
                        <input type="file" id="work_photo" name="work_photo" accept="image/*" style="display: none;"
                            required>
                        <div class="file-preview" id="work_photo_preview"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label required-field">Foto Bebas</label>
                        <div class="file-upload-area" onclick="document.getElementById('casual_photo').click()">
                            <i class="fas fa-user fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Klik untuk upload</p>
                            <small class="text-muted">JPG, PNG (Max: 5MB)</small>
                        </div>
                        <input type="file" id="casual_photo" name="casual_photo" accept="image/*"
                            style="display: none;" required>
                        <div class="file-preview" id="casual_photo_preview"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label required-field">KRS / KTM</label>
                        <div class="file-upload-area" onclick="document.getElementById('validation_document').click()">
                            <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Klik untuk upload</p>
                            <small class="text-muted">JPG, PNG, PDF (Max: 10MB)</small>
                        </div>
                        <input type="file" id="validation_document" name="validation_document"
                            accept="image/*,application/pdf" style="display: none;" required>
                        <div class="file-preview" id="validation_document_preview"></div>
                    </div>
                </div>

                <!-- Section 5: Admin Settings -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-cog"></i> Pengaturan Admin
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Status Mahasiswa</label>
                        <div class="status-options">
                            <label class="status-option" data-status="approved">
                                <input type="radio" name="status" value="approved"
                                    {{ old('status', 'approved') == 'approved' ? 'checked' : '' }}>
                                <i class="fas fa-check-circle"></i>
                                <span>Approved</span>
                            </label>
                            <label class="status-option" data-status="pending">
                                <input type="radio" name="status" value="pending"
                                    {{ old('status') == 'pending' ? 'checked' : '' }}>
                                <i class="fas fa-clock"></i>
                                <span>Pending</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif (dapat login dan akses fitur)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="show_in_public" value="1"
                                id="show_in_public" {{ old('show_in_public', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_public">
                                Tampilkan di halaman publik
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit w-100" id="submitBtn">
                    <i class="fas fa-save"></i> Simpan Mahasiswa
                </button>
            </div>
        </div>
    </form>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Admin student form loaded');

            const skills = [];
            const hobbies = [];

            // File upload handler
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
                                    <div class="d-flex align-items-center">
                                        ${file.type.startsWith('image/') ?
                                            `<img src="${e.target.result}" alt="Preview" class="me-3">` :
                                            `<i class="fas fa-file-pdf fa-3x text-danger me-3"></i>`
                                        }
                                        <div>
                                            <h6 class="mb-1">${file.name}</h6>
                                            <p class="text-muted mb-0">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                            <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeFile('${inputId}')">
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

            // Remove file function
            window.removeFile = function(inputId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(inputId + '_preview');
                if (input) input.value = '';
                if (preview) preview.style.display = 'none';
            };

            // Setup file uploads
            setupFileUpload('work_photo', 'work_photo_preview');
            setupFileUpload('casual_photo', 'casual_photo_preview');
            setupFileUpload('validation_document', 'validation_document_preview');

            // Skills input handler
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

                    // Handle comma separation
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

                setupTagInput(inputId, containerId, hiddenId, array);
            }

            // Remove tag function
            window.removeTag = function(index, containerId, hiddenId) {
                const array = containerId === 'skillsContainer' ? skills : hobbies;
                array.splice(index, 1);
                document.getElementById(hiddenId).value = JSON.stringify(array);
                updateTagDisplay(containerId, array, hiddenId);
            };

            // Setup tag inputs
            setupTagInput('skillInput', 'skillsContainer', 'skillsHidden', skills);
            setupTagInput('hobbyInput', 'hobbiesContainer', 'hobbiesHidden', hobbies);

            // Status option handling
            document.querySelectorAll('.status-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.status-option').forEach(opt => opt.classList.remove(
                        'selected'));
                    this.classList.add('selected');
                    this.querySelector('input[type="radio"]').checked = true;
                });
            });

            // Set initial selected status
            const checkedStatus = document.querySelector('input[name="status"]:checked');
            if (checkedStatus) {
                document.querySelector(`[data-status="${checkedStatus.value}"]`).classList.add('selected');
            }

            // Form submission
            const form = document.getElementById('adminStudentForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Update hidden fields
                    document.getElementById('skillsHidden').value = JSON.stringify(skills);
                    document.getElementById('hobbiesHidden').value = JSON.stringify(hobbies);

                    // Show loading state
                    const submitBtn = document.getElementById('submitBtn');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                    submitBtn.disabled = true;

                    // Re-enable if error
                    setTimeout(() => {
                        if (submitBtn.disabled) {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }
                    }, 10000);

                    console.log('📤 Admin form submitted with skills:', skills, 'hobbies:', hobbies);
                });
            }

            console.log('✅ Admin student form initialized successfully!');
        });
    </script>
@endsection
