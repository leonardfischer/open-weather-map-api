<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Tests\Helper;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Coordinate;
use PHPUnit\Framework\TestCase;
use TypeError;

final class CoordinateTest extends TestCase
{
    /**
     * @param float $latitude
     * @param float $longitude
     * @dataProvider invalidCoordinates
     */
    public function testInvalidCoordinates(float $latitude, float $longitude)
    {
        $this->expectException(InvalidArgumentException::class);

        Coordinate::validate($latitude, $longitude);
    }

    public function invalidCoordinates(): array
    {
        return [
            [-90.1, 0],
            [-91, 0],
            [90.1, 0],
            [91, 0],
            [0, -180.1],
            [0, -181],
            [0, 180.1],
            [0, 181]
        ];
    }

    /**
     * @param mixed $latitude
     * @param mixed $longitude
     * @dataProvider typeErrorCoordinates
     */
    public function testTypeErrors($latitude, $longitude)
    {
        $this->expectException(TypeError::class);

        Coordinate::validate($latitude, $longitude);
    }

    public function typeErrorCoordinates(): array
    {
        return [
            [0, 'string'],
            [0, null],
            [0, []],
            [0, true],
            [0, false]
        ];
    }
}
