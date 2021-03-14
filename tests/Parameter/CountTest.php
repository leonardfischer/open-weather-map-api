<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Tests\Parameter;

use lfischer\openWeatherMap\Parameter\CountTrait;
use PHPUnit\Framework\TestCase;
use TypeError;

final class CountTest extends TestCase
{
    use CountTrait;

    public function testSetNullCount()
    {
        $this->setCount(null);

        $this->assertEquals(['cnt' => null], $this->getCountParameter());
    }

    public function testSetValidCount()
    {
        $this->setCount(0);
        $this->assertEquals(['cnt' => 1], $this->getCountParameter());

        $this->setCount(1);
        $this->assertEquals(['cnt' => 1], $this->getCountParameter());

        $this->setCount(50);
        $this->assertEquals(['cnt' => 50], $this->getCountParameter());
    }

    public function testSetInvalidFloat()
    {
        $this->expectException(TypeError::class);
        $this->setCount(1.1);
    }

    public function testSetInvalidString()
    {
        $this->expectException(TypeError::class);
        $this->setCount('1');
    }
}
