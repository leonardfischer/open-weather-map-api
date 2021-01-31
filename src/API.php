<?php

namespace lfischer\openWeatherMap;

use lfischer\openWeatherMap\Endpoint\ClimateForecastClient;
use lfischer\openWeatherMap\Endpoint\CurrentWeatherClient;
use lfischer\openWeatherMap\Endpoint\DailyForecastClient;
use lfischer\openWeatherMap\Endpoint\HourlyForecastClient;
use lfischer\openWeatherMap\RequestAdapter\RequestAdapterInterface;
use lfischer\openWeatherMap\RequestAdapter\Simple;

/**
 * Basic Weather API class to execute predefined requests.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap
 */
class API
{
    public const URL = 'http://api.openweathermap.org/data/2.5/';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var RequestAdapterInterface
     */
    private $requestAdapter;

    /**
     * Constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->requestAdapter = new Simple();
    }

    /**
     * @param string $endpoints
     * @param array  $parameters
     * @return string
     */
    public function fetch(string $endpoints, array $parameters = []): string
    {
        $url = self::URL . $endpoints . '?' . http_build_query(array_filter(['appid' => $this->apiKey] + $parameters));

        return $this->requestAdapter->request($url);
    }

    /**
     * Set a different request adapter to have more control over the request and response.
     *
     * @param RequestAdapterInterface $requestAdapter
     * @return $this
     */
    public function setRequestAdapter(RequestAdapterInterface $requestAdapter): self
    {
        $this->requestAdapter = $requestAdapter;

        return $this;
    }

    /**
     * Get the CurrentWeatherClient endpoint.
     *
     * @return CurrentWeatherClient
     */
    public function getCurrentWeatherClient(): CurrentWeatherClient
    {
        return new CurrentWeatherClient($this);
    }

    /**
     * Get the HourlyForecastClient endpoint.
     *
     * @return HourlyForecastClient
     */
    public function getHourlyForecastClient(): HourlyForecastClient
    {
        return new HourlyForecastClient($this);
    }

    /**
     * Get the DailyForecastClient endpoint.
     *
     * @return DailyForecastClient
     */
    public function getDailyForecastClient(): DailyForecastClient
    {
        return new DailyForecastClient($this);
    }

    /**
     * Get the ClimateForecastClient endpoint.
     *
     * @return ClimateForecastClient
     */
    public function getClimateForecastClient(): ClimateForecastClient
    {
        return new ClimateForecastClient($this);
    }
}
