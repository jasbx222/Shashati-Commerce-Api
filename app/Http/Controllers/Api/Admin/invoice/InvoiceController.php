<?php



namespace App\Http\Controllers\Api\Admin\invoice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\clients\ClientOredersResource;
use App\Http\Resources\Admin\orders\OrderResource;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{



    public function index()
    {
        $invoice = Order::with('client', 'address', 'coupon')->where('status', 'completed')->clients()->get();
        return ClientOredersResource::collection($invoice);
    }



    public function show(Client $client)
    {
        $orders = $client->orders()->where('status', 'completed')->get();

        return  OrderResource::collection($orders);
    }



    public function deleteSelectedOrders(Request $request){
        $ids=$request->ids;
       Order::whereIn('id', $ids)->delete();
       return response()->json('deleted successfully');
    }
}
