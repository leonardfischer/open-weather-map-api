<?php

namespace lfischer\openWeatherMap;

use lfischer\openWeatherMap\Endpoint\CurrentWeatherData;
use lfischer\openWeatherMap\Endpoint\HourlyForecastData;
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
     * Get the CurrentWeatherData endpoint.
     *
     * @return CurrentWeatherData
     */
    public function getCurrentWeatherClient(): CurrentWeatherData
    {
        return new CurrentWeatherData($this);
    }

    /**
     * Get the HourlyForecastData endpoint.
     *
     * @return HourlyForecastData
     */
    public function getHourlyForecastClient(): HourlyForecastData
    {
        return new HourlyForecastData($this);
    }
}
