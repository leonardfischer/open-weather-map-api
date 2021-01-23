<?php

namespace lfischer\openWeatherMap\Helper;

use InvalidArgumentException;

class Coordinate
{
    public static function validate(float $latitude, float $longitude)
    {
        if ($latitude < -90 || $latitude > 90)
        {
            throw new InvalidArgumentException(sprintf('The latitude can only contain values between -90 and +90, you passed %s.', $latitude));
        }

        if ($longitude < -180 || $longitude > 180)
        {
            throw new InvalidArgumentException(sprintf('The longitude can only contain values between -180 and +180, you passed %s.', $latitude));
        }
    }
}
