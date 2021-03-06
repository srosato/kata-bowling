<?php

namespace Srosato\BowlingBundle\Model;

class Spare extends AbstractRollWithBonus
{
    /**
     * @var StandardRoll
     */
    private $lastRoll;

    /**
     * @param StandardRoll $lastRoll
     */
    public function __construct(StandardRoll $lastRoll)
    {
        $this->lastRoll = $lastRoll;
    }

    /**
     * @return StandardRoll
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 10 - $this->getLastRoll()->getValue();
    }

    /**
     * @return int
     */
    public function getBonusRollCount()
    {
        return 1;
    }
}
