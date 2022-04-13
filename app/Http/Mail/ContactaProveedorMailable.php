<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactaProveedorMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Confirmación de pedido";
    public $Req;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Req){

        $this->Req = $Req;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.Proveedor');
    }
}
