<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaPegawai extends Model
{
    use HasFactory;

    protected $fillable = ['agenda_id', 'pegawai_id'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
