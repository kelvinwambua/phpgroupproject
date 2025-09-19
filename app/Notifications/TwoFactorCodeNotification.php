<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCodeNotification extends Notification
{
    use Queueable;

    public $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail message.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirm Your Login')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We noticed a login attempt to your account.')
            ->line('Please confirm this login by entering the code below:')
            ->line('**Your Login Code: ' . $this->code . '**')
            ->line('This code will expire in 10 minutes.')
            ->line('If this wasn’t you, please secure your account immediately.');
    }
}
