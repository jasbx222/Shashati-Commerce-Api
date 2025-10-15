<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'minimum_order_amount',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function isValid()
    {
        if ($this->expires_at && !$this->expires_at->isFuture()) {
            return false;
        }

        if ($this->reachedUsageLimit()) {
            return false;
        }

        return true;
    }

    public function reachedUsageLimit(): bool
    {
        return $this->minimum_order_amount && $this->minimum_order_amount <= $this->uses()->count();
    }


    public function redeem(Client $client): CouponUse
    {
        return $this->uses()->create([
            'client_id' => $client->id,
        ]);
    }

    /*
    ---------------------------
    Relationships
    ---------------------------
    */
    public function uses(): HasMany
    {
        return $this->hasMany(CouponUse::class);
    }
}
