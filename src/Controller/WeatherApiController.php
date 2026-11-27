<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('name')] string $name,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response {
        $measurements = $util->getWeatherForCountryAndCity($country, $name);

        if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'name' => $name,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }

            $csv = "name,country,date,temperature(Celsius),temperature(Fahrenheit),cloudiness,chanceOfRain,pressure\n";
            $csv .= implode(
                "\n",
                array_map(fn(Measurement $m) => sprintf(
                    '%s,%s,%s,%s,%s,%s,%s',
                    $name,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getTemperature(),
                    $m->getFahrenheit(),
                    $m->getCloudiness(),
                    $m->getChanceOfRain(),
                    $m->getPressure(),
                ), $measurements)
            );

            return new Response($csv);
        }

        if ($twig) {
            return $this->render('weather_api/index.json.twig', [
                'name' => $name,
                'country' => $country,
                'measurements' => $measurements,
            ]);
        }

        return $this->json([
            'name' => $name,
            'country' => $country,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'temperature(Celsius)' => $m->getTemperature(),
                'temperature(Fahrenheit)' => $m->getFahrenheit(),
                'cloudiness' => $m->getCloudiness(),
                'chanceOfRain' => $m->getChanceOfRain(),
                'pressure' => $m->getPressure(),
            ], $measurements),
        ]);
    }
}
