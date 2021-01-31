<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Endpoint;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Coordinate;
use lfischer\openWeatherMap\Parameter\CountTrait;
use lfischer\openWeatherMap\Parameter\LanguageTrait;
use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\ModeTrait;
use lfischer\openWeatherMap\Parameter\UnitTrait;
use lfischer\openWeatherMap\Response\AbstractResponse;

/**
 * Class DailyForecastClient
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Endpoint
 */
class DailyForecastClient extends AbstractEndpoint
{
    use CountTrait;
    use LanguageTrait;
    use ModeTrait;
    use UnitTrait;

    /**
     * @return array
     */
    private function getSharedParameters(): array
    {
        return $this->getCountParameter()
            + $this->getLanguageParameter()
            + $this->getModeParameter()
            + $this->getUnitParameter();
    }

    /**
     * You can search 16 day weather forecast with daily average parameters by city name.
     * All weather data can be obtained in JSON and XML formats.
     *
     * @param string $cityName The city name can also contain the state code and country code.
     * @return AbstractResponse
     */
    public function byCityName(string $cityName): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['q'] = $cityName;

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/daily', $parameters);
    }

    /**
     * You can search weather forecast for 16 days with data every day by city ID.
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

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/daily', $parameters);
    }

    /**
     * You can seach 16 day weather forecast with daily average parameters by geographic coordinats.
     * All weather data can be obtained in JSON and XML formats.
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

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/daily', $parameters);
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

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        if ($country !== null) {
            $parameters['zip'] .= ',' . $country;
        }

        return $this->doRequest('forecast/daily', $parameters);
    }
}
