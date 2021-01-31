<?php

namespace lfischer\openWeatherMap\Response;

/**
 * Class AbstractResponse.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Response
 */
abstract class AbstractResponse
{
    /**
     * @var string
     */
    protected $response;

    /**
     * AbstractResponse constructor.
     *
     * @param string $response
     */
    public function __construct(string $response)
    {
        $this->response = $response;
    }

    /**
     * Method to return the raw unprocessed response.
     *
     * @return string
     */
    public function getRawResponse(): string
    {
        return $this->response;
    }

    /**
     * This method will return response specific data.
     *
     * @return mixed
     */
    abstract public function getResponse();
}
