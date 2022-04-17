<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardingHouse>
 */
class BoardingHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BoardingHouse::class;
    public function definition()
    {
        return [
            'name' => $this->faker->streetName,
            'user_id' =>$this->faker->randomElement(['3', '5']),
            'location' =>$this->faker->address,
            'price' =>$this->faker->randomElement(['1300000', '15000000']),
            'qty' =>$this->faker->randomNumber(1),
            'type' =>$this->faker->randomElement(['male only', 'female only', 'mix']),
            'status' =>1,
            'description' => $this->faker->paragraph
        ];
    }
}
