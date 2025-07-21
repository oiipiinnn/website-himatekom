<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default values
        DB::table('about_settings')->insert([
            ['key' => 'title', 'value' => 'Siapa Kami?', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'subtitle', 'value' => 'Tentang Himatekom', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'description', 'value' => 'Himpunan Mahasiswa Teknik Komputer (Himatekom) adalah organisasi mahasiswa yang berdedikasi untuk mendukung pertumbuhan akademik dan profesional anggotanya.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'logo_image', 'value' => 'img/logo.png', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'visi', 'value' => 'Menjadi himpunan mahasiswa yang unggul dalam mengembangkan potensi mahasiswa Teknik Komputer di bidang akademik, teknologi, dan kepemimpinan.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'misi', 'value' => 'Mengembangkan kompetensi mahasiswa melalui program kerja yang inovatif dan berkelanjutan|Memfasilitasi pengembangan soft skill dan hard skill mahasiswa|Membangun networking yang kuat dengan industri dan alumni|Menciptakan lingkungan akademik yang kondusif untuk pertumbuhan mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'history_title', 'value' => 'Perjalanan Himatekom', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'location_title', 'value' => 'Lokasi Kami', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'location_subtitle', 'value' => 'Sekretariat Himatekom', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'location_address', 'value' => 'Fakultas Teknologi Informasi, Kampus Unand Limau Manis, Padang, Sumatera Barat', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'location_office', 'value' => 'Ruang Sekretariat Himatekom FTI', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'program_kerja_count', 'value' => '25', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'main_event_count', 'value' => '3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('about_settings');
    }
};
