<?php
namespace App\Http\Resources\returns;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsReturn extends JsonResource{






    public function  toArray( $request) : array {
        

        return[
            'id'=>$this->id,
            'name'=>$this->name,
        ];
    }
}