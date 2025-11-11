<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'id_emplacement', // emplacement
        'nom_utilisateur',
        'prenom_utilisateur',
        'email',
        'password',
        'equipe',
        'societe',
        'contact_utilisateur',
        'role',

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function materiel()
    // {
    //     return $this->hasMany(Materiel::class,'id_utilisateur','id');
    // }
    //     public function emplacement()
    // {
    //     return $this->hasMany(Emplacement::class,'id','id_emplacement');
    // }
    public function emplacement()
    {
        return $this->belongsTo(Emplacement::class, 'id_emplacement');
    }

    public function materiels()
    {
        return $this->hasMany(Materiel::class, 'id_utilisateur', 'id');
    }
}
