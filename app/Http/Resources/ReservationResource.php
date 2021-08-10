<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'cost'           => $this->type,
            'book'           => $this->book->book_id   ?? $this->book->name,
            'author'         => $this->book->author_id ?? $this->book->author->name,
        ];
    }
}
