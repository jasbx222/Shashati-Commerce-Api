<?php


namespace App\Http\Resources\AccountStatement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountStatementResource extends JsonResource {


      public function toArray(Request $request): array 
      {

        return [

          'id'=>$this->id,
            'file'=>$this->file,
            'title'=>$this->title,
            'client'=>$this->client->name,
            'created_at'=>$this->created_at
      

        ];


      }
}