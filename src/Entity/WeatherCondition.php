<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeatherConditionRepository")
 */
class WeatherCondition
{
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

    public function __toString()
    {
        return 'weather condition' . $this->id;
    }

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

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
