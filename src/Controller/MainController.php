<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\Weather;
use App\Entity\WeatherCondition;
use App\Services\PlaceWeatherService;
use App\Services\Interfaces\WeatherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(WeatherInterface $weatherService)
    {
        $placeRepository = $this->getDoctrine()->getRepository(Place::class);
        $place = $placeRepository->find(756135);

        $placeWeatherRepository = new PlaceWeatherService(
            $this->getDoctrine()->getRepository(Weather::class),
            $this->getDoctrine()->getRepository(Place::class),
            $this->getDoctrine()->getRepository(WeatherCondition::class),
            $weatherService
        );

        $weather = $placeWeatherRepository->getNewestWeatherForCity($place);
        return $this->render('weather.html.twig', [
                'weather' => $weather
            ]);
    }
}
