<?php

namespace App\Http\Resources\Order\Address;

use App\Http\Resources\Governorate\GovernorateResource;
use App\Http\Resources\Region\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'governorate' => GovernorateResource::make($this->governorate),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];
    }
}
