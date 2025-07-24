<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanObat extends Model
{
     protected $table = 'satuan_obat';
    protected $fillable = ['nama_satuan'];

    public function obat()
    {
        return $this->hasMany(Obat::class);
    }

    public function resepDetails()
{
    return $this->hasMany(ResepDetail::class, 'sediaan_id');
}

}
