<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use App\Models\Book;

class SingleBookTest extends TestCase
{
    /**
     * @test
     */
    public function can_fetch_single_record()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        
        $record = Book::factory()->create();

        $response = $this->getJson(route('books.show', $record->getRouteKey()));

        $response->assertSuccessful();
        $record->delete();
        $user->delete();
    }

    /**
     * @test
     */
    public function cant_fetch_single_record()
    {
        // $this->withoutExceptionHandling();
        
        $record = Book::factory()->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);


        $response = $this->getJson(route('books.show', (integer) $record->getRouteKey() + 1));

        $response->assertStatus(404);
        $user->delete();
        $record->delete();
    }
}
