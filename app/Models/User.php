<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'bidang_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            // Format: USER-{YEAR}-{SERIAL_NUMBER}
            $latestUser = User::latest('id')->first();
            $nextId = $latestUser ? $latestUser->id + 1 : 1;
            $user->custom_id = 'USER-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        });
    }

    public function getBidangNameAttribute()
    {
        $bidangNames = [
            1 => 'Bidang Sekretaris',
            2 => 'Bidang Pencegahan & Kesiapsiagaan',
            3 => 'Bidang Kedaruratan & Logistik',
            4 => 'Bidang Rehabilitasi & Rekonstruksi',
            5 => 'Bidang Lainnya',
        ];

        return $bidangNames[$this->bidang_id] ?? 'Tidak Diketahui';
    }

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_user', 'user_id', 'agenda_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class); // Relasi belongsTo ke model Role
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class); // Relasi belongsTo ke model Bidang
    }

    public function getRoleNameAttribute()
    {
        return $this->role ? $this->role->name : null; // Mengembalikan nama role, atau null jika tidak ada role
    }

    
}
