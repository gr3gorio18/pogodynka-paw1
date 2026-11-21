<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:countrycode',
    description: 'Add a short description for your command',
)]
class WeatherCountrycodeCommand{

    public function __construct(
        private readonly WeatherUtil $weatherUtil,
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country Code')] string $countryCode,
        #[Argument('Name')] string $name,
    ): int {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $name);

        $io->writeln(sprintf('Location: %s, %s', $name, $countryCode));
        $io->table(['Date', 'Temperature', 'Cloudiness', 'ChanceOfRain', 'Pressure'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
            $m->getCloudiness(),
            $m->getChanceOfRain(),
            $m->getPressure()
        ], $measurements));

        return Command::SUCCESS;
    }
}
