<?php

namespace lfischer\openWeatherMap\RequestAdapter;

use lfischer\openWeatherMap\Exception\SimpleRequestException;

/**
 * Class Simple.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\RequestAdapter
 */
class Simple implements RequestAdapterInterface
{
    /**
     * @param string $url
     * @return string
     * @throws SimpleRequestException
     */
    public function request(string $url): string
    {
        $response = file_get_contents($url);

        if ($response === false)
        {
            throw new SimpleRequestException('Fetching the API data via "file_get_contents" resultet in an error.');
        }

        return $response;
    }
}
