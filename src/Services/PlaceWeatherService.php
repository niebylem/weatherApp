<?php

namespace App\Services;

use App\Entity\Place;
use App\Entity\Weather;
use App\Entity\WeatherCondition;
use App\Repository\PlaceRepository;
use App\Repository\WeatherConditionRepository;
use App\Repository\WeatherRepository;
use App\Services\Interfaces\WeatherInterface;

class PlaceWeatherService
{
    private $weatherRepository;
    private $placeRepository;
    private $weatherConditionRepository;
    private $weatherService;

    public function __construct(
        WeatherRepository $weatherRepository,
        PlaceRepository $placeRepository,
        WeatherConditionRepository $weatherConditionRepository,
        WeatherInterface $weatherService
    ) {
        $this->placeRepository = $placeRepository;
        $this->weatherRepository = $weatherRepository;
        $this->weatherConditionRepository = $weatherConditionRepository;
        $this->weatherService= $weatherService;
    }

    public function getNewestWeatherForCity(Place $place)
    {
        $weather = $this->weatherRepository->findNewestForPlace($place);

        if ($weather === null) {
            $weatherJson = $this->weatherService->getWeather($place->getName());
            $weatherConditions = WeatherCondition::createFromOWMResponse($weatherJson);
            $weatherConditions = $this->weatherConditionRepository->saveNewConditions($weatherConditions);
            $weather = Weather::createFromOWMResponse($weatherJson, $place, $weatherConditions);
            $this->weatherRepository->saveNewWeather($weather);
        }

        return $weather;
    }
}
