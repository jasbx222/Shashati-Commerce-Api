<?php

namespace App\Http\Resources\Admin\orders;

use App\Http\Resources\Order\Address\AddressResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'status' => $this->status,
        'total' => $this->total,
        'client' => $this->client ? $this->client  :"العميل محذوف",
        'delivery_price' => $this->delivery_price,
        'total_with_delivery_price' => $this->total + $this->delivery_price,
        'discount' => $this->discount,
        'products' => $this->products,
        'address' => $this->address ? AddressResource::make($this->address) : null,
    ];
}

}
