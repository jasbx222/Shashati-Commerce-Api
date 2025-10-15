<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class OrderPreparer extends Model
{
    use HasFactory,HasApiTokens;

    protected $table='order_preparers';

  protected $fillable = [
        'name',
        'phone',
        'password',
        'is_active',
        'branch_id'
      
    ];


    public function branch(){
        return $this->belongsTo(Branch::class);
    }
 public function setPasswordAttribute($value)
    {
        // Ensure the password is hashed before saving
        $this->attributes['password'] = bcrypt($value);
    }
public function routeNotificationForFcm()
{
    return $this->fcm_token;
}

}
