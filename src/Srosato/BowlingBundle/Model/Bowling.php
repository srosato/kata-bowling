<?php

namespace Srosato\BowlingBundle\Model;

use Srosato\BowlingBundle\Model\Frame;
use Srosato\BowlingBundle\Model\Strike;

use Majisti\UtilsBundle\Collections\Stack;

class Bowling
{
    /**
     * @var Stack
     */
    private $frames;

    public function strike()
    {
        $currentFrame = $this->getCurrentFrame();
        $currentFrame->addStrike(new Strike());

        $newFrame = new Frame();
        $currentFrame->setNextFrame($newFrame);

        $this->getFrames()->push($newFrame);
    }

    /**
     * @return Stack
     */
    private function getFrames()
    {
        if( null === $this->frames ) {
            $this->frames = new Stack();
        }

        return $this->frames;
    }

    /**
     * @param int $numberOfPins
     */
    public function pinsDown($numberOfPins)
    {
        $this->getCurrentFrame()->addThrow(new StandardThrow($numberOfPins));
    }

    public function getScore()
    {
        $score = 0;

        /* @var $frame Frame */
        foreach( $this->getFrames() as $frame ) {
            $score += $frame->getScore();
        }

        return $score;
    }

    /**
     * @return Frame
     */
    public function getCurrentFrame()
    {
        $frames = $this->getFrames();

        if( $frames->isEmpty() ) {
            $frames->push(new Frame());
        }

        return $frames->peek();
    }
}