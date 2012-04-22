<?php

namespace Srosato\BowlingBundle\Model;

class StandardRoll extends AbstractRoll
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

    /**
     * @return int
     */
    public function getBonusRollCount()
    {
        return 0;
    }
}
