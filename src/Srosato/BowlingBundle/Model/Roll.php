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
}
