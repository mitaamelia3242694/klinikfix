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
            $table->unsignedBigInteger('pelayanan_id')->nullable()->after('catatan');
            $table->text('diagnosa_awal')->nullable()->after('pelayanan_id');

            $table->foreign('pelayanan_id')->references('id')->on('pelayanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengkajian_awal', function (Blueprint $table) {
            $table->dropForeign(['pelayanan_id']);
            $table->dropColumn(['pelayanan_id', 'diagnosa_awal']);
        });
    }
};
