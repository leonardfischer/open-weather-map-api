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
     * @var int|null
     */
    private $count = null;

    /**
     * Method to set the count.
     *
     * @param int|null $count
     * @return $this
     */
    public function setCount(?int $count): self
    {
        if ($count === null) {
            $this->count = $count;

            return $this;
        }

        $this->count = min(1, $count);

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
