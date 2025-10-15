<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStatement extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'file',
        'client_id'
    ];


    public function client(){
        return $this->belongsTo(Client::class);
    }


 public function scopeFilter($query)
{
    //from_date=2025-09-01&to_date=2025-09-20
    if (request('from_date') && request('to_date')) {
        return $query->whereBetween('created_at', [request('from_date'), request('to_date')]);
    }

    if (request('from_date')) {
        return $query->whereDate('created_at', '>=', request('from_date'));
    }

    if (request('to_date')) {
        return $query->whereDate('created_at', '<=', request('to_date'));
    }

    return $query;
}


}
 
       
            
      