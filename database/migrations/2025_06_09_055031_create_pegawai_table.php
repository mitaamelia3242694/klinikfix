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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nip')->nullable();
            $table->string('nama_lengkap');
            $table->string('gelar')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('ttl');
            $table->text('alamat');
            $table->string('email')->nullable();
            $table->string('no_telp');
            $table->string('str')->nullable();
            $table->string('sip')->nullable();
            $table->foreignId('jabatan_id')->constrained('jabatan');
            $table->string('instansi_induk')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
