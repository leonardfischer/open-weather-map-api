<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Tests\Parameter;

use InvalidArgumentException;
use lfischer\openWeatherMap\Parameter\Language;
use lfischer\openWeatherMap\Parameter\LanguageTrait;
use PHPUnit\Framework\TestCase;
use TypeError;

final class LanguageTest extends TestCase
{
    use LanguageTrait;

    public function testSetNullLanguage()
    {
        $this->setLanguage(null);

        $this->assertEquals(['lang' => null], $this->getLanguageParameter());
    }

    public function testSetValidLanguage()
    {
        $this->setLanguage(Language::GREEK);
        $this->assertEquals(['lang' => 'el'], $this->getLanguageParameter());

        $this->setLanguage(Language::ENGLISH);
        $this->assertEquals(['lang' => 'en'], $this->getLanguageParameter());

        $this->setLanguage(Language::GERMAN);
        $this->assertEquals(['lang' => 'de'], $this->getLanguageParameter());
    }

    public function testSetInvalidFloat()
    {
        $this->expectException(TypeError::class);
        $this->setLanguage(1.1);
    }

    public function testSetInvalidInt()
    {
        $this->expectException(TypeError::class);
        $this->setLanguage(1);
    }

    public function testSetInvalidString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->setLanguage('foo');
    }
}
