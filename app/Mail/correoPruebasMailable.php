<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class correoPruebasMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tipoRecordatorio;
    public $diasRestantes;
    public $emailUser;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $tipoRecordatorio, $diasRestantes)
    {
        $this->user = $user;
        $this->tipoRecordatorio = $tipoRecordatorio;
        $this->diasRestantes = $diasRestantes;
        $this->emailUser = $user->email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            //sujeto del email
            subject: 'Tiempo expirado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // view espera que le pases la ruta de la vista del correo  nom_carpeta.vista  en nuestro caso el directorio se llama emails y la vista correo_prueba --> emails\emailPruebas.blade.php
            view: 'emails.emailPruebas',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
