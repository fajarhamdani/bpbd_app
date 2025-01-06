<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $fillable = ['name', 'nip', 'bidang_id', 'is_verified', 'role_id'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($pegawai) {
            if ($pegawai->is_verified && self::where('nip', $pegawai->nip)->where('is_verified', true)->exists()) {
                throw ValidationException::withMessages(['nip' => 'Pegawai dengan NIP ini sudah diverifikasi sebelumnya.']);
            }
        });
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function agendaPegawai()
    {
        return $this->hasMany(AgendaPegawai::class);
    }
}
