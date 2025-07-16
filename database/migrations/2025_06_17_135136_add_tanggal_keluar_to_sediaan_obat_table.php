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
        Schema::table('sediaan_obat', function (Blueprint $table) {
            $table->date('tanggal_keluar')->nullable()->after('tanggal_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sediaan_obat', function (Blueprint $table) {
            $table->dropColumn('tanggal_keluar');
        });
    }
};
