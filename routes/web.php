<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AspirationController;
use App\Http\Controllers\Core3dController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\AspirationController as AdminAspirationController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/core3d', [Core3dController::class, 'index'])->name('core3d');
Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');
Route::get('/pengurus/{division:slug}', [PengurusController::class, 'show'])->name('pengurus.show');

// Student Routes
Route::get('/data-mahasiswa', [StudentController::class, 'index'])->name('students.index');
Route::get('/data-mahasiswa/daftar', [StudentController::class, 'create'])->name('students.create');
Route::post('/data-mahasiswa', [StudentController::class, 'store'])->name('students.store');
Route::get('/data-mahasiswa/{student}', [StudentController::class, 'show'])->name('students.show');
Route::get('/api/students/search', [StudentController::class, 'search'])->name('students.search');

Route::get('/blog', [PostController::class, 'index'])->name('blog');
Route::get('/blog/tag/{tag}', [PostController::class, 'showByTag'])->name('blog.tag');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('blog.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/ruang-aspirasi', [AspirationController::class, 'index'])->name('aspirations.index');
Route::get('/ruang-aspirasi/kirim', [AspirationController::class, 'create'])->name('aspirations.create');
Route::post('/ruang-aspirasi', [AspirationController::class, 'store'])->name('aspirations.store');

// Legacy redirects
Route::get('/pengurus/inti', function () {
    $division = App\Models\Division::where('slug', 'inti')->first();
    return $division ? redirect()->route('pengurus.show', $division) : abort(404);
});
Route::get('/pengurus/internal', function () {
    $division = App\Models\Division::where('slug', 'internal')->first();
    return $division ? redirect()->route('pengurus.show', $division) : abort(404);
});
Route::get('/pengurus/external', function () {
    $division = App\Models\Division::where('slug', 'eksternal')->first();
    return $division ? redirect()->route('pengurus.show', $division) : abort(404);
});
Route::get('/pengurus/risbang', function () {
    $division = App\Models\Division::where('slug', 'risbang')->first();
    return $division ? redirect()->route('pengurus.show', $division) : abort(404);
});

// Auth Routes
require __DIR__ . '/auth.php';

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('divisions', AdminDivisionController::class);

    // Member management routes - FIXED ORDER
    Route::get('members/export', [AdminMemberController::class, 'export'])->name('members.export');
    Route::get('members/search-students', [AdminMemberController::class, 'searchStudents'])->name('members.search-students');
    Route::resource('members', AdminMemberController::class);
    Route::patch('members/{member}/toggle-active', [AdminMemberController::class, 'toggleActive'])->name('members.toggle-active');
    Route::patch('members/{member}/make-alumni', [AdminMemberController::class, 'makeAlumni'])->name('members.make-alumni');
    Route::post('members/{member}/sync-from-student', [AdminMemberController::class, 'syncFromStudent'])->name('members.sync-from-student');

    // Student management routes - UPDATED WITH CREATE & STORE
    Route::get('students/export', [AdminStudentController::class, 'export'])->name('students.export');
    Route::resource('students', AdminStudentController::class);
    Route::patch('students/{student}/approve', [AdminStudentController::class, 'approve'])->name('students.approve');
    Route::patch('students/{student}/reject', [AdminStudentController::class, 'reject'])->name('students.reject');
    Route::patch('students/{student}/toggle-active', [AdminStudentController::class, 'toggleActive'])->name('students.toggle-active');
    Route::patch('students/{student}/toggle-public', [AdminStudentController::class, 'togglePublic'])->name('students.toggle-public');
    Route::post('students/bulk-approve', [AdminStudentController::class, 'bulkApprove'])->name('students.bulk-approve');
    Route::post('students/bulk-reject', [AdminStudentController::class, 'bulkReject'])->name('students.bulk-reject');

    Route::resource('posts', AdminPostController::class);
    Route::resource('galleries', AdminGalleryController::class);
    Route::resource('aspirations', AdminAspirationController::class)->only(['index', 'show', 'destroy']);
    Route::patch('aspirations/{aspiration}/approve', [AdminAspirationController::class, 'approve'])->name('aspirations.approve');
    Route::patch('aspirations/{aspiration}/reject', [AdminAspirationController::class, 'reject'])->name('aspirations.reject');
    Route::get('about', [AdminAboutController::class, 'index'])->name('about.index');
    Route::put('about', [AdminAboutController::class, 'update'])->name('about.update');
});
