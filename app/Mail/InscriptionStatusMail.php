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
    public $documento;
    public $password;

    public function __construct($status, $role, $name, $documento = null, $password = null)
    {
        $this->status = $status;
        $this->role = $role;
        $this->name = $name;
        $this->documento = $documento;
        $this->password = $password;
    }

    public function build()
    {
        $subject = $this->status === 'Aprobada'
            ? "¡Bienvenido a la Fundación! Inscripción Aprobada"
            : "Información sobre tu inscripción";

        return $this->view('emails.inscription_status', [
            'name' => $this->name,
            'role' => $this->role,
            'status' => $this->status,
            'documento' => $this->documento,
            'password' => $this->password,
        ])
        ->subject($subject);
    }
}
