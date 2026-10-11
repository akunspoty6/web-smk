<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code', 25)->unique();
            $table->foreignId('major_id')->constrained('majors')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('alternative_major_id')->nullable()->constrained('majors')->cascadeOnUpdate()->nullOnDelete();
            $table->string('nisn', 10)->unique();
            $table->string('nik', 16);
            $table->string('full_name', 150);
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('religion', 30)->default('Islam');
            $table->string('previous_school', 150);
            $table->string('student_phone', 20);
            $table->string('parent_phone', 20);
            $table->text('address');
            $table->decimal('report_card_score', 5, 2);
            $table->string('document_kk_path', 255)->default('default_kk.pdf');
            $table->string('document_raport_path', 255)->default('default_rapor.pdf');
            $table->string('document_photo_path', 255)->default('default_foto.jpg');
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('nisn');
            $table->index('registration_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
