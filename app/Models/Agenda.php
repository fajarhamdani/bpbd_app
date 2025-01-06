<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agenda';

    protected $fillable = [
        'nama_acara',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'list_daftar_nama',
        'report',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'agenda_user', 'agenda_id', 'user_id');
    }
    // Konversi JSON ke array otomatis
    protected $casts = [
        'list_daftar_nama' => 'array',
    ];
    
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function agendaPegawai()
    {
        return $this->hasMany(AgendaPegawai::class);
    }
}
