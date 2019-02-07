<?php

namespace App\Controller;

use App\Entity\Place;
use App\Repository\PlaceRepository;
use App\Repository\WeatherConditionRepository;
use App\Repository\WeatherForecastRepository;
use App\Repository\WeatherRepository;
use App\Services\PlaceWeatherService;
use App\Services\Interfaces\WeatherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $placeWeatherRepository;

    public function __construct(
        WeatherInterface $weatherService,
        WeatherRepository $weatherRepository,
        PlaceRepository $placeRepository,
        WeatherConditionRepository $weatherConditionRepository,
        WeatherForecastRepository $weatherForecastRepository
    ) {
        $this->placeWeatherRepository = new PlaceWeatherService(
            $weatherRepository,
            $placeRepository,
            $weatherConditionRepository,
            $weatherForecastRepository,
            $weatherService
        );
    }

    public function index()
    {
        $placeRepository = $this->getDoctrine()->getRepository(Place::class);
        $place = $placeRepository->find(756135);

        $weather = $this->placeWeatherRepository->getNewestWeatherForPlace($place);
        $threeDayForecast = $this->placeWeatherRepository->getThreeDayWeatherForecastForPlace($place);

        return $this->render('weather.html.twig', [
                'place' => $place,
                'weather' => $weather,
                'forecasts' => $threeDayForecast
            ]);
    }
}
