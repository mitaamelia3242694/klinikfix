<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';
    protected $fillable = ['nama_obat', 'satuan_id', 'stok_total', 'keterangan'];

    public function satuan()
    {
        return $this->belongsTo(SatuanObat::class);
    }

    public function sediaan()
    {
        return $this->hasMany(SediaanObat::class);
    }

    public function resepDetails()
    {
        return $this->hasMany(\App\Models\ResepDetail::class, 'obat_id');
    }

    public function sediaanObat()
    {
        return $this->hasMany(SediaanObat::class, 'obat_id');
    }

    public function pengambilanDetails()
    {
        // Relasi melalui sediaan obat
        return $this->hasManyThrough(
            PengambilanObatDetail::class,
            SediaanObat::class,
            'obat_id', // Foreign key di sediaan_obat
            'sediaan_obat_id', // Foreign key di pengambilan_obat_detail
            'id', // Local key di obat
            'id' // Local key di sediaan_obat
        );
    }
}
