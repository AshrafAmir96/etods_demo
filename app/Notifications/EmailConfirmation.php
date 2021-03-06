<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmailConfirmation extends Notification
{
    /**
     * Email confirmation token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        $subject = sprintf("[%s] %s", setting('app_name'), trans('app.registration_confirmation'));

        return (new MailMessage)
            ->subject($subject)
            ->line(trans('app.thank_you_for_registering', ['app' => setting('app_name')]))
            ->line(trans('app.confirm_email_on_link_below'))
            ->action(trans('app.confirm_email'), route('register.confirm-email', $this->token));
    }
}
