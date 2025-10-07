<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\CaracteristiqueSupplementaire;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materiel extends Model
{
    use HasFactory,LogsActivity;
    protected static $recordEvents = ['created','updated','deleted'];
    protected $fillable = [
        'id_emplacement',
        'id_utilisateur',
        'code_interne',
        'type',
        'marque',
        'model',
        'num_serie',
        'status',
        'image',
        'date_aquisition',
    ];

    public function getActivitylogOptions():LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['type','model','id_emplacement'])
            ->useLogName('materiel')
            ->setDescriptionForEvent(fn(string $eventName) => "Matériel {$eventName}")
            // ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    // --- 🔥 Ajouter la journalisation dans le log Laravel (LogViewer) ---
    protected static function booted()
    {
        static::created(function ($materiel) {
            $user = Auth::user();
            Log::info('Matériel créé : ' . $materiel->type . ' (ID: '.$materiel->id.') par ' . optional($user)->nom_utilisateur);

            // Spatie log déjà automatique via LogsActivity
        });

        static::updated(function ($materiel) {
            $user = Auth::user();
            Log::info('Matériel mis à jour : ' . $materiel->type . ' (ID: '.$materiel->id.') par ' . optional($user)->nom_utilisateur);
        });

        static::deleted(function ($materiel) {
            $user = Auth::user();
            Log::info('Matériel supprimé : ' . $materiel->type . ' (ID: '.$materiel->id.') par ' . optional($user)->nom_utilisateur);
        });
    }
    public function caracteristiques()
    {
        // return $this->hasMany(CaracteristiqueSupplementaire::class);//automatique id_materiel ny cle etranger
        return $this->hasMany(CaracteristiqueSupplementaire::class, 'id_materiel', 'id');
    }
    public function utilisateurs()
    {
        return $this->hasMany(User::class, 'id', 'id_utilisateur');
    }
}
