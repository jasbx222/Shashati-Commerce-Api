<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'price' => $this->price,
            'price_after' => $this->price_after,
            'is_offer' => $this->is_offer,
   'images' => $this->images->pluck('image'),
'category' => $this->category ? new CategoryResource($this->category) : null,

        ];
    }
}
