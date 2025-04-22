<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

//Route::get('/players', [PlayerController::class, 'index']);
//Route::post('/players', [PlayerController::class, 'store']);
//Route::post('/register', [AuthController::class, 'register']);

Route::prefix('v1')->group(function (){
    Route::post('login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\v1\AuthController::class, 'register']);


    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('logout', [\App\Http\Controllers\Api\v1\AuthController::class, 'logout']);

        Route::get('/', [\App\Http\Controllers\Api\v1\HomeController::class, 'index'])->name('home');
    });
});
