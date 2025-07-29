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
        Schema::table('pendaftaran', function (Blueprint $table) {
              $table->unsignedBigInteger('pendaftaran_sebelumnya_id')->nullable()->after('id');

            $table->foreign('pendaftaran_sebelumnya_id')
                  ->references('id')->on('pendaftaran')
                  ->onDelete('set null'); // Jika pendaftaran sebelumnya dihapus, set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
              $table->dropForeign(['pendaftaran_sebelumnya_id']);
            $table->dropColumn('pendaftaran_sebelumnya_id');
        });
    }
};
