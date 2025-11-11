<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristiqueSupplementaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_materiel',
        'cle',
        'valeur',

    ];
    protected $table = 'caracteristique_supplementaires';

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'id_materiel');
    }
}
