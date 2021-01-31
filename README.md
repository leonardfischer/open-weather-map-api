# Open Weather Map API Client

This library will help you integrate the Open Weather Map API to your webservice.
It is lightweight and provides all necessary code including some convenience methods.

## Code Example

Using the API is very easy - you'll only need to provide a API key (Get one [here](https://openweathermap.org/appid)) in order to use it.
There are functions for retrieving different weather data by predefined conditions, like "by country and city", "by latitude and longitude", "by airport code" or even "by IP address".

```php
use lfischer\openWeatherMap\API;

// Get weather data by a city and (optional) country name.
$weather = (new API('<API-key here>'))
    ->getCurrentWeatherClient()
    ->byCityName('Dusseldorf,Germany');

// Get weather data by a "city ID".
$weather = (new API('<API-key here>'))
    ->getCurrentWeatherClient()
    ->byCityId(524901);
```

## API Classes for data collection

The goal is to implement classes for every [data collection API endpoint](https://openweathermap.org/api). The main
`API` class has accessor methods for each available endpoint.

- `$api->getClimateForecastClient()` returns an instance of `ClimateForecastClient`.
- `$api->getCurrentWeatherClient()` returns an instance of `CurrentWeatherClient`.
- `$api->getHourlyForecastClient()` returns an instance of `HourlyForecastClient`.
- `$api->getDailyForecastClient()` returns an instance of `DailyForecastClient`.

## More convenience

The API client provides some convenience methods and classes to set different modes (`xml`, `json` or `html`),
units (`metric` or `imperial`) or languages (49 languages available).

```php
// Get weather data by a city and (optional) country name.
use lfischer\openWeatherMap\API;
use lfischer\openWeatherMap\Parameter\Language;
use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Parameter\Unit;

$weather = (new API('<API-key here>'))
    ->getCurrentWeatherClient()
    ->setLanguage(Language::ENGLISH)
    ->setMode(Mode::XML)
    ->setUnit(Unit::METRIC)
    ->byCityName('Dusseldorf,Germany');
```

## Different Request options

The client can use three different request adapters, according to your environment and possible other libraries.

### cURL

In case you can not use `file_get_contents`, you can use the 'Curl' request adapter. For this your environment needs
to provide the `curl` PHP extension.

### Dump

The `Dump` request adapter can be used to return the prepared URL in case you have your own request library to work with.

### Guzzle

If you (like me) are a fan of the great [Guzzle](https://packagist.org/packages/guzzlehttp/guzzle) library,
you can use this adapter and make use of all its features :)

### Simple

The 'Simple' request adapter makes use of `file_get_contents` (just as the previous versions). For this adapter you will
need to activate the [fopen wrappers](https://www.php.net/manual/de/filesystem.configuration.php#ini.allow-url-fopen).

## Response types

According to the `mode` option the response will differ. Every response type has a `getResponse` method that returns a
specific set of data

- `HtmlResponse->getResponse()` returns a `string`
- `JsonResponse->getResponse()` returns a `array`
- `XmlResponse->getResponse()` returns a `SimpleXMLElement`

Each type also contains a `getRawResponse` method which will return the raw `string` response from the API.
