<?php

namespace Tests\Feature\Promotions;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\PromotionHelp;

use Faker\Factory as Faker;

class PromotionStoreTest extends TestCase
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


        $response = $this->postJson(route('promotion-help.store'), [
            'title' => $faker->sentence(random_int(1, 3)),
            'isbn' => $faker->unique()->isbn13(),
            'publisher' => $faker->sentence(3),
            'year' => random_int(date("Y"), 2500),
            'price' =>  random_int(1, 999),
            'quantity' =>  random_int(0, 100),
            'amount' =>  random_int(0, 100),
        ]);

        $response->assertSuccessful();
        PromotionHelp::find($response['data']['id'])->delete();
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


        $response = $this->postJson(route('promotion-help.store'), []);

        
        $response->assertStatus(422);

        DB::rollBack();
    }
}
