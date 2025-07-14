<?php

namespace App\Notifications;

use App\Models\UrlModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Soap\Url;

class ExpireNotification extends Notification
{
    use Queueable;
    protected $shortUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct(UrlModel $shortUrl)
    {
        $this->shortUrl = $shortUrl;
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
            ->subject('URL Expiration Notification')
            ->line('The URL you created is about to expire.')
            ->action('View URL', url('/urls/' . $this->shortUrl->id))
            ->line('Please take necessary action before it expires.')
            ->line('Thank you for using our application!');
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
