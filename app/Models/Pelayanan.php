<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
     protected $table = 'pelayanan';
    protected $fillable = ['nama_pelayanan', 'deskripsi', 'biaya', 'status'];
}
