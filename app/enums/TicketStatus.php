<?php

namespace App\enums;

use App\Models\TicketStatusConfig;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self NOUVEAU()
 * @method static self ATTRIBUE()
 * @method static self EN_COURS()
 * @method static self PLANIFIE()
 * @method static self EN_ATTENTE()
 * @method static self RESOLU()
 * @method static self FERME()
 */
final class TicketStatus extends Enum
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
    return TicketStatusConfig::find($this->value)?->color ?? '#000000';
}

public function label(): string
{
    return TicketStatusConfig::find($this->value)?->label ?? 'Inconnu';
}

}
