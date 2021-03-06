<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;


class Mensaje extends Mailable
{
    use Queueable, SerializesModels;


    /**
    * @var 
    **/
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.test')
            ->with('user', $this->user)
            ->from('admin@lbdistribuciones.com', 'Administrador')
            ->subject('Prueba de mail');
    }
}
