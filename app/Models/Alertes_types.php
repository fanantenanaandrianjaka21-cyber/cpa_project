<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alertes_types extends Model
{
    use HasFactory;
    protected $fillable = [
        'alerte_id',
        'niveau_seuil',
        'niveau_critique',
        'type_materiel',
    ];
        public function alerte()
    {
        return $this->belongsTo(Alert::class, 'alerte_id');
    }
}
