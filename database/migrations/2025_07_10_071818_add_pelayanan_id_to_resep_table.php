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
        Schema::table('resep', function (Blueprint $table) {
            $table->foreignId('pelayanan_id')
                ->after('user_id')
                ->nullable()
                ->constrained('pelayanan')
                ->nullOnDelete(); // Jika pelayanan dihapus, set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resep', function (Blueprint $table) {
            $table->dropForeign(['pelayanan_id']);
            $table->dropColumn('pelayanan_id');
        });
    }
};
