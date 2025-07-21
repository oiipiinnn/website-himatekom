<?php
// app/Http/Controllers/StudentController.php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::approved()->active()->public();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by batch
        if ($request->filled('batch')) {
            $query->byBatch($request->batch);
        }

        // Filter by skills
        if ($request->filled('skill')) {
            $query->whereJsonContains('skills', $request->skill);
        }

        // Sorting
        $sortBy = $request->get('sort', 'full_name');
        $sortOrder = $request->get('order', 'asc');

        $allowedSorts = ['full_name', 'nim', 'batch', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $students = $query->paginate(12)->withQueryString();

        // Data untuk filter
        $batches = Student::getBatches();
        $skills = Student::getSkillsList();

        return view('students.index', compact('students', 'batches', 'skills'));
    }

    public function show(Student $student)
    {
        // Hanya tampilkan jika approved, active, dan public
        if (!$student->isApproved() || !$student->is_active || !$student->show_in_public) {
            abort(404);
        }

        return view('students.show', compact('student'));
    }

    public function create()
    {
        return view('students.create');
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
            'casual_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
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
            'description' => 'nullable|string|max:2000',
            'life_motto' => 'nullable|string|max:500',
            'current_job' => 'nullable|string|max:255',
            'hometown' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
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
                $workPhotoName = 'work_' . time() . '_' . Str::random(10) . '.' . $workPhoto->getClientOriginalExtension();
                $data['work_photo'] = $workPhoto->storeAs('students/work_photos', $workPhotoName, 'public');
            }

            // Upload casual photo
            if ($request->hasFile('casual_photo')) {
                $casualPhoto = $request->file('casual_photo');
                $casualPhotoName = 'casual_' . time() . '_' . Str::random(10) . '.' . $casualPhoto->getClientOriginalExtension();
                $data['casual_photo'] = $casualPhoto->storeAs('students/casual_photos', $casualPhotoName, 'public');
            }

            // Upload validation document
            if ($request->hasFile('validation_document')) {
                $validationDoc = $request->file('validation_document');
                $validationDocName = 'validation_' . time() . '_' . Str::random(10) . '.' . $validationDoc->getClientOriginalExtension();
                $data['validation_document'] = $validationDoc->storeAs('students/validation_docs', $validationDocName, 'public');
            }

            // Set default values
            $data['status'] = 'pending';
            $data['is_active'] = true;
            $data['show_in_public'] = true;


            // Create student record
            $student = Student::create($data);


            // Return JSON response for AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data mahasiswa berhasil didaftarkan! Tunggu persetujuan admin untuk tampil di website.',
                    'student_id' => $student->id
                ], 201);
            }

            return redirect()->route('students.create')
                ->with('success', 'Data mahasiswa berhasil didaftarkan! Tunggu persetujuan admin untuk tampil di website.');
        } catch (\Exception $e) {

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

            // Return JSON response for AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ]);
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]);
        }

        $students = Student::approved()
            ->active()
            ->public()
            ->search($query)
            ->limit(10)
            ->get(['id', 'full_name', 'nim', 'batch', 'casual_photo']);

        return response()->json($students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->full_name,
                'nim' => $student->nim,
                'batch' => $student->batch,
                'photo' => $student->casual_photo_url,
                'url' => route('students.show', $student)
            ];
        }));
    }
}
