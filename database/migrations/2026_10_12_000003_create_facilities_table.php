<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('category', ['laboratorium', 'bengkel', 'ruang_kelas', 'sarana_olahraga', 'fasilitas_umum']);
            $table->text('description')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->integer('capacity')->default(30);
            $table->enum('condition', ['sangat_baik', 'baik', 'pemeliharaan'])->default('baik');
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
