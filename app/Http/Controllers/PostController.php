<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            })
            ->when($request->tag, function ($query) use ($request) {
                $query->withTag($request->tag);
            })
            ->latest('published_at')
            ->paginate(9);

        // Get popular tags from all published posts
        $allTags = Post::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);

        return view('blog.index', compact('posts', 'allTags'));
    }

    public function show(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }

        // Increment view count
        $post->incrementViews();

        // Load user relationship
        $post->load('user');

        return view('blog.show', compact('post'));
    }

    public function showByTag(Request $request, $tag)
    {
        $posts = Post::published()
            ->with('user')
            ->withTag($tag)
            ->latest('published_at')
            ->paginate(9);

        // Get popular tags from all published posts
        $allTags = Post::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);

        return view('blog.index', compact('posts', 'allTags'))->with('currentTag', $tag);
    }
}
