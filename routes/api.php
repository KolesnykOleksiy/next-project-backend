<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

//Route::get('/players', [PlayerController::class, 'index']);
//Route::post('/players', [PlayerController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);

