<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(random_int(1, 3)),
            'isbn' => $this->faker->unique()->isbn13(),
            'publisher' => $this->faker->sentence(),
            'year' => $this->faker->year(),
            'price' =>  random_int(1, 999), // password
            'quantity' =>  random_int(1, 100),
            'user_id' => User::factory()
        ];
    }
}
