<?php

namespace lfischer\openWeatherMap\RequestAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
     * Check if this request adapter is applicable in your environment.
     *
     * @return bool
     */
    public static function isApplicable(): bool
    {
        return class_exists(Client::class);
    }

    /**
     * @param string $url
     * @return string
     * @throws GuzzleException
     */
    public function request(string $url): string
    {
        return $this->client->request('GET', $url)->getBody()->getContents();
    }
}
