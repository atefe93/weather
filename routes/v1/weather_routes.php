<?php

use App\Http\Controllers\API\v1\WeatherController;
use Illuminate\Support\Facades\Route;

Route::prefix('/weather')->group(function () {
    Route::get('/current/{name}', [WeatherController::class, 'current']);
    Route::middleware('auth:sanctum')->get('/forecast/{name}/{days}', [WeatherController::class, 'forecast']);
    Route::middleware('auth:sanctum')->get('/history', [WeatherController::class, 'history']);
    Route::get('/suggestion/{ip}', [WeatherController::class, 'suggestion']);
});
