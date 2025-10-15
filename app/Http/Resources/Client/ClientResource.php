<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'branch'=>$this->branch,
            'name' => $this->name,
            'merchant'=>$this->merchant,
            'phone' => $this->phone,
            'branch'=> $this->branch->title ? $this->branch->title :null

        ];
    }
}
