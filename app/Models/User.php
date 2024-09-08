<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kelas', // Menambahkan atribut kelas
        'school_name', // Menambahkan atribut nama_sekolah
        'image', // Menambahkan atribut image untuk menyimpan path gambar
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // Relasi dengan tabel roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    // Metode untuk memeriksa peran pengguna
    public function checkRole($role)
    {
        return $this->role === $role;
    }

    public function komens(): HasMany
    {
        return $this->hasMany(Komen::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Menghapus komentar yang terkait ketika user dihapus
        static::deleting(function ($user) {
            $user->komens()->delete();
        });
    }

    // Definisikan relasi ke model Work
    public function works()
    {
        return $this->hasMany(Work::class);
    }
}
