<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Handle tags - convert comma-separated string to array
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $data['tags'] = array_filter($tags); // Remove empty tags
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($request->is_published) {
            $data['published_at'] = now();
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil ditambahkan!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();

        // Handle tags - convert comma-separated string to array
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $data['tags'] = array_filter($tags); // Remove empty tags
        } else {
            $data['tags'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        // Handle publishing
        if ($request->is_published && !$post->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diupdate!');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil dihapus!');
    }
}
