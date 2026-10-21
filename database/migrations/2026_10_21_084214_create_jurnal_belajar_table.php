<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jurnal_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('konten_edukasi_id')->constrained('konten_edukasi')->cascadeOnDelete(); // Foreign key ke tabel konten_edukasi. Jika artikel dihapus admin, jurnal terkait ikut terhapus agar tidak jadi data yatim (orphan)
            $table->text('ringkasan');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->enum('status', ['sedang_dibaca', 'selesai'])->default('sedang_dibaca');
            $table->timestamps();

            $table->unique(['user_id', 'konten_edukasi_id']); // Mencegah 1 user yang sama membuat 2 jurnal untuk 1 artikel yang sama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_belajar');
    }
};
