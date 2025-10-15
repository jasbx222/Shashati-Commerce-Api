<?php

namespace App\Http\Resources\Ads;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdsResource extends JsonResource
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
            'title' => $this->title,
            'image' => getImageUrl($this->image),
            'video_url'=>$this->video_url,
            'type' => $this->type,
            'product' => $this->product ? ProductResource::make($this->product) : null,
        ];
    }
}
