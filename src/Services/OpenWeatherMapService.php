<?php declare(strict_types = 1);

namespace App\Services;

use App\Services\Interfaces\RestInterface;
use App\Services\Interfaces\WeatherInterface;

class OpenWeatherMapService implements WeatherInterface
{
    const API_URL = 'http://api.openweathermap.org/data/2.5';
    const GET_WEATHER = '/weather?';
    const GET_HISTORY = '/forecast?';
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
        $query = $this->getQuery($city);
        $requestedWeather = $this->restService->get(static::API_URL . static::GET_WEATHER . $query);

        return $requestedWeather;
    }

    /**
     * function requests OWM API for three day weather history for city given in param
     * @param string $city
     * @return mixed
     */
    public function getFiveDayWeatherForecast(string $city = 'Warsaw')
    {
        $query = $this->getQuery($city);
        $requestedWeatherForecast = $this->restService->get(static::API_URL . static::GET_HISTORY . $query);

        return $requestedWeatherForecast;
    }

    /**
     * get prepared query url with locales, api key and city name
     * @param string $city
     * @return string
     */
    private function getQuery(string $city): string
    {
        $query = http_build_query([
            'q' => $city,
            'lang' => 'pl',
            'units' => 'metric',
            'appid' => $this->apiKey
        ]);

        return $query;
    }
}
