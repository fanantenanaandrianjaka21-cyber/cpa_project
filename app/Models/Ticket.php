<?php

namespace App\Models;

use App\Enums\TicketPriorite;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'objet',
        'id_utilisateur',
        'priorite',
        'description',
        'assignement',
        'statut',
        'fichier',
    ];
    protected $casts = [
        'statut' => TicketStatus::class,
        'priorite' => TicketPriorite::class,
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id', 'id_utilisateur');
    }

    public function materiels()
    {
        return $this->hasMany(Materiel::class, 'id', 'id_materiel');
    }

    // relation en utilisant belongs to
    public function utilisateur()
{
    return $this->belongsTo(User::class, 'id_utilisateur');
}

public function materiel()
{
    return $this->belongsTo(Materiel::class, 'id_materiel');
}
    public function technicien()
{
    return $this->belongsTo(User::class, 'assignement');
}
}
