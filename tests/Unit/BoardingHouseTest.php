<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\BoardingHouse;
use App\Models\User;
use Tests\TestCase;

class BoardingHouseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_create_boarding_house()
    {
        $data = [
            'name' => $this->faker->streetName,
            'user_id' => $this->faker->randomElement(['3', '5']),
            'location' => $this->faker->address,
            'price' => $this->faker->randomElement(['1300000', '15000000']),
            'qty' => $this->faker->randomNumber(1),
            'type' => $this->faker->randomElement(['male only', 'female only', 'mix']),
            'status' => 1,
            'description' => $this->faker->paragraph
        ];
        $user = User::factory()->create();
        $item = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->post('boarding-house/add', $data);
        $item->assertStatus(201);
        $item->assertJson($data);
    }

    public function test_success_show_list_posts()
    {
        $datas = BoardingHouse::factory(2)->create()->map(function ($data) {
            return $data->only(['id','name', 'location',
            'price', 'type', 'description']);
        });
        $this->get('/boarding-house')
            ->assertStatus(200)
            ->assertJson($datas->toArray())
            ->assertJsonStructure([
                '*' => ['id','name', 'location',
                'price', 'type', 'description'],
            ]);
    }

    public function test_success_show_boarding_house()
    {
        $item = BoardingHouse::factory()->create();
        $this->get(route('boarding.show', $item->id))
            ->assertStatus(200);
    }

    public function test_success_update_boarding_house()
    {
        $boarding = BoardingHouse::factory()->create();
        $data = [
            'name' => $this->faker->streetName,
            'user_id' => $this->faker->randomElement(['3', '5']),
            'location' => $this->faker->address,
            'price' => $this->faker->randomElement(['1300000', '15000000']),
            'qty' => $this->faker->randomNumber(1),
            'type' => $this->faker->randomElement(['male only', 'female only', 'mix']),
            'status' => 1,
            'description' => $this->faker->paragraph
        ];
        $user = User::factory()->create();
        $item = $this->actingAs($user, 'api')
            ->withSession(['banned' => false])
            ->post('boarding-house/' . $boarding->id . '/update', $data);
        $item->assertStatus(201);
        $item->assertJson($data);
    }
}
