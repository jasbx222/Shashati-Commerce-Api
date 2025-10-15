<?php

namespace App\Http\Resources\ContactInfo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'support_message'   =>  $this->support_message,
            'phone'             =>  $this->phone,
            'email'             =>  $this->email,
            'website'           =>  $this->website,
            'address'           =>  $this->address
        ];
    }
}
