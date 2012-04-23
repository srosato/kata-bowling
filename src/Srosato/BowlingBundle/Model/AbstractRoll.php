<?php

namespace Srosato\BowlingBundle\Model;

abstract class AbstractRoll implements Roll
{
    /**
     * @var boolean
     */
    private $bonusApplicable = true;

    /**
     * @param boolean $bonusApplicable
     */
    public function setIsBonusApplicable($bonusApplicable)
    {
        $this->bonusApplicable = (boolean)$bonusApplicable;
    }

    /**
     * @return boolean
     */
    public function isBonusApplicable()
    {
        return $this->bonusApplicable;
    }
}
