<?php

use App\Http\Controllers\api\v1\ApplicationController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\InstalmentController;
use App\Http\Controllers\api\v1\ValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//version control
Route::prefix('v1')->group(function() {
    
    // endpoint autentikasi
    Route::prefix("auth")->group(function() {
        Route::post('login', [AuthController::class, "login"]);
        Route::post('logout', [AuthController::class, "logout"])->middleware('auth:sanctum');
    });

    Route::prefix('validation')->middleware('auth:sanctum')->group(function() {
        Route::post('', [ValidationController::class, 'request']);
        Route::get('', [ValidationController::class, 'get']);
    });

    Route::prefix('instalment_cars')->middleware('auth:sanctum')->group(function() {
        Route::get('', [InstalmentController::class, 'getInstalmentCars']);
        Route::get('{id}', [InstalmentController::class, 'getInstalmentById']);
    });

    Route::prefix('applications')->middleware('auth:sanctum')->group(function() {
        Route::post('', [ApplicationController::class, 'applying']);
        Route::get('', [ApplicationController::class, 'getAll']);
    });
});