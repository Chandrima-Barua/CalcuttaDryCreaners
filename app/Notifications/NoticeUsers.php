<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NoticeUsers extends Notification
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
            'user_id' => $this->notifiable['user_id'],
            'create_id' => $this->notifiable['create_id'],
            'title' => $this->notifiable['title'],
            'text' => $this->notifiable['text'],
            'notice_id' => $this->notifiable['notice_id'],
            'file_name' => $this->notifiable['file_name'],
        ];
    }
}
