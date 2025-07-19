<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosaAwal extends Model
{
    protected $table = 'diagnosa_awal';
    protected $fillable = [
        'pasien_id',
        'user_id',
        'tanggal',
        'diagnosa',
        'catatan',
        'master_diagnosa_id',
        'status',
        'pelayanan_id',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function perawat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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
    public function pendaftaran()
    {
         return $this->belongsTo(Pendaftaran::class);
    }
}
