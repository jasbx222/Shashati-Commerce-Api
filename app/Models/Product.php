<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'price_after',
        'quantity',
        'is_offer',
        'offer_name'
    ];

    protected $casts = [    

        'is_offer' => 'boolean',
        'price' => 'double',
        'price_after' => 'double',
        'quantity' => 'integer'
    ];
 public function returnItems(){

        return $this->hasMany(ReturnItem::class);

    }
    // Scops 
    public function scopeFilter($query): Builder
    {
        return $query
            ->when(request('category_id'), fn($query) =>
                $query->where('category_id', request('category_id'))
            )
            ->when(request('sort_by'), fn($query) =>
                $query->orderBy(request('sort_by'), request('sort_order', 'asc'))
            );
    }
// في موديل Product.php
public function getImageAttribute($value)
{
    return $value ? asset('storage/' . $value) : null;
}

    public function scopeQuantity($query): Builder
    {
        return $query->where('quantity', '>', 0);
    }
 
    /**
     * Scope a query to search products by name or description.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query): Builder
    {
        return $query->when(request('search'), function ($query) {
            $searchTerm = request('search');
            
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });

            $this->saveSearchHistory($searchTerm);
        });
    }
    
    /**
     * Save the search query to the search history.
     *
     * @param string $searchTerm
     * @return void
     */
    private function saveSearchHistory($searchTerm)
    {
        if(auth()->check()){
            $clientId = auth()->check() ? auth()->id() : null;

            SearchHistory::create([
                'client_id' => $clientId,
                'query' => $searchTerm,
            ]);
        }
        return true;
    }


    public function getSubTotalAttribute()
    {
        return 0;
    }
    

    // Relation
public function images()
{
    return $this->hasMany(Image::class);
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ads()
    {
        return $this->hasMany(Ads::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(Client::class, 'favorites', 'product_id', 'client_id')
            ->withTimestamps();
    }


    

}
