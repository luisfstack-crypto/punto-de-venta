<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegistered extends Notification
{
    use Queueable;

    public $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Solicitud de acceso pendiente - ' . $this->newUser->name)
                    ->greeting('Hola Administrador,')
                    ->line('El usuario ' . $this->newUser->name . ' se ha registrado y está esperando aprobación.')
                    ->line('Correo: ' . $this->newUser->email)
                    ->action('Ver Solicitudes Pendientes', route('admin.users.pending'))
                    ->line('Por favor revisa el comprobante y aprueba o rechaza la solicitud.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
