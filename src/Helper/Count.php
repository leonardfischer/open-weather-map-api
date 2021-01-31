<?php

namespace lfischer\openWeatherMap\Helper;

use InvalidArgumentException;

/**
 * Class Count
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Helper
 */
class Count
{
    /**
     * Validate a count coordinate.
     *
     * @param int      $value
     * @param int|null $min
     * @param int|null $max
     */
    public static function validate(int $value, ?int $min, ?int $max): void
    {
        if ($min !== null && $value < $min) {
            throw new InvalidArgumentException(sprintf('The count "%s" needs to be higher than %s.', $value, $min));
        }

        if ($max !== null && $value > $max) {
            throw new InvalidArgumentException(sprintf('The count "%s" needs to be lower than %s.', $value, $max));
        }
    }
}
