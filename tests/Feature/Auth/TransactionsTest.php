<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class TransactionsTest extends TestCase
{
    /**
     * @test
     */
    public function can_fetch_all_records()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);


        $response = $this->getJson(route('auth-transactions'));

        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_fetch_all_records()
    {
        $response = $this->getJson(route('auth-transactions'));


        $response->assertStatus(401);
    }
}
