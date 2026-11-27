<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['-40', '-40'],
            ['2.5', '36.5'],
            ['-2.5', '27.5'],
            ['12.5', '54.5'],
            ['37.5', '99.5'],
            ['-17.5', '0.5'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setTemperature((float) $celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());

    }
}
