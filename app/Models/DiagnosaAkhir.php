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

    public function dokter()
    {
        return $this->belongsTo(User::class, 'user_id');
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
}
