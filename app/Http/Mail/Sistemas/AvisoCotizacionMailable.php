<?php

namespace App\Mail\Sistemas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoCotizacionMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Cotizacion de Material de Sistemas";
    public $Sis;

    public function __construct($Sis){
        $this->Sis = $Sis;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('mail.AvisoCotizacion');
    }
}
