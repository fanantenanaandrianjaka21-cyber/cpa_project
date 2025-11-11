<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlerteStockMail extends Mailable
{
    use Queueable, SerializesModels;

    public $materielpartype;
    public $alert;
    public $detail_mouvements;

    /**
     * Create a new message instance.
     */
    public function __construct($materielpartype, $alert,$detail_mouvements)
    {
        $this->materielpartype = $materielpartype;
        $this->alert = $alert;
        $this->detail_mouvements=$detail_mouvements;
    }

    /**
     * Build the message.
     */
    //  public function build()
    // {
    //     return $this->subject('📦 Rapport d’alerte de stock')
    //                 ->view('emails.alerte_stock')
    //                 ->with([
    //                     'materielpartype' => $this->materielpartype,
    //                     'alert' => $this->alert,
    //                 ]);
    // }
    public function build()
    {
        return $this->subject('Alerte de stock pour ')
                    ->markdown('emails.alerte_stock');
    }
}
