@extends('admin.layouts.app')

@section('title', 'Tambah Anggota Pengurus')
@section('page-title', 'Tambah Anggota Pengurus')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.students.index') }}?status=approved" class="btn btn-outline-info">
            <i class="fas fa-users"></i> Lihat Data Mahasiswa
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

        .student-selection-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
        }

        .student-search-container {
            position: relative;
        }

        .student-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .student-search-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #333;
        }

        .student-search-item:hover {
            background: #f8f9fa;
        }

        .student-search-item:last-child {
            border-bottom: none;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .selected-student-card {
            background: #d4edda;
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 20px;
            margin-top: 15px;
            display: none;
        }

        .selected-student-card.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .btn-submit:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: none;
        }

        .required-field::after {
            content: " *";
            color: #e74a3b;
            font-weight: bold;
        }

        .info-note {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="info-note">
                <h6><i class="fas fa-info-circle text-info"></i> Tambah Anggota Pengurus</h6>
                <p class="mb-0">Pilih mahasiswa yang sudah terdaftar untuk dijadikan anggota pengurus.
                    Data pribadi akan otomatis diambil dari data mahasiswa.</p>
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

    @if ($students->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="fas fa-user-slash fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted">Tidak Ada Mahasiswa Tersedia</h4>
                            <p class="text-muted mb-4">
                                Saat ini tidak ada mahasiswa yang tersedia untuk dijadikan anggota pengurus.<br>
                                Mahasiswa harus memiliki status "Approved" dan belum menjadi anggota pengurus.
                            </p>
                            <div class="btn-group">
                                <a href="{{ route('admin.students.index') }}" class="btn btn-primary">
                                    <i class="fas fa-users"></i> Kelola Data Mahasiswa
                                </a>
                                <a href="{{ route('admin.students.index') }}?status=pending"
                                    class="btn btn-outline-warning">
                                    <i class="fas fa-clock"></i> Review Mahasiswa Pending
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('admin.members.store') }}" id="memberForm">
            @csrf

            <div class="row">
                <!-- Left Column - Student Selection -->
                <div class="col-lg-8">
                    <!-- Student Selection -->
                    <div class="student-selection-card">
                        <h5 class="mb-3"><i class="fas fa-search"></i> Pilih Mahasiswa</h5>
                        <p class="mb-3 opacity-75">Ketik nama, NIM, atau email mahasiswa:</p>

                        <div class="student-search-container">
                            <input type="text" id="studentSearch" class="form-control form-control-lg"
                                placeholder="Contoh: Berka Aldizar, 2211513024, atau student@email.com..."
                                autocomplete="off">
                            <div class="student-search-results" id="searchResults"></div>
                        </div>

                        <div class="selected-student-card" id="selectedStudentCard">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <img id="selectedStudentPhoto" src="" alt="Photo"
                                        class="img-thumbnail student-avatar">
                                </div>
                                <div class="col-md-8">
                                    <h6 class="mb-2 text-success"><i class="fas fa-check-circle"></i> Mahasiswa Dipilih</h6>
                                    <h5 class="mb-1 text-dark" id="selectedStudentName"></h5>
                                    <div class="row text-dark">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>NIM:</strong> <span id="selectedStudentNim"></span>
                                            </p>
                                            <p class="mb-1"><strong>Email:</strong> <span
                                                    id="selectedStudentEmail"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Angkatan:</strong> <span
                                                    id="selectedStudentBatch"></span></p>
                                            <p class="mb-1"><strong>Phone:</strong> <span
                                                    id="selectedStudentPhone"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button type="button" class="btn btn-outline-danger" onclick="clearSelectedStudent()">
                                        <i class="fas fa-times"></i> Ganti
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="student_id" id="selectedStudentId" required>
                    </div>

                    <!-- Position & Division -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-crown"></i> Jabatan & Divisi
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Posisi/Jabatan</label>
                                <input type="text" name="position" class="form-control form-control-custom"
                                    placeholder="Contoh: Ketua Himpunan, Wakil Ketua, Sekretaris"
                                    value="{{ old('position') }}" required>
                                <small class="text-muted">Masukkan jabatan lengkap</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Divisi</label>
                                <select name="division_id" class="form-control form-control-custom" required>
                                    <option value="">-- Pilih Divisi --</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih divisi tempat bertugas</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required-field">Level Posisi</label>
                                <select name="position_level" class="form-control form-control-custom" required>
                                    <option value="">-- Pilih Level --</option>
                                    @foreach ($positionLevels as $level => $label)
                                        <option value="{{ $level }}"
                                            {{ old('position_level') == $level ? 'selected' : '' }}>
                                            Level {{ $level }} - {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Level 1 = Tertinggi</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mulai Menjabat</label>
                                <input type="date" name="start_date" class="form-control form-control-custom"
                                    value="{{ old('start_date', date('Y-m-d')) }}">
                                <small class="text-muted">Tanggal mulai jabatan</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Berakhir Menjabat</label>
                                <input type="date" name="end_date" class="form-control form-control-custom"
                                    value="{{ old('end_date') }}">
                                <small class="text-muted">Opsional</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Additional Info -->
                <div class="col-lg-4">
                    <!-- Optional Info -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <i class="fas fa-edit"></i> Informasi Tambahan
                        </h5>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Info:</strong>
                            Data pribadi seperti nama, NIM, email otomatis diambil dari data mahasiswa.
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Motivasi Bergabung</label>
                            <textarea name="motivation" class="form-control form-control-custom" rows="4"
                                placeholder="Motivasi dan alasan bergabung sebagai pengurus...">{{ old('motivation') }}</textarea>
                            <small class="text-muted">Opsional - motivasi bergabung</small>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="notes" class="form-control form-control-custom" rows="3"
                                placeholder="Catatan khusus dari admin...">{{ old('notes') }}</textarea>
                            <small class="text-muted">Opsional - catatan internal</small>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control form-control-custom">
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Pengurus Aktif</strong>
                            </label>
                            <br><small class="text-muted">Centang jika aktif menjalankan tugas</small>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-section">
                        <button type="submit" class="btn-submit w-100" id="submitBtn" disabled>
                            <i class="fas fa-save"></i> Simpan Anggota Pengurus
                        </button>
                        <small class="text-muted mt-2 d-block text-center">Pilih mahasiswa terlebih dahulu</small>

                        <div class="mt-3">
                            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentSearch = document.getElementById('studentSearch');
            const searchResults = document.getElementById('searchResults');
            const selectedStudentCard = document.getElementById('selectedStudentCard');
            const submitBtn = document.getElementById('submitBtn');

            let searchTimeout;
            let selectedStudent = null;

            // Student search
            if (studentSearch) {
                studentSearch.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        searchResults.style.display = 'none';
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        searchStudents(query);
                    }, 300);
                });
            }

            function searchStudents(query) {
                fetch(`{{ route('admin.members.search-students') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(students => {
                        displaySearchResults(students);
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResults.innerHTML =
                            '<div class="p-3 text-danger">Terjadi kesalahan saat mencari</div>';
                        searchResults.style.display = 'block';
                    });
            }

            function displaySearchResults(students) {
                if (students.length === 0) {
                    searchResults.innerHTML = '<div class="p-3 text-muted">Tidak ada mahasiswa ditemukan</div>';
                } else {
                    searchResults.innerHTML = students.map(student => `
                        <div class="student-search-item" onclick="selectStudent(${JSON.stringify(student).replace(/"/g, '&quot;')})">
                            <img src="${student.work_photo}" alt="${student.name}" class="student-avatar">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${student.name}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">NIM: ${student.nim}</small><br>
                                        <small class="text-muted">Email: ${student.email}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Angkatan: ${student.batch}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-primary">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    `).join('');
                }
                searchResults.style.display = 'block';
            }

            // Select student
            window.selectStudent = function(student) {
                selectedStudent = student;
                document.getElementById('selectedStudentId').value = student.id;
                document.getElementById('selectedStudentPhoto').src = student
                    .work_photo; // CHANGED: work_photo instead of photo
                document.getElementById('selectedStudentName').textContent = student.name;
                document.getElementById('selectedStudentNim').textContent = student.nim;
                document.getElementById('selectedStudentEmail').textContent = student.email;
                document.getElementById('selectedStudentBatch').textContent = student.batch;
                document.getElementById('selectedStudentPhone').textContent = student.phone || 'Tidak tersedia';

                selectedStudentCard.classList.add('show');
                searchResults.style.display = 'none';
                studentSearch.value = student.name;

                // Enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Anggota Pengurus';
            };

            // Clear selection
            window.clearSelectedStudent = function() {
                selectedStudent = null;
                document.getElementById('selectedStudentId').value = '';
                selectedStudentCard.classList.remove('show');
                studentSearch.value = '';
                searchResults.style.display = 'none';

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Pilih Mahasiswa Dulu';
            };

            // Hide search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.student-search-container')) {
                    searchResults.style.display = 'none';
                }
            });

            // Form submission
            const form = document.getElementById('memberForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!selectedStudent) {
                        e.preventDefault();
                        alert('Silakan pilih mahasiswa terlebih dahulu!');
                        return;
                    }

                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                    submitBtn.disabled = true;
                });
            }
        });
    </script>
@endsection
