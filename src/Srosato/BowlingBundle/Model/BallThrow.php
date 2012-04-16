<?php

namespace Srosato\BowlingBundle\Model;

interface BallThrow
{
    /**
     * @abstract
     *
     * @return int
     */
    public function getScore();
}
