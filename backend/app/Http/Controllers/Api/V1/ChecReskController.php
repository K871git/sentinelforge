<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChecReskController extends Controller
{
    public function check1()
    {
        return response()->json([
            "status" => true,
            "message" => "API is running..!"
        ], 200);
    }
}
