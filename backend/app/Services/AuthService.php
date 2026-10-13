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
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->is_active) {
            return false;
        }
        $guard = Auth::guard('web');
        if (!$guard->attempt($credentials)) {
            return false;
        }

        request()->session()->regenerate();

        return true;
    }
}
