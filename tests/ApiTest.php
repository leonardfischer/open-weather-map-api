<?php declare(strict_types=1);

use lfischer\openWeatherMap\API;
use lfischer\openWeatherMap\Endpoint\ClimateForecastClient;
use lfischer\openWeatherMap\Endpoint\CurrentWeatherClient;
use lfischer\openWeatherMap\Endpoint\CurrentWeatherData;
use lfischer\openWeatherMap\Endpoint\DailyForecastClient;
use lfischer\openWeatherMap\Endpoint\DailyForecastData;
use lfischer\openWeatherMap\Endpoint\HourlyForecastClient;
use lfischer\openWeatherMap\Endpoint\HourlyForecastData;
use lfischer\openWeatherMap\RequestAdapter\Dump;
use PHPUnit\Framework\TestCase;

final class ApiTest extends TestCase
{
    private const KEY = 'example-key';

    /**
     * @var API
     */
    private $api;
    private $prophet;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        $this->api = new API(self::KEY);
        $this->prophet = new \Prophecy\Prophet();
    }

    public function testUrlFormatting()
    {
        $url = $this->api
            ->setRequestAdapter(new Dump())
            ->fetch('endpoint', ['a' => 1, 'b' => 2]);

        $this->assertEquals(API::URL . 'endpoint?appid=example-key&a=1&b=2', $url);
    }

    public function testGetCurrentWeatherClient()
    {
        $this->assertInstanceOf(CurrentWeatherClient::class, $this->api->getCurrentWeatherClient());
    }

    public function testGetHourlyForecastClient()
    {
        $this->assertInstanceOf(HourlyForecastClient::class, $this->api->getHourlyForecastClient());
    }

    public function testGetDailyForecastClient()
    {
        $this->assertInstanceOf(DailyForecastClient::class, $this->api->getDailyForecastClient());
    }

    public function testGetClimateForecastClient()
    {
        $this->assertInstanceOf(ClimateForecastClient::class, $this->api->getClimateForecastClient());
    }
}
