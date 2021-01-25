<?php

namespace lfischer\openWeatherMap\Parameter;

use InvalidArgumentException;

/**
 * Trait ModeTrait
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Parameter
 */
trait ModeTrait
{
    /**
     * @var string|null
     */
    private $mode = null;

    /**
     * Method to set the mode.
     *
     * @param string|null $mode
     * @return $this
     */
    public function setMode(?string $mode): self
    {
        if ($mode === null) {
            $this->mode = null;

            return $this;
        }

        $available = Mode::getAll();

        if (!in_array($mode, $available, true)) {
            throw new InvalidArgumentException(sprintf('The provided mode "%s" is not available, choose on of %s. Or none (=null) for JSON.', $mode, implode(', ', $available)));
        }

        $this->mode = $mode;

        return $this;
    }

    /**
     * Method to get the mode parameter.
     *
     * @return array
     */
    protected function getModeParameter(): array
    {
        return ['mode' => $this->mode];
    }
}
