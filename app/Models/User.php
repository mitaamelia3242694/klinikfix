<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = ['username', 'password', 'role_id', 'nama_lengkap', 'email', 'status'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }

    // app/Models/User.php

    public function getRoleNameAttribute()
    {
        return match ($this->role_id) {
            1 => 'admin it',
            2 => 'admin pendaftaran',
            3 => 'dokter',
            4 => 'perawat',
            5 => 'apoteker',
            6 => 'admin stok obat',
            default => 'tidak diketahui',
        };
    }
}
