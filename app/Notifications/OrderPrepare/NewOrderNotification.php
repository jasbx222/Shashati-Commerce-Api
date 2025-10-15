<?php

namespace App\Notifications\OrderPrepare;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order
    ) {}

    /**
     * القنوات الي يروح بيها الإشعار
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }

    /**
     * إشعار FCM
     */
    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
            title: '📦 طلب جديد',
            body: 'وصل طلب جديد من عميل، رقم الطلب #' . $this->order->id,
        )))
            ->data([
                'order_id' => $this->order->id,
                'status'   => OrderStatus::PENDING,
            ]);
    }

    /**
     * يخزن البيانات بقاعدة البيانات (notifications table)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title'    => '📦 طلب جديد',
            'body'     => 'وصل طلب جديد من عميل، رقم الطلب #' . $this->order->id,
            'order_id' => $this->order->id,
            'status'   => OrderStatus::PENDING,
        ];
    }
}
