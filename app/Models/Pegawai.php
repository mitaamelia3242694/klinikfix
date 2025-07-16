<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
     protected $table = 'pegawai';
    protected $fillable = ['nik', 'nip', 'nama_lengkap', 'gelar', 'jenis_kelamin', 'ttl', 'alamat', 'email', 'no_telp', 'str', 'sip', 'jabatan_id', 'instansi_induk', 'tanggal_berlaku', 'user_id'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
