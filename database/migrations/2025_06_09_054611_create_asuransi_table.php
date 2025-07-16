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
        Schema::create('asuransi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('nomor_polis');
            $table->string('jenis_asuransi');
            $table->date('masa_berlaku_mulai');
            $table->date('masa_berlaku_akhir');
            $table->enum('status', ['Aktif', 'Tidak Aktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asuransi');
    }
};
