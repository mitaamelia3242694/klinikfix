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
}