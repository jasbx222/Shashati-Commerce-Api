<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    // You can add additional properties or methods if needed
    protected $table = 'favorites'; // Specify the pivot table if the default naming convention doesn't match.

    protected $fillable = [
        'client_id', 
        'product_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'product_id' => 'integer',
    ];

    public $timestamps = true; // If the pivot table has `created_at` and `updated_at`


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
