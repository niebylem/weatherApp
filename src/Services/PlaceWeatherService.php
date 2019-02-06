<?php

namespace App\Services;

use App\Entity\Place;
use App\Entity\Weather;
use App\Entity\WeatherCondition;
use App\Entity\WeatherForecast;
use App\Repository\PlaceRepository;
use App\Repository\WeatherConditionRepository;
use App\Repository\WeatherForecastRepository;
use App\Repository\WeatherRepository;
use App\Services\Interfaces\WeatherInterface;
use DateInterval;
use DateTime;

class PlaceWeatherService
{
    private $weatherRepository;
    private $placeRepository;
    private $weatherConditionRepository;
    private $weatherForecastRepository;
    private $weatherService;

    public function __construct(
        WeatherRepository $weatherRepository,
        PlaceRepository $placeRepository,
        WeatherConditionRepository $weatherConditionRepository,
        WeatherForecastRepository $weatherForecastRepository,
        WeatherInterface $weatherService
    ) {
        $this->placeRepository = $placeRepository;
        $this->weatherRepository = $weatherRepository;
        $this->weatherConditionRepository = $weatherConditionRepository;
        $this->weatherForecastRepository = $weatherForecastRepository;
        $this->weatherService= $weatherService;
    }

    public function getNewestWeatherForPlace(Place $place)
    {
        $weather = $this->weatherRepository->findNewestForPlace($place);

        $oneHourAgo = new DateTime();
        $oneHourAgo->sub(new DateInterval('PT1H'));
        if ($weather === null || $weather->getAdded() < $oneHourAgo) {
            $newWeather = $this->weatherService->getWeather($place->getName());
            $weatherConditions = WeatherCondition::createFromOWMResponse($newWeather);
            $weatherConditions = $this->weatherConditionRepository->saveNewConditions($weatherConditions);
            $weather = Weather::createFromOWMResponse($newWeather, $place, $weatherConditions);
            $this->weatherRepository->saveNewWeather($weather);
        }

        return $weather;
    }

    public function getThreeDayWeatherForecastForPlace(Place $place)
    {
        $newestWeatherForecast = $this->weatherForecastRepository->findNewestForPlace($place);

        $threeDaysForward = new DateTime();
        $threeDaysForward->add(new DateInterval('P3D'));
        if ($newestWeatherForecast === null || $newestWeatherForecast->getDate() < $threeDaysForward) {
            $weatherForecast = $this->weatherService->getFiveDayWeatherForecast($place->getName());

            foreach ($weatherForecast['list'] as $index => $newWeather) {
                // if current processed weather is newer than newest one in repository
                if ($newestWeatherForecast === null ||
                    (int)$newWeather['dt'] > $newestWeatherForecast->getTimestamp()
                ) {
                    $weatherForecast = WeatherForecast::createFromOWMResponse($newWeather, $place);
                    $this->weatherForecastRepository->saveNewWeatherForecast($weatherForecast);
                }
            }
        }

        $weatherForecast = $this->weatherForecastRepository->getThreeDayWeatherForecastForPlace($place);

        return $weatherForecast;
    }
}
