<?php

namespace Tests\Feature\Books;

use Tests\TestCase;
use App\Models\Book;

class DeleteBookTest extends TestCase
{

    /**
     * @test
     */
    public function can_delete_record()
    {
        $this->withoutExceptionHandling();
        
        $record = Book::factory()->create();

        $response = $this->delete(route('books.destroy', $record->getRouteKey()));

        $response->assertSuccessful();
    }
}
