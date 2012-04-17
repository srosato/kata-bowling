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
     * {@inheritdoc}
     */
    public function getScore()
    {
        return $this->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->pinsCount;
    }
}
