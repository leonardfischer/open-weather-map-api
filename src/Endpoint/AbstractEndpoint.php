<?php declare(strict_types=1);

namespace lfischer\openWeatherMap\Endpoint;

use lfischer\openWeatherMap\API;
use lfischer\openWeatherMap\Parameter\Mode;
use lfischer\openWeatherMap\Response\AbstractResponse;
use lfischer\openWeatherMap\Response\HtmlResponse;
use lfischer\openWeatherMap\Response\JsonResponse;
use lfischer\openWeatherMap\Response\XmlResponse;

/**
 * Class AbstractEndpoint
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Endpoint
 */
abstract class AbstractEndpoint
{
    /**
     * @var API
     */
    protected $api;

    /**
     * AbstractEndpoint constructor.
     *
     * @param API $api
     */
    public function __construct(API $api)
    {
        $this->api = $api;
    }

    /**
     * @param string $endpoint
     * @param array  $parameters
     * @return AbstractResponse
     */
    protected function doRequest(string $endpoint, array $parameters = []): AbstractResponse
    {
        $response = $this->api->fetch($endpoint, $parameters);

        if (isset($parameters['mode']) && $parameters['mode'] === Mode::XML)
        {
            return new XmlResponse($response);
        }

        if (isset($parameters['mode']) && $parameters['mode'] === Mode::HTML)
        {
            return new HtmlResponse($response);
        }

        return new JsonResponse($response);
    }
}
