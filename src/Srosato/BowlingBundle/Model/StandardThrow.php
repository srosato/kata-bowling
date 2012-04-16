<?php

namespace Srosato\BowlingBundle\Model;

class StandardThrow implements BallThrow
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
    public function getScore()
    {
        return $this->pinsCount;
    }
}
