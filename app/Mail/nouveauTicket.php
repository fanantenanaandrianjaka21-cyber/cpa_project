<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class nouveauTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $ticket;
    public $demandeur;
    public function __construct($ticket, $demandeur)
    {
        $this->ticket = $ticket;
        $this->demandeur = $demandeur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('ticketing.responsable.mail')
                    ->with([
                        'ticket' => $this->ticket,
                    ]);
    }
}
