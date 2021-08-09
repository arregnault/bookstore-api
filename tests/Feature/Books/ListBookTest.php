<?php

namespace Tests\Feature\Books;

use Tests\TestCase;
use App\Models\Book;

class ListBookTest extends TestCase
{

    /**
     * @test
     */
    public function can_fetch_all_recordss()
    {
        $this->withoutExceptionHandling();
        
        $records = Book::take(3)->get();
        if (empty($records)) {
            $records = Book::factory()->times(3)->create();
        }

        $response = $this->getJson(route('books.index'));

        $response->assertJson([
            'data' =>
                [
                    [
                        'id'        => $records[0]->id,
                        'title'     => $records[0]->title,
                        'isbn'      => $records[0]->isbn,
                        'publisher' => $records[0]->publisher,
                        'year'      => $records[0]->year,
                        'price'     => $records[0]->price,
                        'quantity'  => $records[0]->quantity,
                        'author'    => [
                            'id'    =>  $records[0]->author->id,
                            'name'  =>  $records[0]->author->name,
                            'email' =>  $records[0]->author->email,
                        ]
                    ],
                    [
                        'id'        => $records[1]->id,
                        'title'     => $records[1]->title,
                        'isbn'      => $records[1]->isbn,
                        'publisher' => $records[1]->publisher,
                        'year'      => $records[1]->year,
                        'price'     => $records[1]->price,
                        'quantity'  => $records[1]->quantity,
                        'author'    => [
                            'id'    =>  $records[1]->author->id,
                            'name'  =>  $records[1]->author->name,
                            'email' =>  $records[1]->author->email,
                        ]
                    ],
                    [
                        'id'        => $records[2]->id,
                        'title'     => $records[2]->title,
                        'isbn'      => $records[2]->isbn,
                        'publisher' => $records[2]->publisher,
                        'year'      => $records[2]->year,
                        'price'     => $records[2]->price,
                        'quantity'  => $records[2]->quantity,
                        'author'    => [
                            'id'    =>  $records[2]->author->id,
                            'name'  =>  $records[2]->author->name,
                            'email' =>  $records[2]->author->email,
                        ]
                    ],
                ]
            
        ]);
    }
}
