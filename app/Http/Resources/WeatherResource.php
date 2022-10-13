<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{

    public function toArray($request)
    {
        return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'city' => $this->city,
        'lat' => $this->lat,
        'lon' => $this->lon,
        'information' => json_decode($this->information),

    ];
    }
}
