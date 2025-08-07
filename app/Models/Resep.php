<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $fillable = ['pasien_id', 'user_id', 'tanggal', 'catatan',   'pelayanan_id'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function role()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Relasi ke resep_detail
    public function detail()
    {
        return $this->hasMany(ResepDetail::class, 'resep_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class);
    }

    public function pengambilanObat()
    {
        return $this->hasOne(PengambilanObat::class, 'resep_id');
    }
}
