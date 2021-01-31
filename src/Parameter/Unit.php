<?php

namespace lfischer\openWeatherMap\Parameter;

/**
 * Class Unit
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Parameter
 */
class Unit
{
    public const STANDARD = 'standard';

    public const METRIC = 'metric';

    public const IMPERIAL = 'imperial';

    /**
     * @return string[]
     */
    public static function getAll(): array
    {
        return [
            self::STANDARD,
            self::METRIC,
            self::IMPERIAL
        ];
    }
}
