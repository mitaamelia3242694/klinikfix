<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SediaanObat extends Model
{
    protected $table = 'sediaan_obat';
    protected $fillable = [
        'obat_id',
        'jumlah',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'keterangan',
        'tanggal_keluar'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function pengambilanDetails()
{
    return $this->hasMany(PengambilanObatDetail::class, 'sediaan_obat_id')
                ->with(['pengambilanObat' => function($query) {
                    $query->select('id', 'tanggal_pengambilan');
                }]);
}
}
