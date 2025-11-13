<?php

namespace App\enums;

use App\Models\TicketPrioriteConfig;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self TRES_BASSE()
 * @method static self BASSE()
 * @method static self MOYENNE()
 * @method static self URGENT()
 */
final class TicketPriorite extends Enum
{
    /**
     * Retourne la couleur associée à chaque statut.
     */
    // public function color(): string
    // {
    //     return match ($this->value) {
    //         'NOUVEAU' => '#007bff',  // Bleu
    //         'EN_COURS' => '#fd7e14', // Orange
    //         'RESOLU' => '#28a745',   // Vert
    //         'FERME' => '#6c757d',    // Gris
    //         default => '#000000',
    //     };
    // }

    /**
     * Retourne un label lisible.
     */
    // public function label(): string
    // {
    //     return match ($this->value) {
    //         'NOUVEAU' => 'Nouveau',
    //         'EN_COURS' => 'En cours',
    //         'RESOLU' => 'Résolu',
    //         'FERME' => 'Fermé',
    //         default => 'Inconnu',
    //     };
    // }

    // code dynamique
    public function color(): string
{
    return TicketPrioriteConfig::find($this->value)?->color ?? '#000000';
}

public function label(): string
{
    return TicketPrioriteConfig::find($this->value)?->label ?? 'Inconnu';
}

}
