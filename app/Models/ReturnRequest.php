<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $casts=[
        'items'=>'json'
    ];

    protected $fillable=[
        'order_id',
        'reason',
        'client_id'
    ];

// Return.php
public function returnItems()
{
    return $this->hasMany(ReturnItem::class);
}
public function order()
{
    return $this->belongsTo(Order::class);
}

// ReturnItem.php
public function product()
{
    return $this->belongsTo(Product::class);
}

}
