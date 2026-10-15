<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_user_registration(): void
    {
        // Arrange Data 
        $data = [
            'name' => 'testcase1',
            'email' => 'testcase1@gmail.com',
            'password' => 'testcase1',
            'password_confirmation' => 'testcase1'
        ];

        // Act : hitting the API with data 
        $response = $this->post('/api/register', $data);

        //Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => 'testcase1',
            'email' => 'testcase1@gmail.com',
        ]);
    }
}
