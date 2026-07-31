<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClaimStatusNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;
    public $image;

    public function __construct($title, $message, $url = null, $image = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->image = $image;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url,
            'image'   => $this->image,
            'type'    => 'claim_status',
        ];
    }
}
