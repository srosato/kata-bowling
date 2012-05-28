<?php

namespace Srosato\BowlingBundle\Model;

class StandardRoll implements Roll
{
    private $pinsCount;

    /**
     * @param $numberOfPins
     */
    public function __construct($numberOfPins)
    {
        $this->pinsCount = $numberOfPins;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->pinsCount;
    }
}
