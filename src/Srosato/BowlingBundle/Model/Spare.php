<?php

namespace Srosato\BowlingBundle\Model;

class Spare extends AbstractRoll
{
    /**
     * @var StandardRoll
     */
    private $lastRoll;

    /**
     * @var bool
     */
    protected $bonusApplicable = true;

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
