<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $settings = AboutSetting::getAll();
        $misi = AboutSetting::getMisi();

        return view('admin.about.index', compact('settings', 'misi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|array|min:1',
            'misi.*' => 'required|string',
            'history_title' => 'required|string|max:255',
            'location_title' => 'required|string|max:255',
            'location_subtitle' => 'required|string|max:255',
            'location_address' => 'required|string',
            'location_office' => 'required|string|max:255',
            'program_kerja_count' => 'required|integer|min:0',
            'main_event_count' => 'required|integer|min:0',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Update text settings
            $textSettings = [
                'title',
                'subtitle',
                'description',
                'visi',
                'history_title',
                'location_title',
                'location_subtitle',
                'location_address',
                'location_office',
                'program_kerja_count',
                'main_event_count'
            ];

            foreach ($textSettings as $setting) {
                if ($request->has($setting)) {
                    AboutSetting::set($setting, $request->$setting);
                }
            }

            // Handle misi (array to string with | separator)
            if ($request->has('misi')) {
                $misiString = implode('|', array_filter($request->misi));
                AboutSetting::set('misi', $misiString);
            }

            // Handle logo image upload
            if ($request->hasFile('logo_image')) {
                $oldImage = AboutSetting::get('logo_image');

                // Delete old image if it's not the default
                if ($oldImage && $oldImage !== 'img/logo.png' && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                // Store new image
                $imagePath = $request->file('logo_image')->store('about', 'public');
                AboutSetting::set('logo_image', 'storage/' . $imagePath);
            }

            return redirect()->route('admin.about.index')
                ->with('success', 'Pengaturan About berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
