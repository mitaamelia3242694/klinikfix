<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanObat extends Model
{
    protected $table = 'pengambilan_obat';
    protected $fillable = ['resep_id', 'user_id', 'tanggal_pengambilan', 'status_checklist'];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }

    public function apoteker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Relasi ke petugas
    }
    public function details()
    {
        return $this->hasMany(PengambilanObatDetail::class, 'pengambilan_obat_id');
    }
}
