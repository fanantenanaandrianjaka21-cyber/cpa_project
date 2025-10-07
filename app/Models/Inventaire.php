<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_materiel',
        'composant_manquant',
        'composant_non_enregistre',
        'etat',
        'observation',
        'date_inventaire',

    ];
}
