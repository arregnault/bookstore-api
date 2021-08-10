<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Book;

class DeleteBookTest extends TestCase
{

    /**
     * @test
     */
    public function can_delete_record()
    {
        DB::beginTransaction();

        $this->withoutExceptionHandling();
        
        $record = Book::factory()->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);


        $record = Book::factory()->create();

        $response = $this->delete(route('books.destroy', $record->getRouteKey()));

        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_delete_record()
    {
        DB::beginTransaction();

        // $this->withoutExceptionHandling();
        
        $record = Book::factory()->create();
        $record->delete();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->delete(route('books.destroy', (integer) $record->getRouteKey() + 1));

        $response->assertStatus(404);
        DB::rollBack();
    }
}
