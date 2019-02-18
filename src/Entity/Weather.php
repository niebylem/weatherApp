<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherRepository")
 */
class Weather
{
    private const HECTOPASCAL = 'hPa';
    private const METERS = 'm';
    private const PERCENT = '%';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $added;

    /**
     * @ORM\ManyToMany(targetEntity="WeatherCondition")
     * @ORM\JoinTable(name="weathers_conditions",
     *     joinColumns={@ORM\JoinColumn(name="weather_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="weather_condition_id", referencedColumnName="id")})
     */
    private $weatherConditions;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $temperature;

    /**
     * @ORM\Column(type="integer")
     */
    private $pressure;

    /**
     * @ORM\Column(type="integer")
     */
    private $humidity;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $temperature_min;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $temperature_max;

    /**
     * @ORM\Column(type="integer")
     */
    private $visibility;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $wind_speed;

    /**
     * @ORM\Column(type="integer")
     */
    private $clouds;

    /**
     * @ORM\ManyToOne(targetEntity="Place", cascade={"persist"})
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    private $place;

    public function __construct(
        Collection $weatherConditions,
        float $temperature,
        int $pressure,
        int $humidity,
        float $temperature_min,
        float $temperature_max,
        int $visibility,
        float $wind_speed,
        int $clouds,
        Place $place
    ) {
        $this->added = new \DateTime();
        $this->weatherConditions = $weatherConditions;
        $this->temperature = $temperature;
        $this->pressure = $pressure;
        $this->humidity = $humidity;
        $this->temperature_min = $temperature_min;
        $this->temperature_max = $temperature_max;
        $this->visibility = $visibility;
        $this->wind_speed = $wind_speed;
        $this->clouds = $clouds;
        $this->place = $place;
    }

    public static function createFromOWMResponse($weatherJson, Place $place, Collection $weatherConditions): self
    {
        $weather = new self(
            $weatherConditions,
            $weatherJson['main']['temp'],
            $weatherJson['main']['pressure'],
            $weatherJson['main']['humidity'],
            $weatherJson['main']['temp_min'],
            $weatherJson['main']['temp_max'],
            $weatherJson['visibility'],
            $weatherJson['wind']['speed'],
            $weatherJson['clouds']['all'],
            $place
        );

        return $weather;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

    public function setAdded(\DateTimeInterface $added): self
    {
        $this->added = $added;

        return $this;
    }

    public function getWeatherConditions(): Collection
    {
        return $this->weatherConditions;
    }

    public function setWeatherConditions(Collection $weatherConditions): self
    {
        $this->weatherConditions = $weatherConditions;

        return $this;
    }

    public function addWeatherCondition(WeatherCondition $weatherCondition): self
    {
        if (!$this->weatherConditions->contains($weatherCondition)) {
            $this->weatherConditions[] = $weatherCondition;
        }

        return $this;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getTemperatureCelsiusString() : string
    {
        return $this->temperature . WeatherForecast::CELSIUS;
    }

    public function setTemperature($temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getPressure(): ?int
    {
        return $this->pressure;
    }

    public function getPressureWithUnit(): string
    {
        return $this->pressure . ' ' . static::HECTOPASCAL;
    }

    public function setPressure(int $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    public function getHumidityWithUnit(): string
    {
        return $this->humidity . static::PERCENT;
    }

    public function setHumidity(int $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getTemperatureMin()
    {
        return $this->temperature_min;
    }

    public function getTemperatureMinCelsiusString() : string
    {
        return $this->temperature_min . WeatherForecast::CELSIUS;
    }

    public function setTemperatureMin($temperature_min): self
    {
        $this->temperature_min = $temperature_min;

        return $this;
    }

    public function getTemperatureMax()
    {
        return $this->temperature_max;
    }

    public function getTemperatureMaxCelsiusString() : string
    {
        return $this->temperature_max . WeatherForecast::CELSIUS;
    }

    public function setTemperatureMax($temperature_max): self
    {
        $this->temperature_max = $temperature_max;

        return $this;
    }

    public function getVisibility(): ?int
    {
        return $this->visibility;
    }

    public function getVisibilityWithUnit(): string
    {
        return $this->visibility . ' ' . static::METERS;
    }

    public function setVisibility(int $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getWindSpeed()
    {
        return $this->wind_speed;
    }

    public function getWindSpeedWithUnit()
    {
        return $this->wind_speed . ' ' . WeatherForecast::METERS_PER_SECOND;
    }

    public function setWindSpeed($wind_speed): self
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getClouds(): ?int
    {
        return $this->clouds;
    }

    public function getCloudsWithUnit(): string
    {
        return $this->clouds . static::PERCENT;
    }

    public function setClouds(int $clouds): self
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function getPlace(): Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function removeWeatherCondition(WeatherCondition $weatherCondition): self
    {
        if ($this->weatherConditions->contains($weatherCondition)) {
            $this->weatherConditions->removeElement($weatherCondition);
        }

        return $this;
    }
}
