<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase; //it prepared the clean database for the test.

    //declare the testing function for the login
    public function test_user_can_log_in_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@email.com',
            'password' => 'password',
            'is_active' => true
        ]);


        $response = $this->withSession([])->postJson('/api/login', [
            'email' => 'test@email.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200); //successfull login status code
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'test@email.com'
        ]);
    }

    public function test_wrong_password_returns_401(): void
    {
        User::factory()->create([
            'email' => fake()->unique()->email(),
            'password' => 'password',
            'is_active' => true
        ]);

        // $this->postJson();
    }
}