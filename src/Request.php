<?php

namespace lfischer\openWeatherMap;

/**
 * API Request class.
 *
 * @author Leonard Fischer <post@leonard.fischer.de>
 */
class Request
{
    const URL = 'http://api.openweathermap.org/data/2.5/';

    /**
     * Unit constants.
     */
    const UNIT_KELVIN = 'standard';
    const UNIT_FAHRENHEIT = 'imperial';
    const UNIT_CELSIUS = 'metric';

    /**
     * Weather APIs.
     */
    const API_CURRENT_WEATHER = 'weather';
    const API_FORECAST_HOURLY = 'forecast';
    const API_FORECAST_DAYLY = 'forecast/daily';

    /**
     * @var string
     */
    private $api = null;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var string
     */
    private $responseJSON = null;

    /**
     * @var array
     */
    private $responseArray = null;

    /**
     * Constructor.
     *
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->parameters['appid'] = $apiKey;
        $this->api = self::API_CURRENT_WEATHER;
    }

    /**
     * Set a different type of API (current weather data, forecast, ...).
     *
     * @param  string $api
     * @return $this
     * @throws \ErrorException
     */
    public function setApi($api)
    {
        $allowedApis = [
            self::API_CURRENT_WEATHER,
            self::API_FORECAST_HOURLY,
            self::API_FORECAST_DAYLY
        ];

        if (!in_array($api, $allowedApis, true)) {
            throw new \ErrorException('The Open Weather Map API only allows following APIs: ' . implode(', ', $allowedApis));
        }

        $this->api = $api;

        return $this;
    }

    /**
     * Set the accuracy.
     * Possible values are:
     * - Close results: "close"
     * - Accurate results: "accurate"
     *
     * @param string $accuracy
     * @return $this
     * @see http://openweathermap.org/current#accuracy
     */
    public function setAccuracy($accuracy)
    {
        $this->parameters['type'] = $accuracy;

        return $this;
    }

    /**
     * Set the response unit.
     * Possible values are:
     * - Kelvin: "standard"
     * - Fahrenheit: "imperial"
     * - Celsius: "metric"
     *
     * @param string $units
     * @return $this
     * @see http://openweathermap.org/current#data
     */
    public function setUnits($units)
    {
        $allowedUnits = [
            self::UNIT_KELVIN,
            self::UNIT_FAHRENHEIT,
            self::UNIT_CELSIUS
        ];

        if (!in_array($units, $allowedUnits, true)) {
            throw new \ErrorException('The Open Weather Map API only allows following Units: ' . implode(', ', $allowedUnits));
        }

        $this->parameters['units'] = $units;

        return $this;
    }

    /**
     * Set the response language. This will only be applied to the "description" field.
     * Possible values are:
     * - English: "en"
     * - Russian: "ru"
     * - Italian: "it"
     * - Spanish: "es" (or "sp")
     * - Ukrainian: "uk" (or "ua")
     * - German: "de"
     * - Portuguese: "pt"
     * - Romanian: "ro"
     * - Polish: "pl"
     * - Finnish: "fi"
     * - Dutch: "nl"
     * - French: "fr"
     * - Bulgarian: "bg"
     * - Swedish: "sv" (or "se")
     * - Chinese Traditional: "zh_tw"
     * - Chinese Simplified: "zh" (or "zh_cn")
     * - Turkish: "tr"
     * - Croatian: "hr"
     * - Catalan: "ca"
     *
     * @param string $lang
     * @return $this
     * @see http://openweathermap.org/current#multi
     */
    public function setLanguage($lang)
    {
        $this->parameters['lang'] = $lang;

        return $this;
    }

    /**
     * Method for setting a single parameter.
     *
     * @param  string $key
     * @param  string|int $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * API fetch method.
     *
     * @param array $query
     * @return $this
     * @throws \ErrorException
     */
    public function fetch(array $query = [])
    {
        $this->responseJSON = file_get_contents(self::URL . $this->api . '?' . http_build_query(($this->parameters + $query), null, '&'));
        $this->responseArray = json_decode($this->responseJSON, true);

        if (!is_array($this->responseArray)) {
            throw new \ErrorException('The Open Weather Map API response returned no valid JSON: ' . $this->responseJSON);
        }

        return $this;
    }

    /**
     * Method for returning the raw response.
     *
     * @return  string
     */
    public function getResponseJSON()
    {
        return $this->responseJSON;
    }

    /**
     * Method for returning the response array.
     *
     * @return array
     */
    public function getResponseArray()
    {
        return $this->responseArray;
    }

    /**
     * Method for returning the response as object.
     *
     * @return \stdClass
     */
    public function getResponseObject()
    {
        return json_decode($this->responseJSON);
    }
}
