<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /**
     * @test
     * Test registration
     */
    public function testRegister_Owner()
    {
        //User's data
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'IsPremium' => 0,
            // 'credits' => 20,
            'profession' => $this->faker->randomElement(['student', 'employee']),
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'email_verified_at' => now(),
            'password' => '1234567890', // password
            'remember_token' => Str::random(10),
        ];
        //Send post request
        $response = $this->post('/auth/register/owner', $data);
        //Assert it was successful
        $response->assertStatus(200);
        //Delete data
        User::where('email', $data['email'])->delete();
    }

    public function testRegister_Reguler_User()
    {
        //User's data
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'IsPremium' => 0,
            // 'credits' => 20,
            'profession' => $this->faker->randomElement(['student', 'employee']),
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'email_verified_at' => now(),
            'password' => '1234567890', // password
            'remember_token' => Str::random(10),
        ];
        //Send post request
        $response = $this->post('/auth/register/user', $data);
        //Assert it was successful
        $response->assertStatus(200);
    }

    public function testRegister_Premium_User()
    {
        //User's data
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'IsPremium' => 1,
            // 'credits' => 40,
            'profession' => $this->faker->randomElement(['student', 'employee']),
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        //Send post request
        $response = $this->post('/auth/register/user', $data);
        //Assert it was successful
        $response->assertStatus(200);
    }
    /**
     * @test
     * Test login
     */
    public function testLogin()
    {
        //Create user
        $item = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'IsPremium' => 0,
            // 'credits' => 20,
            'profession' => $this->faker->randomElement(['student', 'employee']),
            'birthdate' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'email_verified_at' => now(),
            'password' => '1234567890', // password
            'remember_token' => Str::random(10),
        ]);
        //attempt login
        $response = $this->postJson('/auth/login', [
            'email' => $item->name,
            'password' => $item->password,
        ]);
        //Assert it was successful and a token was received
        $response->assertStatus(200);
    }
}
