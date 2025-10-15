<?php

namespace App\Http\Service\Admin\orders;

use App\Http\Resources\Admin\orders\OrderResource;
use App\Models\Order;
use App\Notifications\Client\AcceptOrderNotification;
use App\Notifications\Client\CancelOrderNotification;

class OrderService
{
    /**
     * عرض كل الطلبات مع العلاقات
     */
    public function index()
    {
        $orders = Order::with(['client', 'address.governorate', 'coupon', 'products'])->filter()
            ->paginate(10);

        return response()->json([
            'orders' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page'    => $orders->lastPage(),
                'per_page'     => $orders->perPage(),
                'total'        => $orders->total(),
            ]
        ]);
    }

    /**
     * عرض تفاصيل طلب واحد
     */
    public function show( $order)
    {
        $order->load(['client', 'address.governorate', 'products']);

        return new OrderResource($order);
    }

    /**
     * تحديث حالة الطلب
     */
  public function updateStatus($request, $order)
{
    $user = auth()->user(); 

    $request->validate([
        'status' => 'required|in:pending,accepted,completed,returned,cancelled',
    ]);

    $order->update(['status' => $request->status]);
    if ($order->status === 'accepted') {
        $user->notify(new AcceptOrderNotification($order));
    }
    if ($order->status === 'cancelled') {
        $user->notify(new CancelOrderNotification($order));
    }

    return response()->json([
        'message' => 'تم تعديل حالة الطلب بنجاح',
    ]);
}

}
