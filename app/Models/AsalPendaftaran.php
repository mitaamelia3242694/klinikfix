<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsalPendaftaran extends Model
{
    protected $table = 'asal_pendaftaran';
    protected $fillable = ['nama'];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'asal_pendaftaran_id');
    }
}
