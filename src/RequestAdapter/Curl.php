<?php

namespace lfischer\openWeatherMap\RequestAdapter;

use lfischer\openWeatherMap\Exception\CurlRequestException;

/**
 * This class will use {@see curl_exec} in order to request the open-weather-map API.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\RequestAdapter
 */
class Curl implements RequestAdapterInterface
{
    /**
     * Check if this request adapter is applicable in your environment.
     *
     * @return bool
     */
    public static function isApplicable(): bool
    {
        return extension_loaded('curl');
    }

    /**
     * @param string $url
     * @return string
     * @throws CurlRequestException
     */
    public function request(string $url): string
    {
        $resource = curl_init();

        curl_setopt_array($resource, [
            CURLINFO_HEADER_OUT => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
        ]);

        $response = curl_exec($resource);

        curl_close($resource);

        if ($response === false) {
            throw new CurlRequestException(curl_error($resource));
        }

        return (string)$response;
    }
}
