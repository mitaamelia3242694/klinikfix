<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
     protected $table = 'asuransi';
    protected $fillable = ['nama_perusahaan', 'nomor_polis', 'jenis_asuransi', 'masa_berlaku_mulai', 'masa_berlaku_akhir', 'status'];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
