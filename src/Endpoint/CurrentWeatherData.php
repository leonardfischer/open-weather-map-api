<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Endpoint;

use InvalidArgumentException;
use lfischer\openWeatherMap\Helper\Coordinate;
use lfischer\openWeatherMap\Parameter\LanguageTrait;
use lfischer\openWeatherMap\Parameter\ModeTrait;
use lfischer\openWeatherMap\Parameter\UnitTrait;
use lfischer\openWeatherMap\Response\AbstractResponse;

/**
 * Class CurrentWeatherData
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Endpoint
 */
class CurrentWeatherData extends AbstractEndpoint
{
    use LanguageTrait;
    use ModeTrait;
    use UnitTrait;

    /**
     * @return array
     */
    private function getSharedParameters(): array
    {
        return $this->getModeParameter()
            + $this->getUnitParameter()
            + $this->getLanguageParameter();
    }

    /**
     * Get weather by "<city name>", "<city name>,<state code>" or "<city name>,<state code>,<country code>".
     * Please note that searching by states available only for the USA locations.
     *
     * @param string $cityName The city name can also contain the state code and country code.
     * @return AbstractResponse
     */
    public function byCityName(string $cityName): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['q'] = $cityName;

        return $this->doRequest('weather', $parameters);
    }

    /**
     * You can make an API call by city ID. A list of city IDs can be downloaded at: http://bulk.openweathermap.org/sample/
     * It is recommended to call the API by city ID to get unambiguous result for your city.
     *
     * @param int $id
     * @return AbstractResponse
     */
    public function byCityId(int $id): AbstractResponse
    {
        $parameters = $this->getSharedParameters();
        $parameters['id'] = $id;

        return $this->doRequest('weather', $parameters);
    }

    /**
     * Get weather by geographic coordinates e.q. latitude and longitude.
     * Please note that the latitude can only hold values between -90 and +90,
     * while the longitude can contain a value between -180 and +180.
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

        if ($country !== null) {
            $parameters['zip'] .= ',' . $country;
        }

        return $this->doRequest('weather', $parameters);
    }

    /**
     * This API returns the data from cities within the defined rectangle specified by the geographic coordinates.
     *
     * @param float $longitudeLeft
     * @param float $latitudeBottom
     * @param float $longitudeRight
     * @param float $latitudeTop
     * @param int   $zoom
     * @return AbstractResponse
     */
    public function citiesWithinRectangleZone(float $longitudeLeft, float $latitudeBottom, float $longitudeRight, float $latitudeTop, int $zoom): AbstractResponse
    {
        Coordinate::validate($longitudeLeft, $latitudeBottom);
        Coordinate::validate($longitudeRight, $latitudeTop);

        $parameters = $this->getUnitParameter()
            + $this->getLanguageParameter()
            + ['bbox' => implode(',', [$longitudeLeft, $latitudeBottom, $longitudeRight, $latitudeTop, $zoom])];

        return $this->doRequest('box/city', $parameters);
    }

    /**
     * API returns data from cities laid within definite circle that is specified by center point (lat, lon)
     * and expected number of cities (cnt) around this point.
     *
     * @param float    $latitude
     * @param float    $longitude
     * @param int|null $numberOfCities
     * @return AbstractResponse
     */
    public function citiesInCircle(float $latitude, float $longitude, ?int $numberOfCities = null): AbstractResponse
    {
        Coordinate::validate($latitude, $longitude);

        $parameters = $this->getSharedParameters();
        $parameters['lat'] = $latitude;
        $parameters['lon'] = $longitude;
        $parameters['cnt'] = $numberOfCities;

        return $this->doRequest('find', $parameters);
    }

    /**
     * There is a possibility to get current weather data for several cities by making one API call.
     *
     * @param array $ids
     * @return AbstractResponse
     */
    public function bySeveralCityId(array $ids): AbstractResponse
    {
        if (count($ids) !== count(array_filter($ids, 'is_int'))) {
            throw new InvalidArgumentException('You need to provide only integer values.');
        }

        $parameters = $this->getUnitParameter()
            + $this->getLanguageParameter()
            + ['id' => implode(',', $ids)];

        return $this->doRequest('group', $parameters);
    }
}
