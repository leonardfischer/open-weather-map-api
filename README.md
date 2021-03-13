# Open Weather Map API Client

This library will help you integrate the Open Weather Map API to your webservice.
It is lightweight and provides all necessary code including a lot of convenience methods.

## Quick start

Using the API is very easy - you'll only need to provide a API key (Get one [here](https://openweathermap.org/appid)) in
order to use it. There are endpoints for retrieving different weather data by predefined conditions, like "by country
and city", "by latitude and longitude", "by airport code" or even "by IP address".

Simply create a `API` instance and get the endpoint you need. These endpoints will contain convenience methods with
typed parameters to receive the desired data.

```php
use lfischer\openWeatherMap\API;

// Get weather data by a city and (optional) country name.
$weather = (new API('<API-key here>'))
    ->getCurrentWeather()
    ->byCityName('Dusseldorf,Germany');

// Get weather data by a "city ID".
$weather = (new API('<API-key here>'))
    ->getCurrentWeather()
    ->byCityId(524901);
```

### Default options

Most endpoints can define a **language** to get API responses in your language. For more details scroll down :)

By default you will receive an array with the data you like. Some endpoints can be used with different **modes** like "XML"
and "HTML".

Also it is possible to use different **units** like "metric" and "imperial".

## API endpoints for data collection

The goal is to implement PHP classes for every [data collection API endpoint](https://openweathermap.org/api). The main
`API` class has accessor methods for each available endpoint.

- `$api->getClimateForecast()` returns an instance of `ClimateForecastEndpoint`.
- `$api->getCurrentWeather()` returns an instance of `CurrentWeatherEndpoint`.
- `$api->getHourlyForecast()` returns an instance of `HourlyForecastEndpoint`.
- `$api->getDailyForecast()` returns an instance of `DailyForecastEndpoint`.
- `$api->getOneCall()` returns an instance of `OneCallEndpoint`.

**Sadly some endpoints require a paid subscription which I don't have. If anyone likes to contribute or test the
affected endpoints please let me know!**

## More convenience

The API client provides convenience methods and classes to set different **modes** (`xml`, `json` or `html`),
**units** (`metric` or `imperial`) or **languages** (49 languages available).

Use the constants located in `Mode`, `Unit` and `Language` to get the correct values and autocompletion in your IDE.

```php
// Get weather data by a city and (optional) country name.
use lfischer\openWeatherMap\API;
use lfischer\openWeatherMap\Parameter\Language;
use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\Unit;

$weather = (new API('<API-key here>'))
    ->getCurrentWeather()
    ->setMode(Mode::XML)
    ->setUnit(Unit::METRIC)
    ->setLanguage(Language::ENGLISH)
    ->byCityName('Dusseldorf,Germany');
```

## Different Request options

The API client can use three different request adapters, according to your environment and possible other libraries.

### cURL

In case you can not use `file_get_contents`, you can use the 'Curl' request adapter. For this your environment needs
to provide the `curl` PHP extension.

### Dump

The `Dump` request adapter can be used to return the prepared URL in case you have your own request library to work
with. This is also used for testing.

### Guzzle

If you are a fan of the great [Guzzle](https://packagist.org/packages/guzzlehttp/guzzle) library, you can use this
adapter and make use of all its great features :)

### Simple

The 'Simple' request adapter makes use of `file_get_contents` (just as the previous versions). For this adapter you will
need to activate the [fopen wrappers](https://www.php.net/manual/de/filesystem.configuration.php#ini.allow-url-fopen).

## Response types

According to the `mode` option the response will be returned in a different `Response` class. Every response type has a
`getResponse` method that returns the specific set of data.

- `HtmlResponse->getResponse()` returns a `string`
- `JsonResponse->getResponse()` returns a `array`
- `XmlResponse->getResponse()` returns a `SimpleXMLElement`

Each type also contains a `getRawResponse` method which will return the raw `string` response from the API, in case
you'd like to process the response on your own.

# Contribution

As mentioned before I do not have a paid subscription in order to develop and test every data collection. For this I
need **YOUR** help ;)

If anyone likes to contribute or test the affected endpoints please let me know!
