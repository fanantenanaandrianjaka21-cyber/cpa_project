<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alertes_destinataires extends Model
{
    use HasFactory;
            protected $fillable = [
'alerte_id',
'email_destinataire',
    ];
            public function alerte()
    {
        return $this->belongsTo(Alert::class, 'alerte_id');
    }
}
