<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanObatDetail extends Model
{
    use HasFactory;

    protected $table = 'pengambilan_obat_detail';
    protected $fillable = ['pengambilan_obat_id', 'resep_detail_id', 'sediaan_obat_id', 'jumlah_diambil'];
    public function pengambilanObat()
    {
        return $this->belongsTo(PengambilanObat::class);
    }
}
