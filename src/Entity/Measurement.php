<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\Column(length: 255)]
    private ?string $cloudiness = null;

    #[ORM\Column(length: 4)]
    private ?string $chanceOfRain = null;

    #[ORM\Column]
    private ?int $pressure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?location
    {
        return $this->location;
    }

    public function setLocation(?location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getCloudiness(): ?string
    {
        return $this->cloudiness;
    }

    public function setCloudiness(string $cloudiness): static
    {
        $this->cloudiness = $cloudiness;

        return $this;
    }

    public function getChanceOfRain(): ?string
    {
        return $this->chanceOfRain;
    }

    public function setChanceOfRain(string $chanceOfRain): static
    {
        $this->chanceOfRain = $chanceOfRain;

        return $this;
    }

    public function getPressure(): ?int
    {
        return $this->pressure;
    }

    public function setPressure(int $pressure): static
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getFahrenheit(): ?float
    {
        if ($this->temperature === null) {
            return null;
        }

        return ($this->temperature * 9 / 5) + 32;
    }
}
