<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Book;


use Faker\Factory as Faker;

class StoreBookTest extends TestCase
{

    /**
     * @test
     */
    public function can_store_record_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['role_id' => 3]);
        Sanctum::actingAs($user, ['*']);
        
        $faker = Faker::create();


        $response = $this->postJson(route('books.store'), [
            'title' => $faker->sentence(random_int(1, 3)),
            'isbn' => $faker->unique()->isbn13(),
            'publisher' => $faker->sentence(3),
            'year' => random_int(1000, date("Y")),
            'price' =>  random_int(1, 999),
            'quantity' =>  random_int(0, 100),
            'user_id'   => $user->id,
        ]);

        
        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_store_record_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['role_id' => 3]);
        Sanctum::actingAs($user, ['*']);
        
        $faker = Faker::create();


        $response = $this->postJson(route('books.store'), []);

        
        $response->assertStatus(422);

        DB::rollBack();
    }
}
