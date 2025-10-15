<?php

namespace App\Http\Controllers\Api\Admin\reports;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\coupons\CouponsResource;
use App\Models\Client;
use App\Models\Product;
use App\Models\Coupon;

class ReportController extends Controller
{
    /**
     * تقرير المنتجات النافذة (كمية صفر أو أقل)
     */
    public function products()
    {
        $products = Product::with('category')
            ->withCount('orders')
            ->where('quantity', '<=', 0) 
            ->latest()
            ->paginate(20);

        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     * تقرير العملاء الأكثر شراء
     */
  public function customers()
{
    $customers =DB::table('clients')
        ->join('orders', 'clients.id', '=', 'orders.client_id')
        ->select(
            'clients.id',
            'clients.name',
            DB::raw('COUNT(orders.id) as total_orders'),
            DB::raw('SUM(orders.total) as total_spent')
        )
        ->groupBy('clients.id', 'clients.name')
        ->orderByDesc('total_spent') // أو orderByDesc('total_orders')
        ->take(10) // مثلاً تجيب أكثر 10 عملاء
        ->get();

    return response()->json($customers);
}


    /**
     * تقرير الكوبونات المنتهية الصلاحية
     */
    public function coupons()
    {
        $coupons = Coupon::whereDate('expires_at', '<', now()) // شرط انتهاء الصلاحية
            ->latest()
            ->paginate(20);

        return CouponsResource::collection($coupons);
    }
}
