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
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biota_id')->constrained('biota')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('isi');
            $table->timestamps();

            $table->index(['biota_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};
