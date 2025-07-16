<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = 'tindakan';
    protected $fillable = ['pasien_id', 'user_id', 'tanggal', 'jenis_tindakan', 'tarif', 'catatan'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke user (dokter)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diagnosa()
    {
        return $this->belongsTo(DiagnosaAwal::class, 'diagnosa_id');
    }
}
