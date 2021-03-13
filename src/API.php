<?php

namespace lfischer\openWeatherMap;

use lfischer\openWeatherMap\Endpoint\ClimateForecastEndpoint;
use lfischer\openWeatherMap\Endpoint\CurrentWeatherEndpoint;
use lfischer\openWeatherMap\Endpoint\DailyForecastEndpoint;
use lfischer\openWeatherMap\Endpoint\HourlyForecastEndpoint;
use lfischer\openWeatherMap\Endpoint\OneCallEndpoint;
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
     * Get the ClimateForecastClient endpoint.
     *
     * @return ClimateForecastEndpoint
     */
    public function getClimateForecast(): ClimateForecastEndpoint
    {
        return new ClimateForecastEndpoint($this);
    }

    /**
     * Get the CurrentWeatherClient endpoint.
     *
     * @return CurrentWeatherEndpoint
     */
    public function getCurrentWeather(): CurrentWeatherEndpoint
    {
        return new CurrentWeatherEndpoint($this);
    }

    /**
     * Get the DailyForecastClient endpoint.
     *
     * @return DailyForecastEndpoint
     */
    public function getDailyForecast(): DailyForecastEndpoint
    {
        return new DailyForecastEndpoint($this);
    }

    /**
     * Get the HourlyForecastClient endpoint.
     *
     * @return HourlyForecastEndpoint
     */
    public function getHourlyForecast(): HourlyForecastEndpoint
    {
        return new HourlyForecastEndpoint($this);
    }

    /**
     * Get the OneCallClient endpoint.
     *
     * @return OneCallEndpoint
     */
    public function getOneCall(): OneCallEndpoint
    {
        return new OneCallEndpoint($this);
    }
}
