<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{

    /**
     * @test
     */
    public function can_login_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['password' => \Hash::make('123456789')]);

        $response = $this->postJson(route('auth-login'), [
            'email' => $user->email,
            'password' => '123456789',
        ]);

        
        $response->assertSuccessful();
        DB::rollBack();
    }

    /**
     * @test
     */
    public function cant_login_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        $user->update(['password' => \Hash::make('123456789')]);

        $response = $this->postJson(route('auth-login'), [
            'email' => $user->email,
            'password' => '123456789*',
        ]);

        
        $response->assertStatus(401);
        DB::rollBack();
    }
}
