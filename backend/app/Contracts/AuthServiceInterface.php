<?php

use App\Models\User;

interface AuthServiceInterface
{
    public function login(array $credentials): bool;
    public function register(array $data): User;
}
