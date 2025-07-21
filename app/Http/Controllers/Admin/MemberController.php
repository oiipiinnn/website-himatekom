<?php
// app/Http/Controllers/Admin/MemberController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Division;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with(['division', 'student']);

        // Apply filters
        $this->applyFilters($query, $request);

        // Apply sorting
        $this->applySorting($query, $request);

        $members = $query->paginate(15)->withQueryString();

        return view('admin.members.index', [
            'members' => $members,
            'divisions' => Division::where('is_active', true)->orderBy('sort_order')->get(),
            'batches' => $this->getBatches(),
            'statuses' => Member::getStatuses(),
            'positionLevels' => Member::getPositionLevels(),
            'stats' => $this->getStatistics()
        ]);
    }

    public function show(Member $member)
    {
        $member->load(['division', 'student']);
        return view('admin.members.show', compact('member'));
    }

    public function create()
    {
        $divisions = Division::where('is_active', true)->orderBy('sort_order')->get();
        $students = Student::approved()->active()->whereDoesntHave('member')->orderBy('full_name')
            ->get(['id', 'full_name', 'nim', 'email', 'batch', 'phone', 'work_photo']); // CHANGED: work_photo
        $positionLevels = Member::getPositionLevels();

        return view('admin.members.create', compact('divisions', 'students', 'positionLevels'));
    }

    public function store(Request $request)
    {
        // Debug: Log all request data
        Log::info('Member store request data:', $request->all());

        $request->validate([
            'student_id' => 'required|exists:students,id|unique:members,student_id',
            'position' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'position_level' => 'required|integer|between:1,4',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'motivation' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'status' => 'nullable|in:active,inactive,alumni',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $student = Student::findOrFail($request->student_id);

            // Debug: Log student data
            Log::info('Student found:', ['student_id' => $student->id, 'name' => $student->full_name]);

            $memberData = [
                'student_id' => $student->id,
                'position' => $request->position,
                'division_id' => $request->division_id,
                'position_level' => $request->position_level,
                'start_date' => $request->start_date ?: now(),
                'end_date' => $request->end_date,
                'motivation' => $request->motivation,
                'notes' => $request->notes,
                'status' => $request->status ?: 'active',
                'is_active' => $request->has('is_active') ? (bool)$request->is_active : true, // FIXED: Proper boolean handling
            ];

            // Debug: Log member data before creation
            Log::info('Member data to create:', $memberData);

            $member = Member::create($memberData);

            Log::info('Member created successfully', [
                'member_id' => $member->id,
                'student_id' => $student->id,
                'student_name' => $student->full_name,
                'position' => $request->position,
                'division' => $member->division->name,
                'created_by' => auth()->user()->name
            ]);

            return redirect()->route('admin.members.index')
                ->with('success', "Anggota pengurus {$student->full_name} berhasil ditambahkan sebagai {$request->position}!");
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed in member store', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Failed to create member', [
                'student_id' => $request->student_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'admin_user' => auth()->user()->name
            ]);

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(Member $member)
    {
        $divisions = Division::where('is_active', true)->orderBy('sort_order')->get();
        $students = Student::approved()->active()
            ->where(function ($query) use ($member) {
                $query->whereDoesntHave('member')
                    ->orWhere('id', $member->student_id);
            })
            ->orderBy('full_name')
            ->get();
        $positionLevels = Member::getPositionLevels();

        return view('admin.members.edit', compact('member', 'divisions', 'students', 'positionLevels'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id|unique:members,student_id,' . $member->id,
            'position' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'position_level' => 'required|integer|between:1,4',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'motivation' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'status' => 'nullable|in:active,inactive,alumni',
            'is_active' => 'boolean',
        ]);

        try {
            $student = Student::findOrFail($request->student_id);

            $member->update([
                'student_id' => $student->id,
                'position' => $request->position,
                'division_id' => $request->division_id,
                'position_level' => $request->position_level,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'motivation' => $request->motivation,
                'notes' => $request->notes,
                'status' => $request->status ?: 'active',
                'is_active' => $request->has('is_active'),
            ]);

            Log::info('Member updated', [
                'member_id' => $member->id,
                'student_id' => $student->id,
                'updated_by' => auth()->user()->name
            ]);

            return redirect()->route('admin.members.show', $member)
                ->with('success', 'Data anggota berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update member', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function destroy(Member $member)
    {
        try {
            $memberInfo = [
                'id' => $member->id,
                'student_name' => $member->student->full_name,
                'position' => $member->position,
                'division' => $member->division->name
            ];

            $member->delete();

            Log::info('Member deleted', [
                'member_info' => $memberInfo,
                'deleted_by' => auth()->user()->name
            ]);

            return redirect()->route('admin.members.index')
                ->with('success', 'Data anggota berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to delete member', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withErrors('Terjadi kesalahan saat menghapus data.');
        }
    }

    // Action methods
    public function syncFromStudent(Member $member)
    {
        try {
            // Since we don't store personal data in members table anymore,
            // this is mainly for logging purposes
            Log::info('Member sync requested', [
                'member_id' => $member->id,
                'student_id' => $member->student_id,
                'synced_by' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', 'Data anggota sudah tersinkronisasi dengan mahasiswa!');
        } catch (\Exception $e) {
            Log::error('Failed to sync member', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat sinkronisasi data.');
        }
    }

    public function toggleActive(Member $member)
    {
        try {
            $member->update(['is_active' => !$member->is_active]);
            $status = $member->is_active ? 'diaktifkan' : 'dinonaktifkan';

            Log::info('Member status toggled', [
                'member_id' => $member->id,
                'new_status' => $member->is_active,
                'changed_by' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', "Anggota berhasil {$status}!");
        } catch (\Exception $e) {
            Log::error('Failed to toggle member status', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status.');
        }
    }

    public function makeAlumni(Member $member)
    {
        try {
            $member->makeAlumni();

            Log::info('Member made alumni', [
                'member_id' => $member->id,
                'changed_by' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', 'Anggota berhasil dijadikan alumni!');
        } catch (\Exception $e) {
            Log::error('Failed to make member alumni', [
                'member_id' => $member->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status alumni.');
        }
    }

    // API methods
    public function searchStudents(Request $request)
    {
        $query = $request->get('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        try {
            $students = Student::approved()
                ->active()
                ->whereDoesntHave('member')
                ->where(function ($q) use ($query) {
                    $q->where('full_name', 'like', "%{$query}%")
                        ->orWhere('nim', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get(['id', 'full_name', 'nim', 'email', 'batch', 'phone', 'work_photo']); // CHANGED: work_photo instead of casual_photo

            return response()->json($students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->full_name,
                    'nim' => $student->nim,
                    'email' => $student->email,
                    'batch' => $student->batch,
                    'phone' => $student->phone,
                    'work_photo' => $student->work_photo_url // CHANGED: work_photo_url instead of casual_photo_url
                ];
            }));
        } catch (\Exception $e) {
            Log::error('Student search failed', ['query' => $query, 'error' => $e->getMessage()]);
            return response()->json([], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            $query = Member::with(['division', 'student']);

            if ($request->filled('division')) {
                $query->byDivision($request->division);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $members = $query->get();

            $csvData = [];
            $csvData[] = [
                'Nama',
                'NIM',
                'Email',
                'Telepon',
                'Angkatan',
                'Posisi',
                'Divisi',
                'Level',
                'Mulai Jabatan',
                'Status'
            ];

            foreach ($members as $member) {
                $csvData[] = [
                    $member->name,
                    $member->nim,
                    $member->email,
                    $member->phone,
                    $member->batch,
                    $member->position,
                    $member->division->name,
                    $member->position_level,
                    $member->start_date ? $member->start_date->format('Y-m-d') : '',
                    $member->status
                ];
            }

            $filename = 'data_anggota_pengurus_' . date('Y-m-d') . '.csv';

            $handle = fopen('php://memory', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            rewind($handle);
            $content = stream_get_contents($handle);
            fclose($handle);

            Log::info('Members data exported', [
                'count' => count($members),
                'exported_by' => auth()->user()->name
            ]);

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            Log::error('Failed to export members data', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor data.');
        }
    }

    // Private helper methods
    private function applyFilters($query, $request)
    {
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('division')) {
            $query->byDivision($request->division);
        }

        if ($request->filled('batch')) {
            $query->byBatch($request->batch);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('position_level')) {
            $query->where('position_level', $request->position_level);
        }
    }

    private function applySorting($query, $request)
    {
        $sortBy = $request->get('sort', 'position_level');
        $sortOrder = $request->get('order', 'asc');
        $allowedSorts = ['position', 'position_level', 'created_at'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Default sort by position level and division
            $query->orderBy('position_level', 'asc')
                ->orderBy('division_id', 'asc');
        }
    }

    private function getStatistics()
    {
        return [
            'total' => Member::count(),
            'active' => Member::active()->count(),
            'leaders' => Member::leaders()->active()->count(),
            'alumni' => Member::alumni()->count(),
        ];
    }

    private function getBatches()
    {
        return Member::join('students', 'members.student_id', '=', 'students.id')
            ->distinct('students.batch')
            ->orderBy('students.batch', 'desc')
            ->pluck('students.batch')
            ->toArray();
    }
}
