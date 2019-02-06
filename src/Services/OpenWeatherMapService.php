<?php

namespace App\Services;

use App\Entity\WeatherCondition;
use App\Services\Interfaces\RestInterface;
use App\Services\Interfaces\WeatherInterface;

class OpenWeatherMapService implements WeatherInterface
{
    const API_URL = 'http://api.openweathermap.org/data/2.5';
    const GET_WEATHER = '/weather?q=';
    const GET_HISTORY = '/forecast?q=';
    const LOCALE = '&q=lang=pl&units=metric';
    private $restService;
    private $apiKey;

    public function __construct(RestInterface $restService)
    {
        $this->restService = $restService;
        $this->apiKey = $_ENV['OPEN_WEATHER_MAP_API_KEY'];
    }

    /**
     * function requests OWM API for current weather for city given in param
     * @param string $city
     * @return mixed
     */
    public function getWeather(string $city = 'Warsaw')
    {
        $requestedWeather = $this->restService->get(static::API_URL . static::GET_WEATHER . $city .
            '&appid=' . $this->apiKey . static::LOCALE);

        return $requestedWeather;
    }

    /**
     * function requests OWM API for three day weather history for city given in param
     * @param string $city
     * @return mixed
     */
    public function getFiveDayWeatherForecast(string $city = 'Warsaw')
    {
        $requestedWeatherForecast = $this->restService->get(static::API_URL . static::GET_HISTORY . $city .
            '&appid=' . $this->apiKey . static::LOCALE);

        return $requestedWeatherForecast;
    }
}
