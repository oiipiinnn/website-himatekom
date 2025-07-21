@extends('layouts.main')

@section('content')
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad set-bg" data-setbg="{{ asset('img/breadcrump-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Data Mahasiswa</h2>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <span>Data Mahasiswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Data Mahasiswa Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Warga Himatekom</span>
                        <h2>Teknik Komputer UNAND</h2>
                        <p>Temukan dan kenali mahasiswa Teknik Komputer Universitas Andalas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Data Mahasiswa Section End -->

    <!-- Counter Section Begin -->
    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;" class="counter spad">
        <div class="container">
            <div class="counter__content">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-1.png') }}" alt="">
                                <h2 class="counter_num">{{ $students->total() }}</h2>
                                <p>Total Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item second__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-2.png') }}" alt="">
                                <h2 class="counter_num">{{ count($batches) }}</h2>
                                <p>Angkatan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item third__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-3.png') }}" alt="">
                                <h2 class="counter_num">{{ count($skills) }}</h2>
                                <p>Skills Unik</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter__item four__item">
                            <div class="counter__item__text">
                                <img src="{{ asset('img/icons/ci-4.png') }}" alt="">
                                <a href="{{ route('students.create') }}" class="primary-btn">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- Filter Section Begin -->
    <section class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Pencarian & Filter</span>
                        <h2>Temukan Mahasiswa</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-form">
                        <form method="GET" action="{{ route('students.index') }}">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="search" placeholder="Cari nama, NIM, atau email..."
                                            value="{{ request('search') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <select name="batch" class="form-control">
                                            <option value="">Semua Angkatan</option>
                                            @foreach ($batches as $batch)
                                                <option value="{{ $batch }}"
                                                    {{ request('batch') == $batch ? 'selected' : '' }}>
                                                    Angkatan {{ $batch }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <select name="skill" class="form-control">
                                            <option value="">Semua Keahlian</option>
                                            @foreach ($skills as $skill)
                                                <option value="{{ $skill }}"
                                                    {{ request('skill') == $skill ? 'selected' : '' }}>
                                                    {{ $skill }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="primary-btn">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Sort Options -->
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <select name="sort" class="form-control">
                                            <option value="full_name"
                                                {{ request('sort') == 'full_name' ? 'selected' : '' }}>Urutkan berdasarkan
                                                Nama</option>
                                            <option value="nim" {{ request('sort') == 'nim' ? 'selected' : '' }}>Urutkan
                                                berdasarkan NIM</option>
                                            <option value="batch" {{ request('sort') == 'batch' ? 'selected' : '' }}>
                                                Urutkan berdasarkan Angkatan</option>
                                            <option value="created_at"
                                                {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <select name="order" class="form-control">
                                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z
                                            </option>
                                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    @if (request()->hasAny(['search', 'batch', 'skill', 'sort', 'order']))
                                        <a href="{{ route('students.index') }}" class="secondary-btn">
                                            <i class="fa fa-times"></i> Reset Filter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Filter Section End -->

    <!-- Students Section Begin -->
    <section style="background-image: url({{ asset('img/main-bg.jpg') }}); background-size: cover;"
        class="services-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title center-title text-center">
                        <span>Hasil Pencarian</span>
                        <h2>{{ $students->count() }} dari {{ $students->total() }} mahasiswa</h2>
                        @if (request('search'))
                            <p>untuk pencarian "{{ request('search') }}"</p>
                        @endif
                    </div>
                </div>
            </div>

            @if ($students->count() > 0)
                <div class="row">
                    @foreach ($students as $student)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="services__item student-card">
                                <div class="student-photo">
                                    <img src="{{ $student->casual_photo_url }}" alt="{{ $student->full_name }}">
                                </div>
                                <h4>{{ $student->full_name }}</h4>
                                <div class="student-info">
                                    <span class="nim-badge">{{ $student->nim }}</span>
                                    <p class="batch-info">Angkatan {{ $student->batch }}</p>

                                    @if ($student->bio)
                                        <p class="bio">{{ Str::limit($student->bio, 80) }}</p>
                                    @endif

                                    @if ($student->life_motto)
                                        <div class="motto">
                                            <i class="fa fa-quote-left"></i>
                                            {{ Str::limit($student->life_motto, 60) }}
                                            <i class="fa fa-quote-right"></i>
                                        </div>
                                    @endif

                                    @if ($student->skills && count($student->skills) > 0)
                                        <div class="skills">
                                            @foreach (array_slice($student->skills, 0, 3) as $skill)
                                                <span class="skill-tag">{{ $skill }}</span>
                                            @endforeach
                                            @if (count($student->skills) > 3)
                                                <span class="skill-tag more">+{{ count($student->skills) - 3 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('students.show', $student) }}" class="read__more">
                                    Lihat Profil <span class="arrow_right"></span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pagination-wrapper text-center">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="no-results text-center">
                            <i class="fa fa-search" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                            <h4>Tidak ada mahasiswa ditemukan</h4>
                            <p>Coba ubah filter pencarian atau kata kunci Anda</p>
                            <a href="{{ route('students.index') }}" class="primary-btn">Lihat Semua Mahasiswa</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Students Section End -->

    <!-- Quick Search Modal -->
    <div id="quickSearchModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pencarian Cepat</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="quickSearchInput" class="form-control"
                        placeholder="Ketik nama atau NIM mahasiswa...">
                    <div id="quickSearchResults" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    /* Additional CSS for student cards */
    .filter-form {
        background: rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 50px;
    }

    .filter-form .form-control {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #ddd;
        padding: 12px 15px;
        border-radius: 5px;
    }

    .student-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .student-card:hover {
        transform: translateY(-10px);
    }

    .student-photo {
        width: 100%;
        height: 250px;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .student-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .student-card:hover .student-photo img {
        transform: scale(1.1);
    }

    .student-info {
        margin: 15px 0;
    }

    .nim-badge {
        background: #f39c12;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
    }

    .batch-info {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .bio {
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .motto {
        background: rgba(243, 156, 18, 0.1);
        padding: 10px;
        border-left: 4px solid #f39c12;
        border-radius: 5px;
        font-style: italic;
        font-size: 13px;
        margin-bottom: 15px;
    }

    .skills {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 15px;
    }

    .skill-tag {
        background: rgba(243, 156, 18, 0.2);
        color: #f39c12;
        padding: 3px 8px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 500;
    }

    .skill-tag.more {
        background: rgba(52, 152, 219, 0.2);
        color: #3498db;
    }

    .no-results {
        padding: 80px 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .pagination-wrapper {
        margin-top: 50px;
    }

    .pagination-wrapper .pagination {
        display: inline-flex;
        justify-content: center;
    }

    .pagination-wrapper .pagination .page-link {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #ddd;
        color: #333;
        padding: 10px 15px;
        margin: 0 2px;
        border-radius: 5px;
        text-decoration: none;
    }

    .pagination-wrapper .pagination .page-link:hover,
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: #f39c12;
        color: white;
        border-color: #f39c12;
    }

    .secondary-btn {
        background: #95a5a6;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .secondary-btn:hover {
        background: #7f8c8d;
        color: white;
        text-decoration: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick search functionality
        const quickSearchInput = document.getElementById('quickSearchInput');
        const quickSearchResults = document.getElementById('quickSearchResults');

        if (quickSearchInput) {
            let searchTimeout;

            quickSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    quickSearchResults.innerHTML = '';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('students.search') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            let html = '';
                            if (data.length > 0) {
                                data.forEach(student => {
                                    html += `
                                <div class="d-flex align-items-center p-3 border-bottom">
                                    <img src="${student.photo}" alt="${student.name}"
                                         class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">${student.name}</h6>
                                        <small class="text-muted">${student.nim} - Angkatan ${student.batch}</small>
                                    </div>
                                    <a href="${student.url}" class="btn btn-sm btn-primary">
                                        Lihat
                                    </a>
                                </div>
                            `;
                                });
                            } else {
                                html =
                                    '<div class="text-center text-muted py-4">Tidak ada hasil ditemukan</div>';
                            }
                            quickSearchResults.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            quickSearchResults.innerHTML =
                                '<div class="text-center text-danger py-4">Terjadi kesalahan</div>';
                        });
                }, 300);
            });
        }

        // Keyboard shortcut for quick search
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'k') {
                e.preventDefault();
                $('#quickSearchModal').modal('show');
            }
        });
    });
</script>
