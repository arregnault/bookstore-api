<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use App\Models\Book;

class ListBookTest extends TestCase
{

    /**
     * @test
     */
    public function can_fetch_all_records()
    {
        DB::beginTransaction();

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);


        
        $records = Book::take(3)->get();
        if (empty($records)) {
            $records = Book::factory()->times(3)->create();
        }

        $response = $this->getJson(route('books.index'));

        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function can_fetch_by_name_all_records()
    {
        DB::beginTransaction();

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);



        $records = Book::take(3)->get();
        if (empty($records)) {
            $records = Book::factory()->times(3)->create();
            $records_x = $records;
        }

        $response = $this->getJson(route('books.index'), ['title' => 'sed', 'orderBy' => 'desc']);

        $response->assertSuccessful();

        try {
            $records->delete();
        } catch (\Throwable $th) {
        }
        DB::rollBack();
    }
}
