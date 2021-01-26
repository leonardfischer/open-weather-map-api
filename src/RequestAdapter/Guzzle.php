<?php

namespace lfischer\openWeatherMap\RequestAdapter;

use GuzzleHttp\Client;

/**
 * This class will use {@see Client} in order to request the open-weather-map API.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\RequestAdapter
 */
class Guzzle implements RequestAdapterInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Guzzle constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url): string
    {
        return $this->client->request('GET', $url)->getBody()->getContents();
    }
}
