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
        $roll->setFrame($this);
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        $rolls = $this->getRolls();

//        if( !$rolls->isEmpty() ) {
            return 2 === $rolls->count() || $rolls->get(0) instanceof Strike;
//        }

//        return false;
    }

    /**
     * @return bool
     */
    public function hasNextFrame()
    {
        return null !== $this->getNextFrame();
    }

    /**
     * @return Frame
     */
    public function getNextFrame()
    {
        return $this->nextFrame;
    }

    /**
     * @param Frame $frame
     */
    public function setNextFrame(Frame $frame)
    {
        $this->nextFrame = $frame;
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

    /**
     * @return Roll
     */
    public function getLastRoll()
    {
        return $this->getRolls()->current();
    }

    /**
     * @return int
     */
    public function getValue()
    {
        $value = 0;

        /* @var $roll Roll */
        foreach( $this->getRolls() as $roll ) {
            $value += $roll->getValue();
        }

        return $value > 10
            ? 10
            : $value;
    }
}