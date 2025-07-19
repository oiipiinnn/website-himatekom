<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $aboutData = [
            'title' => AboutSetting::getValue('about_title', 'Siapa Kami?'),
            'subtitle' => AboutSetting::getValue('about_subtitle', 'Tentang Himatekom'),
            'description' => AboutSetting::getValue('about_description', 'Himpunan Mahasiswa Teknik Komputer (Himatekom) adalah organisasi mahasiswa yang berdedikasi untuk mendukung pertumbuhan akademik dan profesional anggotanya.'),
            'history_title' => AboutSetting::getValue('history_title', 'History'),
            'logo_image' => AboutSetting::getValue('about_logo', 'img/logo.png'),
            'location_title' => AboutSetting::getValue('location_title', 'Find Us'),
            'location_subtitle' => AboutSetting::getValue('location_subtitle', 'Our Location'),
            'location_address' => AboutSetting::getValue('location_address', 'Jalan Limau Manis No. 50, Padang, Sumatera Barat'),
            'location_office' => AboutSetting::getValue('location_office', 'Sekretariat Himatekom, Fakultas Teknologi Informasi Lt 1'),
        ];

        return view('about', compact('aboutData'));
    }
}
