<?php declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Place;
use App\Repository\PlaceRepository;
use App\Repository\WeatherConditionRepository;
use App\Repository\WeatherForecastRepository;
use App\Repository\WeatherRepository;
use App\Services\PlaceWeatherService;
use JMS\Serializer\SerializerBuilder;
use App\Services\Interfaces\WeatherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $placeWeatherRepository;
    private $serializer;

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
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function index(): JsonResponse
    {
        return $this->json(['status'=>'true']);
    }

    /**
     * @Route("/api/threedayweather")
     */
    public function threeDayForecast(): JsonResponse
    {
        $placeRepository = $this->getDoctrine()->getRepository(Place::class);
        $place = $placeRepository->find(756135);

        $threeDayForecast = $this->placeWeatherRepository->getThreeDayWeatherForecastForPlace($place);

        $forecastArray = [];
        foreach ($threeDayForecast as $index => $forecast) {
            $forecastArray[] = $this->serializer->toArray($forecast);
        }

        return $this->json($forecastArray);
    }
}
