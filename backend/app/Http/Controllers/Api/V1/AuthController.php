<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return (new UserResource($user))->response()->setStatusCode(201);
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

    public function login(LoginRequest $request)
    {
        try {
            if (!$this->authService->login($request->validated())) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            $request->session()->regenerate();

            return response()->json([
                'status'  => true,
                'message' => 'Login successful.',
                'user'    => new UserResource($request->user()),
            ], 200);
        } catch (Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function user()
    {
        try {
            return (new UserResource(auth()->user()));
        } catch (Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken(); // invalidate the csrf-token

            return response()->json([
                'status'  => true,
                'message' => 'Logged out successfully.',
            ], 200);
            //return redirect to login page here ill implement in upcoming flow
        } catch (Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
}
    //register()
    //login()
    //user()
    //logout()