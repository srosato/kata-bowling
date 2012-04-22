<?php

namespace Srosato\BowlingBundle\Model;

class Spare extends AbstractRoll
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 10 - $this->getFrame()->getLastRoll()->getValue();
    }

    /**
     * @return int
     */
    public function getBonusRollCount()
    {
        return 1;
    }
}
