<?php

namespace App\Http\Resources\Admin\coupons;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *  "id": 1,
   
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id'=>$this->id,
        'name'=>$this->name,
        'code'=>$this->code,
        'type'=>$this->type,
        'value'=>$this->value,
        'minimum_order_amount'=>$this->minimum_order_amount,
        'expires_at'=>$this->expires_at,
        'uses'=>$this->uses,
        ];
    }
}
