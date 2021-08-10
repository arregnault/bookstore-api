<?php

namespace Tests\Feature\Books;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class ReportTest extends TestCase
{
    /**
       * @test
       */
    public function can_get_report_pdf()
    {
        DB::beginTransaction();

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        
        $response = $this->getJson(route('books-report'));

        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_get_report_pdf()
    {
        DB::beginTransaction();

        $response = $this->getJson(route('books-report'));

        $response->assertStatus(401);
        DB::rollBack();
    }
}
