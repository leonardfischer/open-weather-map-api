<?php

namespace lfischer\openWeatherMap\Response;

/**
 * Class HtmlResponse.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Response
 */
class HtmlResponse extends AbstractResponse
{
    /**
     * This method will return HTML in a string.
     *
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }
}
