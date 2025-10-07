<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Materiel;
use App\Models\User;

class Affectation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_materiel',
        'id_emplacement',
        'id_utilisateur',
        'date_affectation',
    ];
    public function materiels()
    {
        return $this->hasMany(Materiel::class, 'id', 'id_materiel');
    }
    public function utilisateurs()
    {
        return $this->hasMany(User::class, 'id', 'id_utilisateur');
    }
}
