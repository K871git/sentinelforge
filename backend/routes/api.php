<?php

use Illuminate\Support\Facades\Route;

Route::get('/check',function(){
    return response()->json([
        "status"=>true,
        "message"=>"Backend is running successfully",
    ],200);
});