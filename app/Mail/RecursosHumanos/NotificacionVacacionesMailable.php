<?php

namespace App\Mail\RecursosHumanos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionVacacionesMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Solicitud de vacaciones";
    public $Vac;

    public function __construct($Vac){
        $this->Vac = $Vac;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('mail.NotificacionVacaciones');
    }
}
