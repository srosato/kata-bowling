<?php

namespace Srosato\BowlingBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Srosato\BowlingBundle\Model\Roll;
use Srosato\BowlingBundle\Model\Strike;

class Frame
{
    /**
     * @var ArrayCollection
     */
    protected $rolls;

    /**
     * @param Roll $roll
     */
    public function addRoll(Roll $roll)
    {
        $this->getRolls()->add($roll);
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        $rolls = $this->getRolls();

        //TODO: refactor this mess
        if( !$rolls->isEmpty() ) {
            if( 2 === $rolls->count() && $rolls->get(1) instanceof Strike ) {
                return false;
            } else if( 2 === $rolls->count() && $rolls->get(1) instanceof Spare ) {
                return false;
            } else if( 1 === $rolls->count() && $rolls->get(0) instanceof Strike && $rolls->get(0)->isBonusApplicable() ) {
                return true;
            } else if( 2 <= $rolls->count() ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ArrayCollection
     */
    public function getRolls()
    {
        if( null === $this->rolls ) {
            $this->rolls = new ArrayCollection();
        }

        return $this->rolls;
    }
}