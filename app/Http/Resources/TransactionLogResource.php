<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionLogResource extends JsonResource
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
            'type'           => $this->type,
            'description'    => $this->description,
            'user_book_id'   => new ReservationResource($this->reservation),
            'author'         => new AuthorResource($this->author),
            'book'           => new BookResource($this->book),
        ];
    }
}
