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
        'priority_number',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'agenda_user', 'agenda_id', 'user_id');
    }
    // Konversi JSON ke array otomatis
    protected $casts = [
        'list_daftar_nama' => 'array',
    ];
    // number prioritas untuk logika tabel
    public static function generatePriorityNumber($kategori)
    {
        // Tentukan prefix berdasarkan kategori
        $prefix = match ($kategori) {
            'Biasa' => 'B',
            'Penting' => 'P',
            'Rapat' => 'R',
            default => 'X', // Kategori tidak dikenal
        };

        // Ambil nomor terakhir dari kategori yang sama
        $lastPriority = self::where('priority_number', 'like', "$prefix%")
            ->orderBy('priority_number', 'desc')
            ->pluck('priority_number')
            ->first();

        // Ekstrak angka dari nomor terakhir
        $nextNumber = $lastPriority ? ((int) substr($lastPriority, 1)) + 1 : 1;

        // Format nomor prioritas baru (contoh: P001)
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
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
