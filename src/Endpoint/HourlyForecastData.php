<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Endpoint;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Coordinate;
use lfischer\openWeatherMap\Parameter\CountTrait;
use lfischer\openWeatherMap\Parameter\LanguageTrait;
use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\ModeTrait;
use lfischer\openWeatherMap\Response\AbstractResponse;

/**
 * Class CurrentWeatherData
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Endpoint
 */
class HourlyForecastData extends AbstractEndpoint
{
    use ModeTrait;
    use CountTrait;
    use LanguageTrait;

    /**
     * @return array
     */
    private function getSharedParameters(): array
    {
        return $this->getModeParameter()
            + $this->getCountParameter()
            + $this->getLanguageParameter();
    }

    /**
     * You can search weather forecast for 4 days (96 hours) with data every hour by city name.
     * All weather data can be obtained in JSON and XML formats.
     *
     * @param string $cityName The city name can also contain the state code and country code.
     * @return AbstractResponse
     */
    public function byCityName(string $cityName): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['q'] = $cityName;

        if ($parameters['mode'] === Mode::HTML)
        {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/hourly', $parameters);
    }

    /**
     * You can search weather forecast for 4 days with data every hour by city ID.
     * A list of city IDs can be downloaded at: http://bulk.openweathermap.org/sample/
     * It is recommended to call the API by city ID to get unambiguous result for your city.
     *
     * @param int $id
     * @return AbstractResponse
     */
    public function byCityId(int $id): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['id'] = $id;

        if ($parameters['mode'] === Mode::HTML)
        {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/hourly', $parameters);
    }


    /**
     * You can search weather forecast for 4 days with data every hour by geographic coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @return AbstractResponse
     */
    public function byGeographicCoordinates(float $latitude, float $longitude): AbstractResponse
    {
        Coordinate::validate($latitude, $longitude);

        $parameters = $this->getSharedParameters();
        $parameters['lat'] = $latitude;
        $parameters['lon'] = $longitude;

        if ($parameters['mode'] === Mode::HTML)
        {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('weather', $parameters);
    }

    /**
     * Please note if country is not specified then the search works for USA as a default.
     *
     * @param int         $zip
     * @param string|null $country
     * @return AbstractResponse
     */
    public function byZipCode(int $zip, ?string $country = null): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['zip'] = $zip;
        
        if ($parameters['mode'] === Mode::HTML)
        {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        if ($country !== null)
        {
            $parameters['zip'] .= ',' . $country;
        }

        return $this->doRequest('weather', $parameters);
    }
}
