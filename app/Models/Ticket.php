<?php

namespace App\Models;

use App\enums\TicketPriorite;
use App\enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use HasFactory;
    use HasFactory, LogsActivity;
    protected static $recordEvents = ['created', 'updated', 'deleted'];
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['type', 'objet', 'id_utilisateur', 'description', 'assignement', 'statut', 'fichier'])
            ->useLogName('ticket')
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
            // ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
