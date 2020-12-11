<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class MyNotification extends Notification
{
    use Queueable;
    private $notifiable;

    public function __construct($notifiable)
    {
        $this->notifiable = $notifiable;
    }

    public function via($notifiable)
    {
        // return [FcmChannel::class];
        return ['database'];
    }

    // public function toFcm($notifiable)
    // {
    //     return FcmMessage::create()
    //         ->setData(['data1' => 'value', 'data2' => 'value2'])
    //         ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
    //             ->setTitle('Staff Notification')
    //             ->setBody('Your role has been changed.')
    //             ->setImage('http://example.com/url-to-image-here.png'))
    //         ->setAndroid(
    //             AndroidConfig::create()
    //                 ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
    //                 ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
    //         )->setApns(
    //             ApnsConfig::create()
    //                 ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    // }
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->notifiable['user_id'],
            'order_id' => $this->notifiable['order_id'],
            'firstname' => $this->notifiable['firstname'],
            'role' => $this->notifiable['role'],
            'orderstatus' => $this->notifiable['orderstatus'],
        ];
    }
}
