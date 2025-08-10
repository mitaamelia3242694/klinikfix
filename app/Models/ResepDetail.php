<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepDetail extends Model
{
    protected $table = 'resep_detail';
    protected $fillable = ['resep_id', 'obat_id', 'jumlah', 'dosis', 'aturan_pakai'];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    // Di model ResepDetail.php
    public function sediaanObat()
    {
        return $this->belongsTo(SediaanObat::class, 'obat_id', 'obat_id');
    }

    public function pengambilanObatDetail()
    {
        return $this->hasOne(PengambilanObatDetail::class, 'resep_detail_id');
    }

    public function scopeSudahDiambil($query)
{
    return $query->whereHas('pengambilanObat', function ($q) {
        $q->where('status', 'sudah diambil'); // atau status yang sesuai dengan pengambilan berhasil
    });
}
}
