<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherForecastRepository")
 */
class WeatherForecast
{
    public const CELSIUS = '°C';
    const METERS_PER_SECOND = 'm/s';
    const MM_PER_3H = 'mm/3h';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $temperature;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $wind_speed;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5, nullable=true)
     */
    private $snow;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5, nullable=true)
     */
    private $rain;

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
        $date,
        $temperature,
        $wind_speed,
        $clouds,
        $snow,
        $rain,
        Place $place
    ) {
        $this->setDateFromTimestamp($date);
        $this->temperature = $temperature;
        $this->wind_speed = $wind_speed;
        $this->clouds = $clouds;
        $this->snow = $snow;
        $this->rain = $rain;
        $this->place = $place;
    }

    public static function createFromOWMResponse($newWeather, $place)
    {
        $snow = $newWeather['snow']['3h'] ?? null;
        $rain = $newWeather['rain']['3h'] ?? null;
        $weatherForecast = new static(
            $newWeather['dt'],
            $newWeather['main']['temp'],
            $newWeather['wind']['speed'],
            $newWeather['clouds']['all'],
            $snow,
            $rain,
            $place
        );

        return $weatherForecast;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    private function setDateFromTimestamp(int $timestamp)
    {
        $this->date = new \DateTime();
        $this->date->setTimestamp($timestamp);
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function getTimestamp() : int
    {
        return $this->date->getTimestamp();
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * returns temperature with Celsius unit as string
     * @return string
     */
    public function getTemperatureCelsiusString() : string
    {
        return $this->temperature . static::CELSIUS;
    }

    public function setTemperature($temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getWindSpeed()
    {
        return $this->wind_speed;
    }

    public function getWindSpeedWithMPSUnit()
    {
        return $this->wind_speed . ' ' . static::METERS_PER_SECOND;
    }

    public function setWindSpeed($wind_speed): self
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getSnow()
    {
        return $this->snow;
    }

    public function getSnowWithUnit() : string
    {
        return $this->snow . ' ' . static::MM_PER_3H;
    }

    public function setSnow($snow): self
    {
        $this->snow = $snow;

        return $this;
    }

    public function getRain()
    {
        return $this->rain;
    }

    public function getRainWithUnit() : string
    {
        return $this->rain !== null ? $this->rain . ' ' . static::MM_PER_3H : '';
    }

    public function setRain($rain): self
    {
        $this->rain = $rain;

        return $this;
    }

    public function getClouds(): ?int
    {
        return $this->clouds;
    }

    public function setClouds(int $clouds): self
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }
}
