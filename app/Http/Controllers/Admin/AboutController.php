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
        $settings = AboutSetting::all()->keyBy('key');
        return view('admin.about.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'about_title' => 'required|string|max:255',
            'about_subtitle' => 'required|string|max:255',
            'about_description' => 'required|string',
            'history_title' => 'required|string|max:255',
            'location_title' => 'required|string|max:255',
            'location_subtitle' => 'required|string|max:255',
            'location_address' => 'required|string',
            'location_office' => 'required|string',
            'about_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        foreach ($request->except(['_token', 'about_logo']) as $key => $value) {
            AboutSetting::setValue($key, $value);
        }

        if ($request->hasFile('about_logo')) {
            $oldLogo = AboutSetting::getValue('about_logo');
            if ($oldLogo && $oldLogo !== 'img/logo.png') {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $request->file('about_logo')->store('about', 'public');
            AboutSetting::setValue('about_logo', $logoPath, 'image');
        }

        return redirect()->route('admin.about.index')->with('success', 'Pengaturan About berhasil diperbarui!');
    }
}
