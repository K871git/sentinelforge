<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //register()
    //login()
    //user()
    //logout()

    public function register(RegisterRequest $request)
    {
        try {
            dd($request->all());
        } catch (Exception $e) {
            Log::error("Error", [
                "status" => false,
                "message" => "Something went wrong..!",
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "error" => $e->getMessage(),
            ], 500);
        }
    }
}
