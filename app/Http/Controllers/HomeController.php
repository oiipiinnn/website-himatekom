<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $divisions = Division::where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $latestPosts = Post::published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->latest()
            ->take(7)
            ->get();

        return view('index', compact('divisions', 'latestPosts', 'galleries'));
    }
}
