<?php

namespace lfischer\openWeatherMap;

/**
 * Basic Weather API class to execute predefined requests.
 *
 * @author Leonard Fischer <post@leonard.fischer.de>
 */
class API extends Request
{
	/**
	 * Retrieves weather data by a (API internal) "city ID".
	 *
	 * @param integer $id
	 * @return array
	 */
	public function getByCityId ($id)
	{
		return $this->fetch(['id' => $id])->getResponseArray();
	} // function


	/**
	 * Retrieves weather data by geo coordinates.
	 *
	 * @param float $lat
	 * @param float $lng
	 * @return array
	 */
	public function getByCoordinates ($lat, $lng)
	{
		return $this->fetch(['lat' => $lat, 'lon' => $lng])->getResponseArray();
	} // function


	/**
	 * Retrieves weather data by ZIP code and (optional) country code.
	 *
	 * @param string $zip
	 * @param string $countryCode
	 * @return array
	 */
	public function getByZipCode ($zip, $countryCode = null)
	{
		return $this->fetch(['zip' => $zip . ($countryCode !== null ? ',' . $countryCode : '')])->getResponseArray();
	} // function


	/**
	 * Retrieves weather data by city name and (optional) country code.
	 *
	 * @param string $city
	 * @param string $countryCode
	 * @return array
	 */
	public function getByCityName ($city, $countryCode = null)
	{
		return $this->fetch(['q' => $city . ($countryCode !== null ? ',' . $countryCode : '')])->getResponseArray();
	} // function
} // class