<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jurnal_belajar', function (Blueprint $table) {
            $table->date('target_selesai')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('jurnal_belajar', function (Blueprint $table) {
            $table->dropColumn('target_selesai');
        });
    }
};