<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'bidang';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class);
    }
}
