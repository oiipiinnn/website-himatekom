@extends('admin.layouts.app')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota - ' . $member->student->full_name)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-outline-info">
            <i class="fas fa-eye"></i> Lihat Detail
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

        .student-info-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
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

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
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
    </style>

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

    <form method="POST" action="{{ route('admin.members.update', $member) }}" id="memberForm">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Current Student Info -->
                <div class="student-info-card">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $member->student->casual_photo_url }}" alt="Student Photo" class="student-avatar">
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-2"><i class="fas fa-link"></i> Data Mahasiswa Terhubung</h5>
                            <h4 class="mb-1">{{ $member->student->full_name }}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>NIM:</strong> {{ $member->student->nim }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $member->student->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Angkatan:</strong> {{ $member->student->batch }}</p>
                                    <p class="mb-1"><strong>Phone:</strong>
                                        {{ $member->student->phone ?: 'Tidak tersedia' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="btn-group-vertical">
                                <a href="{{ route('admin.students.show', $member->student) }}"
                                    class="btn btn-light btn-sm mb-2">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <button type="button" class="btn btn-outline-light btn-sm" onclick="syncFromStudent()">
                                    <i class="fas fa-sync"></i> Sync
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Option to Change Student -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-exchange-alt"></i> Ganti Mahasiswa (Opsional)
                    </h5>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="changeStudent" name="change_student">
                        <label class="form-check-label" for="changeStudent">
                            Ganti ke mahasiswa lain
                        </label>
                        <small class="d-block text-muted">Centang jika ingin menghubungkan ke mahasiswa yang berbeda</small>
                    </div>

                    <div id="studentSelection" style="display: none;">
                        <div class="student-search-container">
                            <input type="text" id="studentSearch" class="form-control form-control-custom"
                                placeholder="Cari mahasiswa..." autocomplete="off">
                            <div class="student-search-results" id="searchResults"></div>
                        </div>

                        <div id="newStudentPreview" class="mt-3" style="display: none;">
                            <div class="alert alert-info">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img id="previewPhoto" src="" alt="Student Photo" class="img-thumbnail"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="mb-1" id="previewName"></h6>
                                        <small id="previewDetails"></small>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="clearNewStudent()">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="student_id" id="studentId" value="{{ $member->student_id }}">
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
                                value="{{ old('position', $member->position) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Divisi</label>
                            <select name="division_id" class="form-control form-control-custom" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        {{ old('division_id', $member->division_id) == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required-field">Level Posisi</label>
                            <select name="position_level" class="form-control form-control-custom" required>
                                <option value="">-- Pilih Level --</option>
                                @foreach ($positionLevels as $level => $label)
                                    <option value="{{ $level }}"
                                        {{ old('position_level', $member->position_level) == $level ? 'selected' : '' }}>
                                        Level {{ $level }} - {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mulai Menjabat</label>
                            <input type="date" name="start_date" class="form-control form-control-custom"
                                value="{{ old('start_date', $member->start_date ? $member->start_date->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Berakhir Menjabat</label>
                            <input type="date" name="end_date" class="form-control form-control-custom"
                                value="{{ old('end_date', $member->end_date ? $member->end_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Additional Info -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-edit"></i> Informasi Tambahan
                    </h5>

                    <div class="form-group mb-3">
                        <label class="form-label">Motivasi Bergabung</label>
                        <textarea name="motivation" class="form-control form-control-custom" rows="4">{{ old('motivation', $member->motivation) }}</textarea>
                        <small class="text-muted">Motivasi bergabung sebagai pengurus</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="notes" class="form-control form-control-custom" rows="3">{{ old('notes', $member->notes) }}</textarea>
                        <small class="text-muted">Catatan internal admin</small>
                    </div>
                </div>

                <!-- Status -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-cog"></i> Status & Pengaturan
                    </h5>

                    <div class="form-group mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-control-custom">
                            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                            <option value="alumni" {{ old('status', $member->status) == 'alumni' ? 'selected' : '' }}>
                                Alumni</option>
                        </select>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            <strong>Pengurus Aktif</strong>
                        </label>
                        <br><small class="text-muted">Centang jika aktif menjalankan tugas</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-section">
                    <button type="submit" class="btn-submit w-100 mb-3">
                        <i class="fas fa-save"></i> Update Anggota
                    </button>

                    <div class="btn-group w-100 mb-2">
                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changeStudentCheckbox = document.getElementById('changeStudent');
            const studentSelection = document.getElementById('studentSelection');
            const studentSearch = document.getElementById('studentSearch');
            const searchResults = document.getElementById('searchResults');
            const newStudentPreview = document.getElementById('newStudentPreview');
            const studentIdInput = document.getElementById('studentId');

            let searchTimeout;
            let selectedNewStudent = null;

            // Toggle student selection
            changeStudentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    studentSelection.style.display = 'block';
                } else {
                    studentSelection.style.display = 'none';
                    clearNewStudent();
                    studentIdInput.value = '{{ $member->student_id }}'; // Reset to original
                }
            });

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
                        <div class="student-search-item" onclick="selectNewStudent(${JSON.stringify(student).replace(/"/g, '&quot;')})">
                            <img src="${student.photo}" alt="${student.name}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${student.name}</h6>
                                <small class="text-muted">${student.nim} - ${student.email}</small>
                            </div>
                        </div>
                    `).join('');
                }
                searchResults.style.display = 'block';
            }

            // Select new student
            window.selectNewStudent = function(student) {
                selectedNewStudent = student;
                studentIdInput.value = student.id;

                document.getElementById('previewPhoto').src = student.photo;
                document.getElementById('previewName').textContent = student.name;
                document.getElementById('previewDetails').textContent = `${student.nim} - ${student.email}`;

                newStudentPreview.style.display = 'block';
                searchResults.style.display = 'none';
                studentSearch.value = student.name;
            };

            // Clear new student selection
            window.clearNewStudent = function() {
                selectedNewStudent = null;
                newStudentPreview.style.display = 'none';
                studentSearch.value = '';
                searchResults.style.display = 'none';
                studentIdInput.value = '{{ $member->student_id }}'; // Reset to original
            };

            // Hide search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.student-search-container')) {
                    searchResults.style.display = 'none';
                }
            });

            // Sync from student
            window.syncFromStudent = function() {
                if (confirm('Sinkronkan data anggota dengan data mahasiswa terbaru?')) {
                    fetch(`{{ route('admin.members.sync-from-student', $member) }}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                location.reload();
                            } else {
                                alert('Terjadi kesalahan saat sinkronisasi data');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat sinkronisasi data');
                        });
                }
            };

            // Form submission
            const form = document.getElementById('memberForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('.btn-submit');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                    submitBtn.disabled = true;
                });
            }
        });
    </script>
@endsection
