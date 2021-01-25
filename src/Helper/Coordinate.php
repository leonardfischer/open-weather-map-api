<?php

namespace lfischer\openWeatherMap\Helper;

use InvalidArgumentException;

/**
 * Class Coordinate
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Helper
 */
class Coordinate
{
    /**
     * Validate a GPS coordinate.
     *
     * @param float $latitude
     * @param float $longitude
     * @return void
     * @throws InvalidArgumentException
     */
    public static function validate(float $latitude, float $longitude): void
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException(sprintf('The latitude can only contain values between -90 and +90, you passed %s.', $latitude));
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException(sprintf('The longitude can only contain values between -180 and +180, you passed %s.', $latitude));
        }
    }
}
