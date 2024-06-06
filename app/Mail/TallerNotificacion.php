<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TallerNotificacion extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $taller;
    public $tipoRecordatorio;
    public $diasRestantes;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $taller, $tipoRecordatorio, $diasRestantes)
    {
        $this->user = $user;
        $this->taller = $taller;
        $this->tipoRecordatorio = $tipoRecordatorio;
        $this->diasRestantes = $diasRestantes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
           // $tipoRecordatorio = $this->tipoRecordatorio;
           subject: "Notificación de Cliente Necesita $this->tipoRecordatorio",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion_taller',
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
