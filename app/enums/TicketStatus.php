<?php

namespace App\Enums;

use App\Models\TicketStatusConfig;

enum TicketStatus: string
{
    case NOUVEAU = 'NOUVEAU';
    case ATTRIBUE = 'ATTRIBUE';
    case EN_COURS = 'EN_COURS';
    case PLANIFIE = 'PLANIFIE';
    case EN_ATTENTE = 'EN_ATTENTE';
    case RESOLU = 'RESOLU';
    case FERME = 'FERME';

    /**
     * Retourne la couleur associée à ce statut.
     */
    public function color(): string
    {
        return TicketStatusConfig::find($this->value)?->color ?? '#000000';
    }

    /**
     * Retourne le libellé associé à ce statut.
     */
    public function label(): string
    {
        return TicketStatusConfig::find($this->value)?->label ?? 'Inconnu';
    }
}
