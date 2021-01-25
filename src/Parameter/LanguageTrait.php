<?php

namespace lfischer\openWeatherMap\Parameter;

use InvalidArgumentException;

/**
 * Trait LanguageTrait
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Parameter
 */
trait LanguageTrait
{
    /**
     * @var string|null
     */
    private $language = null;

    /**
     * Method to set the language.
     *
     * @param string|null $language
     * @return $this
     */
    public function setLanguage(?string $language): self
    {
        if ($language === null) {
            $this->language = $language;

            return $this;
        }

        $available = Language::getAll();

        if (!in_array($language, $available, true)) {
            throw new InvalidArgumentException(sprintf('The provided language "%s" is not available, choose on of %s.', $language, implode(', ', $available)));
        }

        $this->language = $language;

        return $this;
    }

    /**
     * Method to get the language parameter.
     *
     * @return array
     */
    protected function getLanguageParameter(): array
    {
        return ['lang' => $this->language];
    }
}
