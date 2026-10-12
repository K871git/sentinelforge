<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}


    public function register(RegisterRequest $request)
    {
        try {

            $user = $this->authService->register($request->validated());
            Log::info("userinfo", [
                "userdata" => $user
            ]);
            return new UserResource($user);
        } catch (Exception $e) {
            Log::error("Error", [
                "status" => false,
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
            ]);
            return response()->json([
                "status" => false,
                "message" => "Something went wrong..!",
            ], 500);
        }
    }
}
    //register()
    //login()
    //user()
    //logout()