<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatDokter extends Model
{
    protected $table = 'perawat_dokter';
    protected $fillable = ['perawat_id', 'dokter_id'];



    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }
}
