<?php

namespace App\Controller;

use App\Services\Interfaces\WeatherInterface;
use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function index(WeatherInterface $weatherService)
    {
        return new Response(
            'main site, service - ' . $weatherService->getWeather()
        );
    }
}
