<?php

namespace Srosato\BowlingBundle\Model;

interface Roll
{
    /**
     * @abstract
     *
     * @return int
     */
    public function getValue();

    /**
     * @abstract
     *
     * @return int
     */
    public function getBonusRollCount();

    /**
     * @abstract
     *
     * @param boolean $bonusApplicable
     */
    public function setIsBonusApplicable($bonusApplicable);

    /**
     * @abstract
     *
     * @return boolean
     */
    public function isBonusApplicable();
}
