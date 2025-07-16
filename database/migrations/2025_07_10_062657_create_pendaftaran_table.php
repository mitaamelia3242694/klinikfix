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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->string('jenis_kunjungan', 50); // "baru" atau "lama"
            $table->unsignedBigInteger('dokter_id');
            $table->unsignedBigInteger('tindakan_id')->nullable();
            $table->unsignedBigInteger('asal_pendaftaran_id')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('perawat_id')->nullable();
            $table->text('keluhan')->nullable();
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('pasien');
            $table->foreign('dokter_id')->references('id')->on('users');
            $table->foreign('tindakan_id')->references('id')->on('tindakan');
            $table->foreign('asal_pendaftaran_id')->references('id')->on('asal_pendaftaran');
            $table->foreign('perawat_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};