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
        Schema::create('pendaftaran_sebelumnya', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pendaftaran')->nullable();
            $table->string('keluhan')->nullable();
            $table->string('diagnosa_awal')->nullable();
            $table->string('diagnosa_akhir')->nullable();
            $table->string('resep_obat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_sebelumnya');
    }
};
