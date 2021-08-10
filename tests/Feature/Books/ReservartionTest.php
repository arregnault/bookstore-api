<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use App\Models\Book;

class ReservartionTest extends TestCase
{

    /**
     * @test
     */
    public function can_make_reservation_record()
    {
        DB::beginTransaction();

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->update(['account_blance' => 999999]);
        Sanctum::actingAs($user, ['*']);

        
        $record = Book::factory()->create();

        $response = $this->postJson(route('books-reservation', $record->getRouteKey()));

        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_make_reservation_in_not_found_record()
    {
        DB::beginTransaction();

        $record = Book::factory()->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);


        $response = $this->postJson(route('books-reservation', (integer) $record->getRouteKey() + 1));

        $response->assertStatus(422);
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_make_reservation_with_cero_balance_record()
    {
        DB::beginTransaction();

        $record = Book::factory()->create();

        $user = User::factory()->create();
        $user->update(['account_blance' => 0]);
        Sanctum::actingAs($user, ['*']);


        $response = $this->postJson(route('books-reservation', (integer) $record->getRouteKey() + 1));

        $response->assertStatus(422);
        DB::rollBack();
    }
}
