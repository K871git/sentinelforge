<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
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

    public function login(array $credentials): bool
    {
        $attempt = Auth::guard('web')->attempt($credentials);
        return $attempt;
    }
}
