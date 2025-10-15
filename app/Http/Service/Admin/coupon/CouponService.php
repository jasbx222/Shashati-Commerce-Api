<?php

namespace App\Http\Service\Admin\coupon;

use App\Http\Resources\Admin\coupons\CouponsResource;
use App\Models\Coupon;

class CouponService 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::all();
        return CouponsResource::collection($coupons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
         Coupon::create($data);
        return response()->json([
            'message' => 'Coupon created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $coupon)
    {
        return response()->json([
            'data' => $coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data,  $coupon)
    {
        $coupon->update($data);
        return response()->json([
            'message' => 'Coupon updated successfully',
            'data' => $coupon
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $coupon)
    {
        $coupon->delete();
        return response()->json([
            'message' => 'Coupon deleted successfully'
        ]);
    }
}
