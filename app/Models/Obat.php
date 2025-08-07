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
        return $this->hasMany(PengambilanObatDetail::class, 'sediaan_obat_id');
    }
}
