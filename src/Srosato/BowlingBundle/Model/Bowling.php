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

    private function nextFrame()
    {
        $newFrame = new Frame();
        $this->getCurrentFrame()->setNextFrame($newFrame);

        $this->getFrames()->push($newFrame);
    }

    public function strike()
    {
        $currentFrame = $this->getCurrentFrame();
        $currentFrame->addStrike(new Strike());

        $this->nextFrame();
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
        $currentFrame = $this->getCurrentFrame();
        $currentFrame->addThrow(new StandardThrow($numberOfPins));

        if( $currentFrame->isCompleted() ) {
            $this->nextFrame();
        }
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