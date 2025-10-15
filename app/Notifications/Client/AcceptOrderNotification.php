<?php

namespace App\Notifications\Client;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class AcceptOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }


    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
            title:'تم قبول طلبك',
            body: 'تم قبول طلبك, يمكنك الاطلاع عليه',
        )))
            ->data([
                'order_id' => $this->order->id,
                'status' => OrderStatus::ACCEPTED,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' =>'تم قبول طلبك',
            'body' => 'تم قبول طلبك, يمكنك الاطلاع عليه',
            'order_id' => $this->order->id,
            'status' => OrderStatus::ACCEPTED,
        ];
    }
}