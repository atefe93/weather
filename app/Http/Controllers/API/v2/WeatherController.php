<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Repositories\WeatherRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Stevebauman\Location\Facades\Location;

class WeatherController extends Controller
{
    public function current(Request $request)
    {
        if ($request->name) {

            $response = Http::get('https://api.openweathermap.org/data/2.5/weather?&q=' . $request->name . '&appid=' . env('V2_API_KEY'));
        }
        elseif ($request->lat && $request->lon) {

            $response = Http::get('https://api.openweathermap.org/data/2.5/weather?lat=' . $request->lat . '&lon=' . $request->lon . '&appid=' . env('V2_API_KEY'));

        } else {

            return response()->json(['message' => 'please send parameters'],Response::HTTP_BAD_REQUEST);
        }


        return json_decode($response);
    }


}
