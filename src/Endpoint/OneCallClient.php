<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Endpoint;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Coordinate;
use lfischer\openWeatherMap\Parameter\LanguageTrait;
use lfischer\openWeatherMap\Parameter\UnitTrait;
use lfischer\openWeatherMap\Response\AbstractResponse;

/**
 * Class OneCallClient
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Endpoint
 */
class OneCallClient extends AbstractEndpoint
{
    use LanguageTrait;
    use UnitTrait;

    /**
     * @return array
     */
    private function getSharedParameters(): array
    {
        return $this->getLanguageParameter()
            + $this->getUnitParameter();
    }

    /**
     * To get access to current weather, minute forecast for 1 hour, hourly forecast for 48 hours,
     * daily forecast for 7 days and government weather alerts, use this method.
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $exclude
     * @return AbstractResponse
     * @throws InvalidArgumentException
     */
    public function getCurrentAndForecastByGeographicCoordinates(float $latitude, float $longitude, array $exclude = []): AbstractResponse
    {
        Coordinate::validate($latitude, $longitude);

        $parameters = $this->getSharedParameters();
        $parameters['lat'] = $latitude;
        $parameters['lon'] = $longitude;

        if (count($exclude)) {
            $availableOptions = ['current', 'minutely', 'hourly', 'daily', 'alerts'];

            foreach ($exclude as $item) {
                if (!in_array($item, $availableOptions, true)) {
                    throw new InvalidArgumentException(sprintf('The provided exclude option "%s" is not available, choose from %s.', $item, implode(', ', $availableOptions)));
                }
            }

            $parameters['exclude'] = implode(',', $exclude);
        }

        return $this->doRequest('onecall', $parameters);
    }

    /**
     * To learn about how get access to historical weather data for the previous 5 days,
     * please use this method.
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $timestamp
     * @return AbstractResponse
     * @throws InvalidArgumentException
     */
    public function getHistoricalByGeographicCoordinates(float $latitude, float $longitude, int $timestamp): AbstractResponse
    {
        Coordinate::validate($latitude, $longitude);

        $parameters = $this->getSharedParameters();
        $parameters['lat'] = $latitude;
        $parameters['lon'] = $longitude;

        // The given timestamp should be from within the last five days.
        if ($timestamp < (time() - 5 * 60 * 60 * 24)) {
            throw new InvalidArgumentException(sprintf('The provided timestamp should be from within the last five days.'));
        }

        $parameters['dt'] = $timestamp;

        return $this->doRequest('onecall', $parameters);
    }
}
