<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use App\Models\Book;
use Faker\Factory as Faker;

class DiscountTest extends TestCase
{
    /**
     * @test
    */
    public function can_make_book_discount_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['role_id' => 3]);
        Sanctum::actingAs($user, ['*']);

        
        $record = Book::factory()->create();
        $record->update(['user_id' => $user->id]);

        $faker = Faker::create();

        $datetime = new \DateTime('tomorrow');

        $response = $this->postJson(route('books-discount', $record->getRouteKey()), [
            'discount' =>  random_int(1, 100),
            'discount_ends_at' =>  $datetime->format('Y-m-d'),
        ]);
    
        $response->assertSuccessful();
        DB::rollBack();
    }
    /**
     * @test
    */
    public function cant_make_book_discount_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['role_id' => 3]);
        Sanctum::actingAs($user, ['*']);
        
        $record = Book::factory()->create();

        $response = $this->postJson(route('books-discount', $record->getRouteKey()), []);
    
        $response->assertStatus(422);

        DB::rollBack();
    }
}
