<?php

namespace Srosato\BowlingBundle\Model;

/**
 * Represents a roll that can have a bonus, such as strikes or spares, but sometimes the bonus
 * can't apply even on this roll, which happens on the last frame.
 */
abstract class AbstractRollWithBonus implements Roll
{
    /**
     * @var bool
     */
    protected $bonusApplicable = true;

    /**
     * @param bool $flag
     */
    public function setIsBonusApplicable($flag)
    {
        $this->bonusApplicable = (bool)$flag;
    }

    /**
     * @return bool
     */
    public function isBonusApplicable()
    {
        return $this->bonusApplicable;
    }

    /**
     * @abstract
     * @return int
     */
    abstract public function getBonusRollCount();
}
