<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Tests\Helper;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Count;
use PHPUnit\Framework\TestCase;
use TypeError;

final class CountTest extends TestCase
{
    /**
     * @param int      $value
     * @param int|null $min
     * @param int|null $max
     * @dataProvider invalidCounts
     */
    public function testInvalidCounts(int $value, ?int $min = null, ?int $max = null)
    {
        $this->expectException(InvalidArgumentException::class);

        Count::validate($value, $min, $max);
    }

    public function invalidCounts(): array
    {
        return [
            [1, 2, null],
            [2, null, 1],
            [1, 2, 3],
            [3, 1, 2]
        ];
    }

    /**
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     * @dataProvider typeErrorCounts
     */
    public function testTypeErrors($value, $min = null, $max = null)
    {
        $this->expectException(TypeError::class);

        Count::validate($value, $min, $max);
    }

    public function typeErrorCounts(): array
    {
        return [
            ['string', null, null],
            [null, null, null],
            [[], null, null],
            [true, null, null],
            [false, null, null],
            [1.1, null, null],
            [1, 'string', null],
            [1, [], null],
            [1, true, null],
            [1, false, null],
            [1, 0.1, null],
            [1, null, 'string'],
            [1, null, []],
            [1, null, true],
            [1, null, false],
            [1, null, 1.1],
        ];
    }
}
