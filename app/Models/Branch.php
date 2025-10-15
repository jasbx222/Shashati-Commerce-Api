<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
protected $table='branches';
    protected $fillable=[
        'title',
    ];


    public function clients(){
        return $this->hasMany(Client::class);
    }
    public function order_preparers(){
        return $this->hasMany(OrderPreparer::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
