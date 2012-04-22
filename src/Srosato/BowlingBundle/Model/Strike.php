<?php

namespace Srosato\BowlingBundle\Model;

use Srosato\BowlingBundle\Model\Frame;

class Strike extends AbstractRoll
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 10;
    }

    /**
     * @return int
     */
    public function getBonusRollCount()
    {
        return 2;
    }
}
