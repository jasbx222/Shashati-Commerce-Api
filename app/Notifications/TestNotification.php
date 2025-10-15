<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class TestNotification extends Notification
{
    use Queueable;

    public $id; // 🔹 أضف هذا السطر لتجنب الخطأ

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setNotification(
                FcmNotification::create('🚀 اختبار إشعار', 'هذا إشعار تجريبي من Laravel')
            )
            ->data(['test' => '123']);
    }
}
