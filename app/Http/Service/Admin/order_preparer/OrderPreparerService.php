<?php

namespace App\Http\Service\Admin\order_preparer;

use App\Http\Resources\Admin\orders\OrderResource;
use App\Models\Order;

class OrderPreparerService
{
    /**
     * عرض كل الطلبات مع العلاقات
     */
    public function index()
    {
        $branch_id= auth()->user()->branch_id;
        $orders = Order::where('branch_id',$branch_id)->with(['client', 'address.governorate', 'coupon', 'products'])->filter()
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
    public function updateStatus($request,$order)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,completed,returned,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تعديل حالة الطلب بنجاح',
        ]);
    }
}
