<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionHelpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'amount'         => $this->amount,
            'collected'      => $this->collected,
            'book'           => new BookResource($this->book),
            'since'          => $this->created_at,
            'days'           => days_pass($this->created_at)
            
        ];
    }
}
