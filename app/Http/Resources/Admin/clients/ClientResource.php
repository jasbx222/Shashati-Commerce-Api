<?php

namespace App\Http\Resources\Admin\clients;

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
            'name' => $this->name,
            'branch' => $this->branch,
            'branch_id' => $this->branch_id,
            'merchant'=>$this->merchant,
            'phone' => $this->phone,
            'is_active'=>$this->is_active,
        ];
    }
}
