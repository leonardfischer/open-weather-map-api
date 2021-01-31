<?php declare(strict_types=1);

use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\ModeTrait;
use PHPUnit\Framework\TestCase;

final class ModeTest extends TestCase
{
    use ModeTrait;

    public function testSetNullMode()
    {
        $this->setMode(null);

        $this->assertEquals(['mode' => null], $this->getModeParameter());
    }

    public function testSetValidMode()
    {
        $this->setMode(Mode::HTML);
        $this->assertEquals(['mode' => 'html'], $this->getModeParameter());

        $this->setMode(Mode::XML);
        $this->assertEquals(['mode' => 'xml'], $this->getModeParameter());

        $this->setMode(Mode::JSON);
        $this->assertEquals(['mode' => 'json'], $this->getModeParameter());
    }

    public function testSetInvalidFloat()
    {
        $this->expectException(TypeError::class);
        $this->setMode(1.1);
    }

    public function testSetInvalidInt()
    {
        $this->expectException(TypeError::class);
        $this->setMode(1);
    }

    public function testSetInvalidString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->setMode('foo');
    }
}
