<?php

namespace lfischer\openWeatherMap\RequestAdapter;

/**
 * Interface RequestAdapterInterface
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\RequestAdapter
 */
interface RequestAdapterInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function request(string $url): string;

    /**
     * Check if this request adapter is applicable in your environment.
     *
     * @return bool
     */
    public static function isApplicable(): bool;
}
