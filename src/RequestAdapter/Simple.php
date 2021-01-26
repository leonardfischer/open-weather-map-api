<?php

namespace lfischer\openWeatherMap\RequestAdapter;

use lfischer\openWeatherMap\Exception\SimpleRequestException;

/**
 * This class will use {@see file_get_contents} in order to request the open-weather-map API.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\RequestAdapter
 */
class Simple implements RequestAdapterInterface
{
    /**
     * Check if this request adapter is applicable in your environment.
     *
     * @return bool
     */
    public static function isApplicable(): bool
    {
        return (bool) ini_get('allow_url_fopen');
    }

    /**
     * @param string $url
     * @return string
     * @throws SimpleRequestException
     */
    public function request(string $url): string
    {
        $response = file_get_contents($url);

        if ($response === false) {
            throw new SimpleRequestException('Fetching the API data via "file_get_contents" resultet in an error.');
        }

        return $response;
    }
}
