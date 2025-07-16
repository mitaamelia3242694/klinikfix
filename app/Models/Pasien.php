<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{

    protected $table = 'pasien';

    protected $fillable = ['asuransi_id', 'NIK', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp', 'tanggal_daftar'];

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }

    public function asuransi()
    {
        return $this->belongsTo(Asuransi::class);
    }

    public function diagnosas()
    {
        return $this->hasMany(DiagnosaAwal::class, 'pasien_id');
    }

    // app/Models/Pasien.php

    public function diagnosaAwal()
    {
        return $this->hasOne(DiagnosaAwal::class)->latestOfMany();
    }

    public function diagnosaAkhir()
    {
        return $this->hasOne(DiagnosaAkhir::class)->latestOfMany();
    }
}
