<?php

namespace lfischer\openWeatherMap;

/**
 * API Request class.
 *
 * @author Leonard Fischer <post@leonard.fischer.de>
 */
class Request
{
	const URL = 'http://api.openweathermap.org/data/2.5/weather';

	/**
	 * @var array
	 */
	protected $parameters = [];

	/**
	 * @var string
	 */
	protected $responseJSON = null;

	/**
	 * @var array
	 */
	protected $responseArray = null;


	/**
	 * Constructor.
	 *
	 * @param $apiKey
	 */
	public function __construct ($apiKey)
	{
		$this->parameters['appid'] = $apiKey;
	} // function


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
	public function setAccuracy ($accuracy)
	{
		$this->parameters['type'] = $accuracy;

		return $this;
	} // function


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
	public function setUnits ($units)
	{
		$this->parameters['units'] = $units;

		return $this;
	} // function


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
	public function setLanguage ($lang)
	{
		$this->parameters['lang'] = $lang;

		return $this;
	} // function


	/**
	 * API fetch method.
	 *
	 * @param array $query
	 * @return $this
	 * @throws \ErrorException
	 */
	public function fetch (array $query = [])
	{
		$this->responseJSON = file_get_contents(self::URL . '?' . http_build_query(($this->parameters + $query), null, '&'));
		$this->responseArray = json_decode($this->responseJSON, true);

		if (!is_array($this->responseArray))
		{
			throw new \ErrorException('The Open Weather Map API response returned no valid JSON: ' . $this->responseJSON);
		} // if

		if (!isset($this->responseArray['response']))
		{
			throw new \ErrorException('The Open Weather Map API response is not set or empty: ' . $this->responseJSON);
		} // if

		if (isset($this->responseArray['response']) && isset($this->responseArray['response']['error']))
		{
			throw new \ErrorException('The Open Weather Map API responded with errors: ' . var_export($this->responseArray['response']['error'], true));
		} // if

		return $this;
	} // function


	/**
	 * Method for returning the raw response.
	 *
	 * @return  string
	 */
	public function getResponseJSON ()
	{
		return $this->responseJSON;
	} // function


	/**
	 * Method for returning the response array.
	 *
	 * @return array
	 */
	public function getResponseArray ()
	{
		return $this->responseArray;
	} // function


	/**
	 * Method for returning the response as object.
	 *
	 * @return \stdClass
	 */
	public function getResponseObject ()
	{
		return json_decode($this->responseJSON);
	} // function
} // class