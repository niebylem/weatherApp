<?php

namespace App\Services\Interfaces;

interface WeatherInterface
{
    public function __construct(RestInterface $restService);

    public function getWeather(string $city);

    public function getFiveDayWeatherForecast(string $city);
}
