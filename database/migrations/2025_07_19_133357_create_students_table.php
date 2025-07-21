<?php
// database/migrations/2024_01_01_000003_create_students_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('nim')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('batch'); // angkatan
            $table->string('work_photo')->nullable(); // foto baju kerja himatekom
            $table->string('casual_photo')->nullable(); // foto bebas
            $table->string('validation_document')->nullable(); // KRS/KTM untuk validasi
            $table->json('skills')->nullable(); // keahlian (array)
            $table->json('hobbies')->nullable(); // hobi (array)
            $table->string('career_goal')->nullable(); // tujuan karir
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('github')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->text('bio')->nullable(); // bio singkat
            $table->string('current_job')->nullable(); // pekerjaan saat ini (jika ada)
            $table->string('hometown')->nullable(); // asal daerah
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable(); // alasan penolakan jika ditolak
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_public')->default(true); // apakah ditampilkan di public
            $table->timestamps();

            // Indexes
            $table->index(['status', 'is_active']);
            $table->index(['batch', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
