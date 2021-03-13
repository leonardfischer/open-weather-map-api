<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Endpoint;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Coordinate;
use lfischer\openWeatherMap\Helper\Count;
use lfischer\openWeatherMap\Parameter\CountTrait;
use lfischer\openWeatherMap\Parameter\LanguageTrait;
use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\ModeTrait;
use lfischer\openWeatherMap\Parameter\UnitTrait;
use lfischer\openWeatherMap\Response\AbstractResponse;

/**
 * Class ClimateForecastClient.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Endpoint
 */
class ClimateForecastClient extends AbstractEndpoint
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
     * You can search climate forecast for 30 days.
     * All weather data can be obtained in JSON and XML formats.
     *
     * @param string $cityName The city name can also contain the state code and country code.
     * @return AbstractResponse
     */
    public function byCityName(string $cityName): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['q'] = $cityName;

        if ($parameters['cnt'] !== null) {
            Count::validate($parameters['cnt'], 1, 16);
        }

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/climate', $parameters);
    }

    /**
     * You can search weather climate for 30 days.
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

        if ($parameters['cnt'] !== null) {
            Count::validate($parameters['cnt'], 1, 16);
        }

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/climate', $parameters);
    }

    /**
     * You can search weather climate for 30 days.
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

        if ($parameters['cnt'] !== null) {
            Count::validate($parameters['cnt'], 1, 16);
        }

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        return $this->doRequest('forecast/climate', $parameters);
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

        if ($parameters['cnt'] !== null) {
            Count::validate($parameters['cnt'], 1, 16);
        }

        if ($parameters['mode'] === Mode::HTML) {
            throw new InvalidArgumentException(sprintf('The mode "%s" is not applicable to this API call.', Mode::HTML));
        }

        if ($country !== null) {
            $parameters['zip'] .= ',' . $country;
        }

        return $this->doRequest('forecast/climate', $parameters);
    }
}
