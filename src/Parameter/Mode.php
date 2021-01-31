<?php

namespace lfischer\openWeatherMap\Parameter;

/**
 * Class Mode
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Parameter
 */
class Mode
{
    public const JSON = 'json';

    public const XML = 'xml';

    public const HTML = 'html';

    /**
     * @return string[]
     */
    public static function getAll(): array
    {
        return [
            self::HTML,
            self::JSON,
            self::XML
        ];
    }
}
