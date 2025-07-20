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
        Schema::table('pengkajian_awal', function (Blueprint $table) {
            $table->enum('status', ['sudah', 'belum'])
                ->default('belum')
                ->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengkajian_awal', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
