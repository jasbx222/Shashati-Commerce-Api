<?php

namespace App\Http\Controllers\Api\OrderPreparers;

use App\Http\Controllers\Api\Admin\clients\RegisterController;
use App\Http\Controllers\Controller;
use App\Http\Service\Admin\order_preparer\OrderPreparerService;
use App\Models\Order;
use App\Models\OrderPreparer;
use App\Policies\OrderPolicy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderPreparerController extends Controller
{
    /**
     * @var OrderPreparerService
     */
    private  $orders;

    /**
     * OrdersController constructor.
     *
     * @param OrderService $orders
     */
    public function __construct(OrderPreparerService $orders)
    {
        $this->orders = $orders;
    }

    /**
     * جلب جميع الطلبات مع العلاقات
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->orders->index();
    }

    /**
     * عرض طلب محدد، مع رسالة إذا لم يكن متاحًا
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order)
    {
        return $this->orders->show($order);
    }

    /**
     * تحديث حالة الطلب
     *
     * @param Request $request
     * @param Order $order
     * @return JsonResponse
     */
    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        return $this->orders->updateStatus($request, $order);
    }


   
    
  

   

}
