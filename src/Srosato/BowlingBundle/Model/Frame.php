<?php

namespace Srosato\BowlingBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Srosato\BowlingBundle\Model\Roll;
use Srosato\BowlingBundle\Model\Strike;

class Frame
{
    /**
     * @var Frame
     */
    private $nextFrame;

    /**
     * @var ArrayCollection
     */
    protected $rolls;

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

        if( !$rolls->isEmpty() ) {
            if( $rolls->count() > 2 ) {
                return true;
            } else if( $rolls->count() === 1 && $rolls->get(0) instanceof Strike ) {
                return true;
            } else if( $rolls->count() === 2 && $rolls->get(1) instanceof Spare ) {

            }
            return 2 <= $rolls->count() || $rolls->get(0) instanceof Strike;
        }

//        return false;
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