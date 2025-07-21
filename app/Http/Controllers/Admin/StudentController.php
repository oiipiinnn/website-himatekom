<?php
// app/Http/Controllers/Admin/StudentController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by batch
        if ($request->filled('batch')) {
            $query->byBatch($request->batch);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['full_name', 'nim', 'batch', 'status', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $students = $query->paginate(15)->withQueryString();

        // Data untuk filter
        $batches = Student::distinct('batch')->orderBy('batch', 'desc')->pluck('batch')->toArray();
        $statuses = Student::getStatuses();

        // Statistics
        $stats = [
            'total' => Student::count(),
            'pending' => Student::pending()->count(),
            'approved' => Student::approved()->count(),
            'rejected' => Student::rejected()->count(),
        ];

        return view('admin.students.index', compact('students', 'batches', 'statuses', 'stats'));
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students,nim',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'batch' => 'required|string|max:10',
            'work_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'casual_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'validation_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240', // 10MB
            'skills' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'career_goal' => 'nullable|string|max:255',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'github' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
            'current_job' => 'nullable|string|max:255',
            'hometown' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'status' => 'required|in:pending,approved',
            'is_active' => 'nullable|boolean',
            'show_in_public' => 'nullable|boolean',
        ]);

        try {
            // Prepare data
            $data = $validated;

            // Handle skills (convert from JSON string to array)
            if ($request->filled('skills')) {
                $skillsData = $request->input('skills');
                if (is_string($skillsData)) {
                    $skills = json_decode($skillsData, true);
                    $data['skills'] = is_array($skills) ? array_filter($skills) : null;
                } else {
                    $data['skills'] = null;
                }
            } else {
                $data['skills'] = null;
            }

            // Handle hobbies (convert from JSON string to array)
            if ($request->filled('hobbies')) {
                $hobbiesData = $request->input('hobbies');
                if (is_string($hobbiesData)) {
                    $hobbies = json_decode($hobbiesData, true);
                    $data['hobbies'] = is_array($hobbies) ? array_filter($hobbies) : null;
                } else {
                    $data['hobbies'] = null;
                }
            } else {
                $data['hobbies'] = null;
            }

            // Handle file uploads
            // Upload work photo
            if ($request->hasFile('work_photo')) {
                $workPhoto = $request->file('work_photo');
                $workPhotoName = 'admin_work_' . time() . '_' . Str::random(10) . '.' . $workPhoto->getClientOriginalExtension();
                $data['work_photo'] = $workPhoto->storeAs('students/work_photos', $workPhotoName, 'public');
            }

            // Upload casual photo
            if ($request->hasFile('casual_photo')) {
                $casualPhoto = $request->file('casual_photo');
                $casualPhotoName = 'admin_casual_' . time() . '_' . Str::random(10) . '.' . $casualPhoto->getClientOriginalExtension();
                $data['casual_photo'] = $casualPhoto->storeAs('students/casual_photos', $casualPhotoName, 'public');
            }

            // Upload validation document
            if ($request->hasFile('validation_document')) {
                $validationDoc = $request->file('validation_document');
                $validationDocName = 'admin_validation_' . time() . '_' . Str::random(10) . '.' . $validationDoc->getClientOriginalExtension();
                $data['validation_document'] = $validationDoc->storeAs('students/validation_docs', $validationDocName, 'public');
            }

            // Set admin-specific values
            $data['is_active'] = $request->has('is_active');
            $data['show_in_public'] = $request->has('show_in_public');

            // If status is approved, set approval details
            if ($data['status'] === 'approved') {
                $data['approved_at'] = now();
                $data['approved_by'] = auth()->id();
                $data['rejection_reason'] = null;
            }

            // Create student record
            $student = Student::create($data);

            Log::info('Student created by admin', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'created_by_admin' => auth()->user()->name,
                'status' => $student->status
            ]);

            return redirect()->route('admin.students.index')
                ->with('success', 'Mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Admin student creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'admin_user' => auth()->user()->name
            ]);

            // Clean up uploaded files if database insert fails
            if (isset($data['work_photo']) && Storage::disk('public')->exists($data['work_photo'])) {
                Storage::disk('public')->delete($data['work_photo']);
            }
            if (isset($data['casual_photo']) && Storage::disk('public')->exists($data['casual_photo'])) {
                Storage::disk('public')->delete($data['casual_photo']);
            }
            if (isset($data['validation_document']) && Storage::disk('public')->exists($data['validation_document'])) {
                Storage::disk('public')->delete($data['validation_document']);
            }

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ]);
        }
    }

    public function approve(Student $student)
    {
        try {
            $student->approve(auth()->id());

            Log::info('Student approved', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'approved_by' => auth()->user()->name
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mahasiswa berhasil disetujui!'
                ]);
            }

            return redirect()->back()->with('success', 'Mahasiswa berhasil disetujui!');
        } catch (\Exception $e) {
            Log::error('Failed to approve student', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyetujui mahasiswa.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat menyetujui mahasiswa.');
        }
    }

    public function reject(Request $request, Student $student)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        try {
            $student->reject($request->rejection_reason, auth()->id());

            Log::info('Student rejected', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'rejected_by' => auth()->user()->name,
                'reason' => $request->rejection_reason
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mahasiswa berhasil ditolak!'
                ]);
            }

            return redirect()->back()->with('success', 'Mahasiswa berhasil ditolak!');
        } catch (\Exception $e) {
            Log::error('Failed to reject student', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menolak mahasiswa.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat menolak mahasiswa.');
        }
    }

    public function toggleActive(Student $student)
    {
        try {
            $student->update(['is_active' => !$student->is_active]);

            $status = $student->is_active ? 'diaktifkan' : 'dinonaktifkan';

            Log::info('Student status toggled', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'new_status' => $student->is_active ? 'active' : 'inactive',
                'changed_by' => auth()->user()->name
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Mahasiswa berhasil {$status}!"
                ]);
            }

            return redirect()->back()->with('success', "Mahasiswa berhasil {$status}!");
        } catch (\Exception $e) {
            Log::error('Failed to toggle student status', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengubah status.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat mengubah status.');
        }
    }

    public function togglePublic(Student $student)
    {
        try {
            $student->update(['show_in_public' => !$student->show_in_public]);

            $status = $student->show_in_public ? 'ditampilkan' : 'disembunyikan';

            Log::info('Student visibility toggled', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'show_in_public' => $student->show_in_public,
                'changed_by' => auth()->user()->name
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Mahasiswa berhasil {$status} dari publik!"
                ]);
            }

            return redirect()->back()->with('success', "Mahasiswa berhasil {$status} dari publik!");
        } catch (\Exception $e) {
            Log::error('Failed to toggle student visibility', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengubah visibility.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat mengubah visibility.');
        }
    }

    public function destroy(Student $student)
    {
        try {
            // Store student info for logging before deletion
            $studentInfo = [
                'id' => $student->id,
                'name' => $student->full_name,
                'nim' => $student->nim,
                'email' => $student->email
            ];

            // Delete uploaded files
            if ($student->work_photo) {
                Storage::disk('public')->delete($student->work_photo);
            }
            if ($student->casual_photo) {
                Storage::disk('public')->delete($student->casual_photo);
            }
            if ($student->validation_document) {
                Storage::disk('public')->delete($student->validation_document);
            }

            $student->delete();

            Log::info('Student deleted', [
                'student_info' => $studentInfo,
                'deleted_by' => auth()->user()->name
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data mahasiswa berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to delete student', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat menghapus data.');
        }
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ]);

        try {
            $studentIds = $request->input('student_ids');

            // Handle JSON string input
            if (is_string($studentIds)) {
                $studentIds = json_decode($studentIds, true);
            }

            if (!is_array($studentIds) || empty($studentIds)) {
                throw new \Exception('Invalid student IDs provided');
            }

            $count = Student::whereIn('id', $studentIds)
                ->where('status', 'pending')
                ->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id(),
                    'rejection_reason' => null
                ]);

            Log::info('Bulk approve students', [
                'student_ids' => $studentIds,
                'count' => $count,
                'approved_by' => auth()->user()->name
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$count} mahasiswa berhasil disetujui!"
                ]);
            }

            return redirect()->back()->with('success', "{$count} mahasiswa berhasil disetujui!");
        } catch (\Exception $e) {
            Log::error('Failed to bulk approve students', [
                'student_ids' => $request->input('student_ids'),
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyetujui mahasiswa.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat menyetujui mahasiswa.');
        }
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'bulk_rejection_reason' => 'required|string|max:1000'
        ]);

        try {
            $studentIds = $request->input('student_ids');

            // Handle JSON string input
            if (is_string($studentIds)) {
                $studentIds = json_decode($studentIds, true);
            }

            if (!is_array($studentIds) || empty($studentIds)) {
                throw new \Exception('Invalid student IDs provided');
            }

            $count = Student::whereIn('id', $studentIds)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->input('bulk_rejection_reason'),
                    'approved_at' => null,
                    'approved_by' => auth()->id()
                ]);

            Log::info('Bulk reject students', [
                'student_ids' => $studentIds,
                'count' => $count,
                'reason' => $request->input('bulk_rejection_reason'),
                'rejected_by' => auth()->user()->name
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$count} mahasiswa berhasil ditolak!"
                ]);
            }

            return redirect()->back()->with('success', "{$count} mahasiswa berhasil ditolak!");
        } catch (\Exception $e) {
            Log::error('Failed to bulk reject students', [
                'student_ids' => $request->input('student_ids'),
                'error' => $e->getMessage()
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menolak mahasiswa.'
                ], 500);
            }

            return redirect()->back()->withErrors('Terjadi kesalahan saat menolak mahasiswa.');
        }
    }

    public function export(Request $request)
    {
        try {
            $query = Student::approved()->active();

            if ($request->filled('batch')) {
                $query->byBatch($request->batch);
            }

            $students = $query->get();

            $csvData = [];
            $csvData[] = [
                'Nama Lengkap',
                'NIM',
                'Email',
                'Telepon',
                'Angkatan',
                'Keahlian',
                'Hobi',
                'Tujuan Karir',
                'Pekerjaan Saat Ini',
                'Asal Daerah',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'Bio',
                'Instagram',
                'LinkedIn',
                'TikTok',
                'GitHub',
                'Portfolio'
            ];

            foreach ($students as $student) {
                $csvData[] = [
                    $student->full_name,
                    $student->nim,
                    $student->email,
                    $student->phone,
                    $student->batch,
                    is_array($student->skills) ? implode(', ', $student->skills) : '',
                    is_array($student->hobbies) ? implode(', ', $student->hobbies) : '',
                    $student->career_goal,
                    $student->current_job,
                    $student->hometown,
                    $student->birth_date ? $student->birth_date->format('Y-m-d') : '',
                    $student->gender_label,
                    $student->bio,
                    $student->instagram,
                    $student->linkedin,
                    $student->tiktok,
                    $student->github,
                    $student->portfolio_url
                ];
            }

            $filename = 'data_mahasiswa_' . date('Y-m-d') . '.csv';

            $handle = fopen('php://memory', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            rewind($handle);
            $content = stream_get_contents($handle);
            fclose($handle);

            Log::info('Students data exported', [
                'count' => count($students),
                'batch_filter' => $request->get('batch'),
                'exported_by' => auth()->user()->name
            ]);

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            Log::error('Failed to export students data', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withErrors('Terjadi kesalahan saat mengekspor data.');
        }
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // Validate input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students,nim,' . $student->id,
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'batch' => 'required|string|max:10',
            'work_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'casual_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'validation_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240', // 10MB
            'skills' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'career_goal' => 'nullable|string|max:255',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'github' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
            'current_job' => 'nullable|string|max:255',
            'hometown' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'status' => 'required|in:pending,approved,rejected',
            'is_active' => 'nullable|boolean',
            'show_in_public' => 'nullable|boolean',
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        try {
            // Prepare data
            $data = $validated;

            // Handle skills (convert from JSON string to array)
            if ($request->filled('skills')) {
                $skillsData = $request->input('skills');
                if (is_string($skillsData)) {
                    $skills = json_decode($skillsData, true);
                    $data['skills'] = is_array($skills) ? array_filter($skills) : null;
                } else {
                    $data['skills'] = null;
                }
            } else {
                $data['skills'] = null;
            }

            // Handle hobbies (convert from JSON string to array)
            if ($request->filled('hobbies')) {
                $hobbiesData = $request->input('hobbies');
                if (is_string($hobbiesData)) {
                    $hobbies = json_decode($hobbiesData, true);
                    $data['hobbies'] = is_array($hobbies) ? array_filter($hobbies) : null;
                } else {
                    $data['hobbies'] = null;
                }
            } else {
                $data['hobbies'] = null;
            }

            // Store old file paths for cleanup if needed
            $oldFiles = [
                'work_photo' => $student->work_photo,
                'casual_photo' => $student->casual_photo,
                'validation_document' => $student->validation_document
            ];

            // Handle file uploads (only if new files are provided)
            if ($request->hasFile('work_photo')) {
                $workPhoto = $request->file('work_photo');
                $workPhotoName = 'admin_work_' . time() . '_' . Str::random(10) . '.' . $workPhoto->getClientOriginalExtension();
                $data['work_photo'] = $workPhoto->storeAs('students/work_photos', $workPhotoName, 'public');
            }

            if ($request->hasFile('casual_photo')) {
                $casualPhoto = $request->file('casual_photo');
                $casualPhotoName = 'admin_casual_' . time() . '_' . Str::random(10) . '.' . $casualPhoto->getClientOriginalExtension();
                $data['casual_photo'] = $casualPhoto->storeAs('students/casual_photos', $casualPhotoName, 'public');
            }

            if ($request->hasFile('validation_document')) {
                $validationDoc = $request->file('validation_document');
                $validationDocName = 'admin_validation_' . time() . '_' . Str::random(10) . '.' . $validationDoc->getClientOriginalExtension();
                $data['validation_document'] = $validationDoc->storeAs('students/validation_docs', $validationDocName, 'public');
            }

            // Set admin-specific values
            $data['is_active'] = $request->has('is_active');
            $data['show_in_public'] = $request->has('show_in_public');

            // Handle status changes
            if ($data['status'] === 'approved' && $student->status !== 'approved') {
                $data['approved_at'] = now();
                $data['approved_by'] = auth()->id();
                $data['rejection_reason'] = null;
            } elseif ($data['status'] === 'rejected') {
                $data['approved_at'] = null;
                $data['approved_by'] = null;
                // Keep rejection reason if provided, or use existing one
                if (!$request->filled('rejection_reason') && $student->rejection_reason) {
                    $data['rejection_reason'] = $student->rejection_reason;
                }
            } elseif ($data['status'] === 'pending') {
                $data['approved_at'] = null;
                $data['approved_by'] = null;
                $data['rejection_reason'] = null;
            }

            // Update student record
            $student->update($data);

            // Delete old files if new ones were uploaded
            if ($request->hasFile('work_photo') && $oldFiles['work_photo']) {
                Storage::disk('public')->delete($oldFiles['work_photo']);
            }
            if ($request->hasFile('casual_photo') && $oldFiles['casual_photo']) {
                Storage::disk('public')->delete($oldFiles['casual_photo']);
            }
            if ($request->hasFile('validation_document') && $oldFiles['validation_document']) {
                Storage::disk('public')->delete($oldFiles['validation_document']);
            }

            Log::info('Student updated by admin', [
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'updated_by_admin' => auth()->user()->name,
                'status' => $student->status,
                'changes' => array_keys($data)
            ]);

            return redirect()->route('admin.students.show', $student)
                ->with('success', 'Data mahasiswa berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Admin student update failed', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'admin_user' => auth()->user()->name
            ]);

            // Clean up newly uploaded files if database update fails
            if (isset($data['work_photo']) && $data['work_photo'] !== $student->work_photo) {
                Storage::disk('public')->delete($data['work_photo']);
            }
            if (isset($data['casual_photo']) && $data['casual_photo'] !== $student->casual_photo) {
                Storage::disk('public')->delete($data['casual_photo']);
            }
            if (isset($data['validation_document']) && $data['validation_document'] !== $student->validation_document) {
                Storage::disk('public')->delete($data['validation_document']);
            }

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.'
            ]);
        }
    }
}
