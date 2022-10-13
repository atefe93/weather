<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Repositories\WeatherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Stevebauman\Location\Facades\Location;

class WeatherController extends Controller
{
    public function current($name)
    {
        $response = Http::get('http://api.weatherapi.com/v1/current.json?key='.env('V1_API_KEY').'&q='.$name);

        return json_decode($response);
    }

    public function forecast($name,$days)
    {
        $response = Http::get('http://api.weatherapi.com/v1/forecast.json?key='.env('V1_API_KEY').'&q='.$name.'&days='.$days);

             resolve(WeatherRepository::class)->create($name, $response);

        return json_decode($response) ;
    }

    public function history()
    {
      return response()->json(resolve(WeatherRepository::class)->getHistories()) ;
    }

    public function suggestion($ip)
    {
     //   $ip = '2.147.78.215'; /* Static IP address */

       $currentUserInfo = Location::get($ip);
        if (!$currentUserInfo){
            return response()->json(['message'=>'this ip is not true']);
        }

        return response()->json(['city'=>$currentUserInfo->cityName]);
    }



}
