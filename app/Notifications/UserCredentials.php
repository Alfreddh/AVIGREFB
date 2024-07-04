<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserCredentials extends Notification
{
    use Queueable;

    protected $email;
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Vos identifiants')
                    ->line('Voici vos identifiants :')
                    ->line('Email : ' . $this->email)
                    ->line('Mot de passe : ' . $this->password)
                    ->line('Conservez-les en lieu sûr.')
                    ->salutation('Cordialement, ' . config('app.name'));
    }
}
