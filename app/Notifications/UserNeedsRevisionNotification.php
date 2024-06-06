<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNeedsRevisionNotification extends Notification
{
    use Queueable;

    protected $user;//Accedo a las propiedades de user

    /**
     * Notificacion para avisar al taller  que necesita una revisión
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Especifica cómo se enviará la notificación.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return [ 'database']; // Se envía a la base de datos
    }


    // public function via(object $notifiable): array
    // {
    //     return ['mail'];
    // }

    /**
     * Obtener la representación de matriz de la notificación.
     */
   // public function toMail(object $notifiable): MailMessage
   public function toMail($notifiable)
   
    {
        return (new MailMessage)
            ->subject('Revisión Necesaria')
            ->greeting('Hola, ' . $notifiable->name)
            ->line('El usuario ' . $this->user->name . ' necesitara.')
            ->action('Ver Detalles', url('/taller/' . $notifiable->id))
            ->line('Gracias por usar nuestra aplicación!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
   // public function toArray(object $notifiable): array
   public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
        ];
    }
}
