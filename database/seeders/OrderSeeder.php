<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{


    public function run()
    {

        Order::create([
            'client_id' => 1,
            'status' => 'pending',
            'coupon_id' => null,
            'total' => 8900,
            'branch_id' => 1,
            'discount' => 1000,
            'delivery_price' => 9000,
            'address_id' => 1
        ]);
        Order::create([
            'client_id' => 1,
            'status' => 'pending',
            'coupon_id' => null,
            'total' => 8900,
            'branch_id' => 1,
            'discount' => 2000,
            'delivery_price' => 9000,
            'address_id' => 1
        ]);
        Order::create([
            'client_id' => 1,
            'status' => 'pending',
            'coupon_id' => null,
            'total' => 8900,
            'branch_id' => 1,
            'discount' => 10,
            'delivery_price' => 9000,
            'address_id' => 1
        ]);
    }
}
