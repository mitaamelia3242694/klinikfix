<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengkajianAwal extends Model
{
    protected $table = 'pengkajian_awal';
    protected $fillable = [
        'pendaftaran_id',
        'user_id',
        'tanggal',
        'status',
        'keluhan_utama',
        'tekanan_darah',
        'suhu_tubuh',
        'catatan',
        'pelayanan_id',
        'diagnosa_awal'
    ];

 

    public function perawat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class);
    }

    public function pendaftaran()
    {
        return $this->belongsTo(PengkajianAwal::class,'pendaftaran_id');
    }

    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }
}
