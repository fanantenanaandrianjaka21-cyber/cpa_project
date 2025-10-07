<?php

namespace App\Models;

use App\Models\User;
use App\Models\Emplacement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MouvementStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_materiel',
        'type_mouvement',
        'source',
        'emplacement_destination',
        'utilisateur_destination',
    ];
    public function utilisateurs()
    {
        return $this->hasMany(User::class, 'id', 'utilisateur_destination');
    }
}
