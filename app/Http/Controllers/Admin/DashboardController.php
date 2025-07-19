<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Aspiration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'divisions' => Division::count(),
            'members' => Member::where('is_active', true)->count(),
            'posts' => Post::published()->count(),
            'galleries' => Gallery::where('is_active', true)->count(),
            'aspirations_pending' => Aspiration::pending()->count(),
            'aspirations_approved' => Aspiration::approved()->count(),
        ];

        $recentAspirations = Aspiration::pending()
            ->latest()
            ->take(5)
            ->get();

        $recentPosts = Post::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentAspirations', 'recentPosts'));
    }
}