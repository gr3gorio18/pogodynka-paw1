<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    public function __construct(private readonly MeasurementRepository $measurementRepository, private readonly LocationRepository $locationRepository)
    {
    }

    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $name): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'name' => $name,
        ]);

        if (!$location) {
            return [];
        }

        return $this->getWeatherForLocation($location);
    }

}
