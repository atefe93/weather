<?php
use App\Http\Controllers\API\v2\WeatherController;
use Illuminate\Support\Facades\Route;
Route::prefix('/weather')->group(function () {
    Route::post('/current',[WeatherController::class,'current']);

});
