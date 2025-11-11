<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
        protected $fillable = [
// 'email_destinataire',
// 'niveau_seuil',
// 'niveau_critique',
// 'type_materiel',
'par_jour',
'heure_envoie_par_jour',
'hebdomadaire',
'jour_du_semaine',
'heure_envoie_par_semaine',
    ];
        public function types()
    {
        return $this->hasMany(Alertes_types::class,'id', 'alerte_id');
    }

    public function destinataires()
    {
        return $this->hasMany(Alertes_destinataires::class,'id', 'alerte_id');
    }
}
