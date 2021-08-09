<?php

namespace Tests\Feature\Books;

use Tests\TestCase;
use App\Models\Book;
use Faker\Factory as Faker;

class UpdateBookTest extends TestCase
{

    /**
     * @test
    */
    public function can_update_record_test()
    {
        $this->withoutExceptionHandling();
        
        $record = Book::factory()->create();
        $faker = Faker::create();

        // Sanctum::actingAs($this->user, ['*']);

        $response = $this->putJson(route('books.update', $record->getRouteKey()), [
            'title' => $faker->sentence(random_int(1, 3)),
            'isbn' => $faker->unique()->isbn13(),
            'publisher' => $faker->sentence(),
            'year' => $faker->year(),
            'price' =>  random_int(1, 999),
            'quantity' =>  random_int(1, 100),
        ]);
    
        $response->assertSuccessful();
    }
}
