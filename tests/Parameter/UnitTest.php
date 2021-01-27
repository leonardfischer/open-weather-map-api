<?php declare(strict_types=1);

use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\ModeTrait;
use lfischer\openWeatherMap\Parameter\Unit;
use lfischer\openWeatherMap\Parameter\UnitTrait;
use PHPUnit\Framework\TestCase;

final class UnitTest extends TestCase
{
    use UnitTrait;

    public function testSetNullUnit()
    {
        $this->setUnit(null);

        $this->assertEquals(['units' => null], $this->getUnitParameter());
    }

    public function testSetValidUnit()
    {
        $this->setUnit(Unit::METRIC);
        $this->assertEquals(['units' => 'metric'], $this->getUnitParameter());

        $this->setUnit(Unit::IMPERIAL);
        $this->assertEquals(['units' => 'imperial'], $this->getUnitParameter());

        $this->setUnit(Unit::STANDARD);
        $this->assertEquals(['units' => 'standard'], $this->getUnitParameter());
    }

    public function testSetInvalidFloat()
    {
        $this->expectException(TypeError::class);
        $this->setUnit(1.1);
    }

    public function testSetInvalidInt()
    {
        $this->expectException(TypeError::class);
        $this->setUnit(1);
    }

    public function testSetInvalidString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->setUnit('foo');
    }
}
