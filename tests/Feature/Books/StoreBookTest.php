<?php

namespace Tests\Feature\Books;

use Tests\TestCase;
use App\Models\User;
use Faker\Factory as Faker;

class StoreBookTest extends TestCase
{

    /**
     * @test
     */
    public function can_store_test()
    {
        $this->withExceptionHandling();
        
        $faker = Faker::create();

        // Sanctum::actingAs($this->user, ['*']);

        $response = $this->postJson(route('books.store'), [
            'title' => $faker->sentence(random_int(1, 3)),
            'isbn' => $faker->unique()->isbn13(),
            'publisher' => $faker->sentence(),
            'year' => $faker->year(),
            'price' =>  random_int(1, 999),
            'quantity' =>  random_int(1, 100),
            'user_id'   => User::factory()->create()->id,
        ]);


        $response->assertSuccessful();
    }
}
