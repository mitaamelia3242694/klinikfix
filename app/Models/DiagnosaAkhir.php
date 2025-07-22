<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosaAkhir extends Model
{
    protected $table = 'diagnosa_akhir';
    protected $fillable = [
        'pasien_id',
        'user_id',
        'tanggal',
        'diagnosa',
        'catatan',
        'master_diagnosa_id',
        'pelayanan_id',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(DiagnosaAkhir::class, 'pendaftaran_id');
    }

    public function pendaftarans()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }


    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke user (dokter)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masterDiagnosa()
    {
        return $this->belongsTo(MasterDiagnosa::class);
    }

    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class);
    }

    public function pengkajianAwal()
    {
        return $this->belongsTo(PengkajianAwal::class, 'pengkajian_awal_id');
    }
}
