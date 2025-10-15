<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'type',
        'video_url',
        'product_id',
    ];


    /**
     * Scope a query to only include a type of ads.
     */
    public function scopeType($query)
    {
        if(request('type')){
            return $query->where('type', request('type'));
        }
        return $query;
    }

    /**
     * Get the product that owns the ad.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
