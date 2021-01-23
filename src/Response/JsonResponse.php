<?php

namespace lfischer\openWeatherMap\Response;

use lfischer\openWeatherMap\Exception\JsonDecodeException;

/**
 * Class JsonResponse.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Response
 */
class JsonResponse extends AbstractResponse
{
    /**
     * This method will an array of the decoded JSON.
     *
     * @return array
     * @throws JsonDecodeException
     */
    public function getResponse(): array
    {
        $response = json_decode($this->response, true);

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new JsonDecodeException(json_last_error_msg());
        }

        return $response;
    }
}
