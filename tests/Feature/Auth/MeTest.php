<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class MeTest extends TestCase
{

    
    /**
     * @test
     */
    public function can_get_my_data_account_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);


        $response = $this->getJson(route('auth-me'));

        
        $response->assertSuccessful();
        DB::rollBack();
    }
    
    /**
     * @test
     */
    public function cant_get_my_data_account_test()
    {
        $response = $this->getJson(route('auth-me'));

        $response->assertStatus(401);
    }
}
