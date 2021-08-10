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
            'id'                    => $this->id,
            'title'                 => $this->title,
            'isbn'                  => $this->isbn,
            'publisher'             => $this->publisher,
            'price'                 => $this->price,
            'year'                  => $this->year,
            'quantity'              => $this->quantity,
            'discount'              => strtotime($this->discount_ends_at) < strtotime('now') ? 0 : $this->discount,
            'discount_ends_at'      => $this->discount_ends_at,
            'author'                => new AuthorResource($this->author),
        ];
    }
}
