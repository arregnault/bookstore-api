<?php

namespace Database\Factories;

use App\Models\PromotionHelp;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\User;

class PromotionHelpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PromotionHelp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' =>  random_int(1, 999),
            'book_id' => Book::factory()->create()->update(['is_active' => 1]),
        ];
    }
}
