<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelayananTindakan extends Model
{
    protected $table = 'pelayanan_tindakan';
    protected $fillable = ['pelayanan_id', 'tindakan_id'];

    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class);
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }
}
