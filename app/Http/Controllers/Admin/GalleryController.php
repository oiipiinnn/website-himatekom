<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_name' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['image'] = ImageHelper::upload($request->file('image'), 'galleries');

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_name' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            ImageHelper::delete($gallery->image);
            // Upload new image
            $data['image'] = ImageHelper::upload($request->file('image'), 'galleries');
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete image file
        ImageHelper::delete($gallery->image);

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus!');
    }
}
