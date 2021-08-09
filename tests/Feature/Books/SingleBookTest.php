<?php

namespace Tests\Feature\Books;

use Tests\TestCase;
use App\Models\Book;

class SingleBookTest extends TestCase
{
    /**
     * @test
     */
    public function can_fetch_single_record()
    {
        $this->withoutExceptionHandling();
        
        $record = Book::factory()->create();

        $response = $this->getJson(route('books.show', $record->getRouteKey()));

        $response->assertJson([
            'data' => [
                'id'        => $record->getRouteKey(),
                'title'     => $record->title,
                'isbn'      => $record->isbn,
                'publisher' => $record->publisher,
                'year'      => $record->year,
                'price'     => $record->price,
                'quantity'  => $record->quantity,
                'author'    => [
                    'id'    =>  $record->author->id,
                    'name'  =>  $record->author->name,
                    'email' =>  $record->author->email,
                ],
            ]
        ]);
    }
}
