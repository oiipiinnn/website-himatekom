<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use App\Models\Student;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Aspiration;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic statistics
        $stats = [
            'divisions' => Division::where('is_active', true)->count(),
            'members' => Member::where('is_active', true)->count(),
            'students_total' => Student::count(),
            'students_pending' => Student::pending()->count(),
            'students_approved' => Student::approved()->count(),
            'students_rejected' => Student::rejected()->count(),
            'posts' => Post::count(),
            'posts_published' => Post::where('is_published', true)->count(),
            'galleries' => Gallery::count(),
            'aspirations_pending' => Aspiration::where('status', 'pending')->count(),
            'aspirations_total' => Aspiration::count(),
        ];

        // Recent students (pending approval)
        $recentStudents = Student::pending()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent aspirations (pending)
        $recentAspirations = Aspiration::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent posts
        $recentPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Student statistics by batch
        $studentsByBatch = Student::approved()
            ->active()
            ->selectRaw('batch, COUNT(*) as count')
            ->groupBy('batch')
            ->orderBy('batch', 'desc')
            ->get();

        // Monthly registration trend (last 6 months)
        $monthlyRegistrations = Student::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'count' => $item->count
                ];
            });

        // Top skills from students
        $topSkills = Student::approved()
            ->active()
            ->whereNotNull('skills')
            ->where('skills', '!=', '[]')
            ->get()
            ->pluck('skills')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);

        return view('admin.dashboard', compact(
            'stats',
            'recentStudents',
            'recentAspirations',
            'recentPosts',
            'studentsByBatch',
            'monthlyRegistrations',
            'topSkills'
        ));
    }
}
