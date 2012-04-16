<?php

namespace Srosato\BowlingBundle\Model;

use Majisti\UtilsBundle\Collections\Stack;
use Srosato\BowlingBundle\Model\BallThrow;
use Srosato\BowlingBundle\Model\Strike;

class Frame
{
    /**
     * @var Frame
     */
    private $nextFrame;

    /**
     * @var Stack
     */
    protected $stack;

    public function addStrike(Strike $strike)
    {
        $strike->setFrame($this);
        $this->addThrow($strike);
    }

    public function addThrow(BallThrow $throw)
    {
        $this->getStack()->push($throw);
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
     * @return Stack
     */
    public function getStack()
    {
        if( null === $this->stack ) {
            $this->stack = new Stack();
        }

        return $this->stack;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        $score = 0;

        /* @var $throw BallThrow */
        foreach( $this->getStack() as $throw ) {
            $score += $throw->getPinsCount();
        }

        return $score;
    }
}