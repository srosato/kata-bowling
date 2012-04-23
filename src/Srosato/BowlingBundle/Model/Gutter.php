<?php

namespace Srosato\BowlingBundle\Model;

class Gutter extends AbstractRoll
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getBonusRollCount()
    {
        return 0;
    }
}
