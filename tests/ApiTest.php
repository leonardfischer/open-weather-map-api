<?php declare(strict_types=1);

use lfischer\openWeatherMap\API;
use lfischer\openWeatherMap\Endpoint\ClimateForecastEndpoint;
use lfischer\openWeatherMap\Endpoint\CurrentWeatherEndpoint;
use lfischer\openWeatherMap\Endpoint\DailyForecastEndpoint;
use lfischer\openWeatherMap\Endpoint\HourlyForecastEndpoint;
use lfischer\openWeatherMap\Endpoint\OneCallEndpoint;
use lfischer\openWeatherMap\RequestAdapter\Dump;
use PHPUnit\Framework\TestCase;

final class ApiTest extends TestCase
{
    private const KEY = 'example-key';

    /**
     * @var API
     */
    private $api;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->api = new API(self::KEY);
    }

    public function testUrlFormatting()
    {
        $url = $this->api
            ->setRequestAdapter(new Dump())
            ->fetch('endpoint', ['a' => 1, 'b' => 2]);

        $this->assertEquals(API::URL . 'endpoint?appid=' . self::KEY . '&a=1&b=2', $url);
    }

    public function testGetCurrentWeatherEndpoint()
    {
        $this->assertInstanceOf(CurrentWeatherEndpoint::class, $this->api->getCurrentWeather());
    }

    public function testGetHourlyForecastEndpoint()
    {
        $this->assertInstanceOf(HourlyForecastEndpoint::class, $this->api->getHourlyForecast());
    }

    public function testGetDailyForecastEndpoint()
    {
        $this->assertInstanceOf(DailyForecastEndpoint::class, $this->api->getDailyForecast());
    }

    public function testGetClimateForecastEndpoint()
    {
        $this->assertInstanceOf(ClimateForecastEndpoint::class, $this->api->getClimateForecast());
    }

    public function testGetOneCallEndpoint()
    {
        $this->assertInstanceOf(OneCallEndpoint::class, $this->api->getOneCall());
    }
}
