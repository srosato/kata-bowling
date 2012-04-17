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
        if( $roll instanceof Strike ) {
            $roll->setFrame($this);
        }

        $this->getRolls()->add($roll);
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        $rolls = $this->getRolls();

        if( !$rolls->isEmpty() ) {
            return 2 === $rolls->count() || $rolls->get(0) instanceof Strike;
        }

        return false;
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
     * @return int
     */
    public function getScore()
    {
        $score = 0;

        /* @var $roll Roll */
        foreach( $this->getRolls() as $roll ) {
            $score += $roll->getScore();
        }

        return $score;
    }
}