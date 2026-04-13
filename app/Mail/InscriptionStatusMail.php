<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscriptionStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $role;
    public $name;
    public $password;

    public function __construct($status, $role, $name, $password = null)
    {
        $this->status = $status;
        $this->role = $role;
        $this->name = $name;
        $this->password = $password;
    }

    public function build()
    {
        $subject = $this->status === 'Aprobada' 
            ? "¡Bienvenido a la Fundación! Inscripción Aprobada" 
            : "Información sobre tu inscripción";

        return $this->view('emails.inscription_status')
                    ->subject($subject);
    }
}
