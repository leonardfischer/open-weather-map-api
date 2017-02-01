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
	 * Retrieves weather data by given coordinates.
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
	 * Retrieves weather data by given coordinates.
	 *
	 * @param string $zip
	 * @param string $country
	 * @return array
	 */
	public function getByZipCode ($zip, $country = null)
	{
		return $this->fetch(['zip' => $zip . ($country !== null ? ',' . $country : '')])->getResponseArray();
	} // function


	/**
	 * Retrieves weather data by given coordinates.
	 *
	 * @param string $city
	 * @param string $country
	 * @return array
	 */
	public function getByCityName ($city, $country = null)
	{
		return $this->fetch(['q' => $city . ($country !== null ? ',' . $country : '')])->getResponseArray();
	} // function
} // class