<?php

namespace lfischer\openWeatherMap\Parameter;

use InvalidArgumentException;

/**
 * Trait UnitTrait
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Parameter
 */
trait UnitTrait
{
    /**
     * @var string|null
     */
    private $unit = null;

    /**
     * Method to set the unit.
     *
     * @param string|null $unit
     * @return $this
     */
    public function setUnit(?string $unit): self
    {
        if ($unit === null) {
            $this->unit = $unit;

            return $this;
        }

        $available = Unit::getAll();

        if (!in_array($unit, $available, true)) {
            throw new InvalidArgumentException(sprintf('The provided unit "%s" is not available, choose on of %s.', $unit, implode(', ', $available)));
        }

        $this->unit = $unit;

        return $this;
    }

    /**
     * Method to get the unit parameter.
     *
     * @return array
     */
    protected function getUnitParameter(): array
    {
        return ['units' => $this->unit];
    }
}
