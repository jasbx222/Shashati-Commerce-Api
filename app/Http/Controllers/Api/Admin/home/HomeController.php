<?php


namespace App\Http\Controllers\Api\Admin\home;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
class HomeController extends Controller{

    // get sum orders


    public function getOrdersCountByStatus()
{
    // الحالات  
    $statuses = ['pending', 'accepted', 'completed', 'returned', 'cancelled'];

    // نجيب العدد لكل حالة
    $counts = [];
    foreach ($statuses as $status) {
        $counts[$status] = Order::where('status', $status)->count();
    }

    return response()->json([
        'counts' => $counts,
        'total'  => Order::count(),
    ]);
}

// العملاء الاكثر  شراء
public function topClients()
{
    $topClients = Client::withCount('orders') 
        ->orderBy('orders_count', 'desc')              
        ->limit(10)
        ->get();

    return response()->json([
        'top_clients' => $topClients
    ]);
}

//الكاردات بالهوم بيج للداش بورد

public function CardsHomeCounts()
{
    $ordersCount = Order::count();       
    $productsCount = Product::count();   
    $categoriesCount = Category::count(); 
    $clientsCount = Client::count(); 
    $adsCounts=Ads::count();

    return response()->json([
        'orders' => $ordersCount,
        'products' => $productsCount,
        'categories' => $categoriesCount,
        'clients' => $clientsCount,
        'ads'=>$adsCounts
    ]);
}

}