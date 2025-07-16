<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
     protected $table = 'rekam_medis';
    protected $fillable = ['pasien_id', 'tanggal_kunjungan', 'keluhan', 'diagnosa', 'tindakan_id', 'catatan_tambahan'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }
}