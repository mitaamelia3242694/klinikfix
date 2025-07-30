<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranSebelumnya extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_sebelumnya';
    protected $fillable = [
        'tanggal_pendaftaran',
        'keluhan',
        'diagnosa_awal',
        'diagnosa_akhir',
        'resep_obat'
    ];

    public function pendaftaran() {
        return $this->hasMany(Pendaftaran::class, 'pendaftaran_sebelumnya_id');
    }
}
