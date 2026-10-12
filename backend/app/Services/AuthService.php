<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Create a new class instance.
     * 
     *  Validate input
            ↓
        Hash password
            ↓
        Create User
            ↓
        Authenticate user
            ↓
        Return User
     * 
     */
    public function register(array $data): User
    {
        // register service logic
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $user = $user->refresh();
        return $user;
    }
}
