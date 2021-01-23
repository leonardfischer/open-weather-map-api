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
    public function request(string $url): string;
}
