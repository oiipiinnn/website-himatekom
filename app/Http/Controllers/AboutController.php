<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use App\Models\Division;
use App\Models\Member;
use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Get all about settings
        $aboutData = AboutSetting::getAll();

        // Get dynamic counts
        $stats = [
            'divisions_count' => Division::where('is_active', true)->count(),
            'members_count' => Member::active()->count(),
            'program_kerja_count' => (int) AboutSetting::get('program_kerja_count', 25),
            'main_event_count' => (int) AboutSetting::get('main_event_count', 3),
            'posts_count' => Post::published()->count(),
            'galleries_count' => Gallery::count(),
        ];

        // Get misi as array
        $misi = AboutSetting::getMisi();

        // Merge data
        $aboutData = array_merge($aboutData, $stats);
        $aboutData['misi_array'] = $misi;

        return view('about', compact('aboutData'));
    }
}
