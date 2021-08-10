<?php

namespace Tests\Feature\Promotions;

use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use App\Models\PromotionHelp;

class ListPromotionTest extends TestCase
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


        
        $records = PromotionHelp::take(3)->get();
        if (empty($records)) {
            $records = PromotionHelp::factory()->times(3)->create();
        }

        $response = $this->getJson(route('promotion-help.index'));

        $response->assertSuccessful();
        DB::rollBack();
    }
}
