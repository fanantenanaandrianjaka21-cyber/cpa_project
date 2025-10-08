<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'nom',
        'id_utilisateur',
        'priorite',
        'id_materiel',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'id_utilisateur');
    }

    public function materiels()
    {
        return $this->hasMany(Materiel::class, 'id', 'id_materiel');
    }
}
