<?php

namespace App\Models;

use App\Enums\CouponType;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status',
        'coupon_id',
        'total',
        'branch_id',
        'discount',
        'delivery_price',
        'address_id'
    ];

    protected $casts = [
        'delivery_price' => 'double',
        'discount' => 'double',
        'total' => 'double',
    ];
public function branch()
{
    return $this->belongsTo(Branch::class);
}

    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function returns()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    // Scopes
    public function scopeFilter($query): Builder
    {
        return $query->when(request('status'), fn($query) => $query->where('status', request('status')));
    }

    // Attribute
    public function getTotalWithDeliveryPriceAttribute()
    {
        return $this->total + $this->delivery_price;
    }


    // Methods
    public function calculateAndSaveTotal()
    {
        $subtotal = $this->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        $discount = $this->calculateDiscount($subtotal);

        $total = max(0, $subtotal - $discount);

        $this->update([
            'discount' => $discount,
            'total' => $total,
        ]);
    }

    private function calculateDiscount($subtotal)
    {
        $discount = 0;
        if ($this->coupon && $this->coupon->isValid()) {
            if ($this->coupon->type === CouponType::FIXED) {
                $discount = $this->coupon->value;
            } elseif ($this->coupon->type === CouponType::PERCENTAGE) {
                $discount = ($this->coupon->value / 100) * $subtotal;
            }
        }
        return $discount;
    }


    public function scopeClients($query){

  
    if(request()->has('client')){
        return $query->where('client_id',request('client'));
    }

    return $query;
        }
 





}

