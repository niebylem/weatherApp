<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherRepository")
 */
class Weather
{
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
     * @ORM\Column(type="array")
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
     * @ORM\Column(type="integer")
     */
    private $place;

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

    public function getWeatherConditions(): ?array
    {
        return $this->weatherConditions;
    }

    public function setWeatherConditions(array $weatherConditions): self
    {
        $this->weatherConditions = $weatherConditions;

        return $this;
    }

    public function getTemperature()
    {
        return $this->temperature;
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

    public function setPressure(int $pressure): self
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->humidity;
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

    public function setTemperatureMin($temperature_min): self
    {
        $this->temperature_min = $temperature_min;

        return $this;
    }

    public function getTemperatureMax()
    {
        return $this->temperature_max;
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

    public function setVisibility(int $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getWindSpeed()
    {
        return $this->wind_speed;
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

    public function setClouds(int $clouds): self
    {
        $this->clouds = $clouds;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }
}
