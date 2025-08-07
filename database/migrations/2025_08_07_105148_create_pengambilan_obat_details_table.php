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
        Schema::create('pengambilan_obat_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengambilan_obat_id')->constrained()->onDelete('cascade');
            $table->foreignId('resep_detail_id')->constrained('resep_detail')->onDelete('cascade');
            $table->foreignId('sediaan_obat_id')->constrained('sediaan_obat')->onDelete('cascade');
            $table->integer('jumlah_diambil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengambilan_obat_details');
    }
};
