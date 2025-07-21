<?php
// database/migrations/2024_01_01_000006_create_members_table_simplified.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('members');

        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // Student Reference (REQUIRED - no manual input)
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // Essential Organization Data Only
            $table->string('position');                    // Jabatan: Ketua, Wakil Ketua, etc
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->integer('position_level');             // 1=Ketua, 2=Wakil, 3=Kepala Divisi, 4=Anggota
            $table->date('start_date')->nullable();        // Mulai menjabat
            $table->date('end_date')->nullable();          // Berakhir menjabat

            // Organization Status
            $table->enum('status', ['active', 'inactive', 'alumni'])->default('active');
            $table->boolean('is_active')->default(true);

            // Optional Organization Info
            $table->text('motivation')->nullable();        // Motivasi bergabung
            $table->text('notes')->nullable();             // Catatan admin

            $table->timestamps();

            // Indexes for performance
            $table->index(['division_id', 'is_active']);
            $table->index(['status', 'is_active']);
            $table->index('position_level');
            $table->unique('student_id');                  // One student = one member
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};
