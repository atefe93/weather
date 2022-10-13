<?php


namespace App\Repositories;


use App\Http\Resources\WeatherResource;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class WeatherRepository
{

    public function create($name,$response)
    {

        if (Redis::get('test'.Auth::id())<11) {

            $history = History::query()->create([
                'user_id' => Auth::id(),
                'city' => $name,
                'lat'=>$response['location']['lat'],
                'lon'=>$response['location']['lon'],
                'information' => $response
            ]);


            if (Redis::get('test' . Auth::id()) == 0) {

                Redis::setex('test' . Auth::id(), 60 * 60 * 24, \auth()->user()->histories()->count());


            } else {
                Redis::incr('test' . Auth::id());

            }

        }

    }

    public function getHistories()
    {
        return (WeatherResource::collection(\auth()->user()->histories));
    }




}
