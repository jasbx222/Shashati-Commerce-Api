<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Order\CreateOrderRequest;
use App\Http\Resources\Order\Address\AddressResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Address;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function get(Request $request)
    {
        $orders = Order::where('client_id', auth()->user()->id)
            ->filter()
            ->get();
        return OrderResource::collection($orders);
    }


    public function show(Order $order)
    {
        return OrderResource::make($order);
    }


    // جلب المنتجات بالطلب  عن طريق الايدي مالتة ونجلب المنتجات الخاصة بالطلب فقط 
public function products(Order $order)
{
    $order->load('products');

    $allProducts = $order->products->map(function ($product) {
        return [
            'id'       => $product->id,
            'name'     => $product->name,
            'quantity' => $product->pivot->quantity, 
            'price'    => $product->price,
        ];
    });

    return response()->json(['products' => $allProducts]);
}




    public function create(CreateOrderRequest $request)
    {
        try {

            DB::beginTransaction();

            $fields = $request->validated();
            $fields['branch_id']=auth()->user()->branch_id;
            $client = Client::find(auth()->user()->id);
            $cart = $fields['products'];
            $couponCode = $fields['coupon_code'] ?? null;

            $coupon = $this->validateCoupon($couponCode, $client);
 
         
            $this->validateProductAvailability($cart);

            $address = Address::find($fields['address_id']);

            $order = Order::create([
                'client_id' => $client->id,
                'status' => 'pending',
                  'branch_id'      => $fields['branch_id'], 
                'coupon_id' => $coupon ? $coupon->id : null,
                'address_id' => $address->id,
                'delivery_price' => $address->governorate->delivery_price,
            ]);

            $this->attachProductsToOrder($order, $cart);

            // حساب المبلغ الإجمالي
            $order->calculateAndSaveTotal();

            DB::commit();
   $client = $this ->notify(new \App\Notifications\OrderPrepare\NewOrderNotification($order));
            return successCreateResponse('تم إنشاء الطلب بنجاح');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return errorResponse($e->validator->errors()->first(), 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return errorResponse('البيانات المطلوبة غير موجودة', 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 400);
        }
    }

    private function validateCoupon($couponCode, Client $client)
    {
        if (!$couponCode) {
            return null;
        }

        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            throw new \Exception('كود الكوبون غير موجود.');
        }

        if (!$coupon->isValid()) {
            throw new \Exception('كود الكوبون منتهي الصلاحية أو غير فعال.');
        }

        try {
            $coupon->redeem($client);
        } catch (\Exception $e) {
            throw new \Exception('فشل في استعمال الكوبون: ' . $e->getMessage());
        }

        return $coupon;
    }

    private function validateProductAvailability($cart)
    {
        foreach ($cart as $cartItem) {
            $product = Product::findOrFail($cartItem['id']);
            if ($product->quantity < $cartItem['quantity']) {
                throw new \Exception(sprintf('الكمية غير متوفرة للمنتج: %s', $product->name));
            }
        }
    }

    private function attachProductsToOrder(Order $order, array $cart)
    {
        foreach ($cart as $cartItem) {
            $product = Product::findOrFail($cartItem['id']);
            $order->products()->attach($product->id, [
                'quantity' => $cartItem['quantity'],
            ]);

            $product->decrement('quantity', $cartItem['quantity']);
        }
    }
}
