<?php

namespace App\Http\Resources\returns;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnRequestItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
         'product' => new ProductsReturn($this->product),
            'quantity' => $this->quantity,
     
        ];
    }
}
