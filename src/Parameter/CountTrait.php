<?php

namespace lfischer\openWeatherMap\Parameter;

use InvalidArgumentException;

/**
 * Trait CountTrait
 *
 * @author  Leonard Fischer <post@leonard.fischer.de>
 * @package lfischer\openWeatherMap\Parameter
 */
trait CountTrait
{
    /**
     * @var string|null
     */
    private $count = null;

    /**
     * Method to set the count.
     *
     * @param string|null $count
     * @return $this
     */
    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Method to get the count parameter.
     *
     * @return array
     */
    protected function getCountParameter(): array
    {
        return ['cnt' => $this->count];
    }
}
