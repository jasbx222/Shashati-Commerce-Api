<?php

namespace App\Notifications\Client;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class CancelOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public string $reason = 'تم إلغاء طلبك.'
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }

    /**
     * Get the FCM representation of the notification.
     */
    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
            title: 'تم إلغاء طلبك',
            body: $this->reason,
        )))
        ->data([
            'order_id' => $this->order->id,
            'status' => OrderStatus::CANCELLED,
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'تم إلغاء طلبك',
            'body' => $this->reason,
            'order_id' => $this->order->id,
            'status' => OrderStatus::CANCELLED,
        ];
    }
}