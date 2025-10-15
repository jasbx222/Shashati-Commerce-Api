<?php

namespace App\Http\Resources\returns;

use App\Http\Resources\Admin\orders\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'order' => $this->when($request->routeIs('returns.index'), function () {
                return new OrderResource($this->order);
            }),
        ];
    }
}
