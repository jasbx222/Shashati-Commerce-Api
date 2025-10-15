<?php
namespace App\Http\Resources\Admin\order_prepare;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPrepareResource extends JsonResource{
    


    public function toArray(Request $request)
    {
        return [
            'id'=>$this->id,
        'name' =>$this->name,
        'phone'=>$this->phone,
        'is_active'=>$this->is_active,
        'branch'=>$this->branch,
        ];
    }
}