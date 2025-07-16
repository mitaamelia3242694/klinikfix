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
        Schema::create('diagnosa_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien');
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal');
            $table->text('diagnosa');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosa_akhir');
    }
};
