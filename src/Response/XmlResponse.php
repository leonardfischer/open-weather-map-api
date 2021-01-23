<?php

namespace lfischer\openWeatherMap\Response;

use lfischer\openWeatherMap\Exception\XmlLoadException;
use SimpleXMLElement;

/**
 * Class XmlResponse.
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Response
 */
class XmlResponse extends AbstractResponse
{
    /**
     * This method will an array of the decoded JSON.
     *
     * @return SimpleXMLElement
     * @throws XmlLoadException
     */
    public function getResponse(): SimpleXMLElement
    {
        libxml_use_internal_errors(true);
        $response = simplexml_load_string($this->response);

        if ($response === false)
        {
            $errorCollection = [];
            $errors = libxml_get_errors();

            foreach ($errors as $error)
            {
                $errorCollection[] = "{$error->message} (on line {$error->line}, column {$error->column})";
            }

            throw new XmlLoadException(implode(', ', $errorCollection));
        }

        return $response;
    }
}
