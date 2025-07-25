<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{

    public $timestamps = true;

    protected $table = 'pendaftaran';
    protected $fillable = [
        'pasien_id',
        'jenis_kunjungan',
        'dokter_id',
        'tindakan_id',
        'asal_pendaftaran_id',
        'status',
        'perawat_id',
        'keluhan'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }

    public function asalPendaftaran()
    {
        return $this->belongsTo(AsalPendaftaran::class);
    }

    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }



    public function pengkajianAwal()
    {
        return $this->hasOne(PengkajianAwal::class);
    }


    public function diagnosaAwal()
    {
        return $this->hasOne(Diagnosaawal::class, 'pasien_id', 'pasien_id');
    }
    public function diagnosaAkhir()
    {
        return $this->hasOne(DiagnosaAkhir::class, 'pasien_id', 'pasien_id');
    }
}
