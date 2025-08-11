<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $fillable = ['pendaftaran_id', 'pasien_id', 'user_id', 'pelayanan_id', 'tanggal', 'catatan'];

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

    public function pengambilanObatDetail() {
        return $this->hasMany(PengambilanObatDetail::class, 'resep_id');
    }
}
