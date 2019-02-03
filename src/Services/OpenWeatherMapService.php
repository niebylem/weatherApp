<?php

namespace App\Services;

use App\Services\Interfaces\RestInterface;
use App\Services\Interfaces\WeatherInterface;

class OpenWeatherMapService implements WeatherInterface
{
    private $restService;

    public function __construct(RestInterface $restService)
    {
        $this->restService = $restService;
    }

    public function getWeather()
    {
        return $this->restService->get();
    }
}
