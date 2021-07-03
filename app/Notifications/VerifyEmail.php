<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->greeting(Lang::getFromJson('Bienvenido a Psicoweb Salud'))
            ->subject(Lang::getFromJson('Confirme su dirección de correo electrónico'))
            ->line(Lang::getFromJson('Haga clic en el botón de abajo para verificar su dirección de correo electrónico.'))
            ->action(
                Lang::getFromJson('Confirme su dirección de correo electrónico'),
                $this->verificationUrl($notifiable)
            )
            ->line(Lang::getFromJson('Si no creó ha creado una cuenta, omita este correo.'));
    }
}
