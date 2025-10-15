<?php

namespace App\Http\Resources\Admin\branches;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource {



    public function toArray(Request $request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'orders'=>$this->orders->count(),
            'clients'=>$this->clients->count(),
            'order_preparers'=>$this->order_preparers->Count()
        ];
    }
}