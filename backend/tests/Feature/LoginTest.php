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
            'email' => 'test@email.com',
            'password' => 'password',
            'is_active' => true
        ]);

        $this->postJson('/api/login', [
            'email' => 'test@email.com',
            'password' => 'wrong-password'
        ])->assertUnauthorized();
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'test@email.com',
            'password' => 'password',
            'is_active' => false
        ]);

        $this->postJson('/api/login', [
            'email' => 'test@email.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    public function test_invalid_email_returns_422(): void
    {
        $this->postJson('/api/login', [
            'email' => 'invalid-email',
            'password' => 'password'
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_unauthenticated_user_cannot_access_user_route(): void
    {
        $this->getJson('/api/user')->assertUnauthorized();
    }

    public function test_authenticated_user_can_access_user_route(): void
    {
        $user = User::factory()->create();

        // Sanctum example. Use this if your API uses Sanctum.
        \Laravel\Sanctum\Sanctum::actingAs($user);

        $this->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('id', $user->id);
    }

    public function test_password_is_not_returned_in_user_response(): void
    {
        $user = User::factory()->create();

        \Laravel\Sanctum\Sanctum::actingAs($user);

        $this->getJson('/api/user')
            ->assertOk()
            ->assertJsonMissingPath('password');
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $user = User::factory()->create();

        \Laravel\Sanctum\Sanctum::actingAs($user);

        $this->postJson('/api/logout')->assertOk();

        // This checks that the test client is no longer authenticated.
        $this->getJson('/api/user')->assertUnauthorized();
    }

    public function test_login_is_rate_limited_on_sixth_attempt(): void
    {
        // Use a fresh email so previous attempts from other tests don't matter.
        $email = 'rate-limit@example.com';

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->postJson('/api/login', [
                'email' => $email,
                'password' => 'wrong-password',
            ])->assertUnauthorized();
        }

        $this->postJson('/api/login', [
            'email' => $email,
            'password' => 'wrong-password',
        ])->assertTooManyRequests();
    }
    
}
