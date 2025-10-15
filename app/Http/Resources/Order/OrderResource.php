<?php

namespace App\Http\Resources\Order;

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
            'delivery_price' => $this->delivery_price,
            'total_with_delivery_price' => $this->total + $this->delivery_price,
            'discount' => $this->discount,
            'product' => ProductResource::collection($this->products),
            'address' => AddressResource::make($this->address),
        ];
    }
}
