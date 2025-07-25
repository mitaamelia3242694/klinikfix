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
        Schema::create('sediaan_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obat');
            $table->date('tanggal_kadaluarsa');
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sediaan_obat');
    }
};