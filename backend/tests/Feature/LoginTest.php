<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;//it prepared the clean database for the test.

    //declare the testing function for the login
    public function test_user_can_log_in_with_valid_credentials(): void {
        
    }
}
