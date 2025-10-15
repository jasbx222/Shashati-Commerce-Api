<?php

namespace App\Http\Resources\TermsAndCondition;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermsAndConditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'     =>  $this->title,
            'content'   =>  $this->content,
        ];
    }
}
