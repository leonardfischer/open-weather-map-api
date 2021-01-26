<?php

namespace lfischer\openWeatherMap\RequestAdapter;

/**
 * This class can be used to simply retrieve the prepared URL if you like to make your own requests.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\RequestAdapter
 */
class Dump implements RequestAdapterInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function request(string $url): string
    {
        return $url;
    }
}
