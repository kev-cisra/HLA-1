<?php

namespace App\Mail\Sistemas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CotizacionSistemasMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Cotizacion de sistemas";
    public $Sis;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Sis){
        $this->Sis = $Sis;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.CotizacionSistemas');
    }
}
