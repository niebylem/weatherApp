<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherConditionRepository")
 */
class WeatherCondition
{
    const OWM_IMAGE_URL = 'http://openweathermap.org/img/w/';
    const OWM_IMAGE_EXTENSION = '.png';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $main;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $icon;

    public function __construct(
        $id,
        $main,
        $description,
        $icon
    ) {
        $this->id = $id;
        $this->main = $main;
        $this->description = $description;
        $this->icon = $icon;
    }

    /**
     * creates weather conditions from OWM response and returns ArrayCollection of WeatherConditions
     * @param $weatherJson
     * @return ArrayCollection
     */
    public static function createFromOWMResponse($weatherJson): ArrayCollection
    {
        $weatherConditions = new ArrayCollection();
        foreach ($weatherJson['weather'] as $index => $weather) {
            $weatherConditions[] = new static(
                $weather['id'],
                $weather['main'],
                $weather['description'],
                $weather['icon']
            );
        }

        return $weatherConditions;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMain(): ?string
    {
        return $this->main;
    }

    public function setMain(string $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getIconUrl() : string
    {
        return static::OWM_IMAGE_URL . $this->icon . static::OWM_IMAGE_EXTENSION;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
