<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 200,
        'data' => [
            'message' => "but I'm still seeking!"
        ]
    ]);
});
