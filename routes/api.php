<?php

use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1/')->group(function () {

    //Authentication Routes
    include __DIR__.'/v1/auth_routes.php';

    //Weather Routes
    include __DIR__.'/v1/weather_routes.php';


});
Route::prefix('v2/')->group(function () {

    //Weather Routes
    include __DIR__.'/v2/weather_routes.php';


});



