<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LegalExpire extends Notification
{
    use Queueable;

    private $notifiable;

    public function __construct($notifiable)
    {
        $this->notifiable = $notifiable;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    
    public function toArray($notifiable)
    {
        return [
            'days_left' => $this->notifiable['days_left'],
            'user_id' => $this->notifiable['user_id'],
            
        ];
    }
}
