<?php

namespace App\Http\Resources\Admin\clients;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOredersResource extends JsonResource
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
            'client' => $this->client->name,
            'status' => $this->status,
            'coupon_id' => $this->coupon_id ? $this->coupon_id : 'no coupon',
            'discount' => $this->discount,
            'delivery_price' => $this->delivery_price,
            'total' => $this->total,

        ];
    }
}
