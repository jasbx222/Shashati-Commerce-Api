<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name',
        'image',
        'parent_id'
    ];


    // Scope
    
    public function scopeParents($query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }


    public function scopeParentFilter($query): Builder
    {
        return $query->when(request('parent_id'), 
            fn ($query) => $query->where('parent_id', request('parent_id')),
            fn ($query) => $query->whereNull('parent_id')
        );
    }


    // Attribute
    public function getSubCategoryCountAttribute()
    {
        return $this->children()->count();
    }

    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }


    /*  
    ---------------------------
    Relationships
    ---------------------------
    */ 
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
}
