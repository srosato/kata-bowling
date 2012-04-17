<?php

namespace Srosato\BowlingBundle\Model;

class Gutter implements Roll
{
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
        return 0;
    }
}
