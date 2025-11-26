<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailCodeVerification extends Mailable
{
    use Queueable, SerializesModels;

    public array $donnees; // données à envoyer à la vue

    /**
     * Créer une nouvelle instance du message.
     */
    public function __construct(array $donnees)
    {
        $this->donnees = $donnees;
    }

    /**
     * Définir l'enveloppe (sujet, adresse...).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vérification de votre Email'
        );
    }

    /**
     * Définir le contenu du mail.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.code_verification', // ta vue Blade
            with: [
                'nom_utilisateur' => $this->donnees['nom_utilisateur'],
                'code'            => $this->donnees['code'],
            ]
        );
    }

    /**
     * Pièces jointes éventuelles.
     */
    public function attachments(): array
    {
        return [];
    }
}
