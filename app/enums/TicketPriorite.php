<?php

namespace App\enums;

use App\Models\TicketPrioriteConfig;

enum TicketPriorite: string
{
    // case TRES_BASSE = 'TRES_BASSE';
    case BASSE = 'BASSE';
    case MOYENNE = 'MOYENNE';
    case URGENT = 'URGENT';

    /**
     * Retourne la couleur associée à chaque priorité.
     */
    public function color(): string
    {
        return TicketPrioriteConfig::find($this->value)?->color ?? '#000000';
    }

    /**
     * Retourne le label associé à chaque priorité.
     */
    public function label(): string
    {
        return TicketPrioriteConfig::find($this->value)?->label ?? 'Inconnu';
    }
}
