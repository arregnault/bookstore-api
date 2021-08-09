<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->title,
            'isbn'          => $this->isbn,
            'publisher'     => $this->publisher,
            'price'         => $this->price,
            'year'          => $this->year,
            'quantity'      => $this->quantity,
            'author'        => new AuthorResource($this->author),
        ];
    }
}
