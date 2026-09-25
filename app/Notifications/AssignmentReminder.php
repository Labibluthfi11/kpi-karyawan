<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentReminder extends Notification
{
    use Queueable;

    public $count;

    /**
     * Create a new notification instance.
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Get the notification's delivery channels.
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
            ->subject('Pengingat Penilaian KPI')
            ->line("Halo {$notifiable->name}, Anda memiliki {$this->count} penilaian KPI yang belum diselesaikan.")
            ->action('Lihat Penilaian', url('/dashboard'))
            ->line('Segera selesaikan penilaian Anda.');
    }
}
