<?php

namespace Tests\Feature\Promotions;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\PromotionHelp;


use Faker\Factory as Faker;

class DonatePromotionTest extends TestCase
{
    
    /**
     * @test
    */
    public function can_donate_record_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        
        $record = PromotionHelp::factory()->create();
        $faker = Faker::create();


        $response = $this->postJson(route('promotion-help-donation', $record->getRouteKey()), [
            'amount' =>  random_int(1, 100),
        ]);
    
        $response->assertSuccessful();

        
        DB::rollBack();
    }
    /**
     * @test
    */
    public function cant_donate_record_test()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        
        $record = PromotionHelp::factory()->create();

        $response = $this->postJson(route('promotion-help-donation', $record->getRouteKey()), []);
    
        $response->assertStatus(422);

        DB::rollBack();
    }
}
