<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use App\Models\Book;
use Faker\Factory as Faker;

class UpdateBookTest extends TestCase
{

    /**
     * @test
    */
    public function can_update_record_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['role_id' => 3]);
        Sanctum::actingAs($user, ['*']);

        
        $record = Book::factory()->create();
        $faker = Faker::create();


        $response = $this->putJson(route('books.update', $record->getRouteKey()), [
            'title' => $faker->sentence(random_int(1, 3)),
            'isbn' => $faker->unique()->isbn13(),
            'publisher' => $faker->sentence(),
            'year' => $faker->year(),
            'price' =>  random_int(1, 999),
            'quantity' =>  random_int(1, 100),
        ]);
    
        $response->assertSuccessful();
        DB::rollBack();
    }
    /**
     * @test
    */
    public function cant_update_record_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['role_id' => 3]);
        Sanctum::actingAs($user, ['*']);
        
        $record = Book::factory()->create();

        $response = $this->putJson(route('books.update', $record->getRouteKey()), []);
    
        $response->assertStatus(422);

        DB::rollBack();
    }
}
