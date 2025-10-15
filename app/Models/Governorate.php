<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'name',
        'delivery_price'
    ];

    public function address()
    {
        return $this->hasMany(Order::class);
    }
}
