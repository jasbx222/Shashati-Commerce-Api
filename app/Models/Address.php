<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'governorate_id',
        'longitude',
        'latitude',
    ];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
