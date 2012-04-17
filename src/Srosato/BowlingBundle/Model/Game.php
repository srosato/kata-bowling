<?php

namespace Srosato\BowlingBundle\Model;

use Srosato\BowlingBundle\Model\Frame;
use Srosato\BowlingBundle\Model\Strike;
use Srosato\BowlingBundle\Model\Gutter;

use Doctrine\Common\Collections\ArrayCollection;

class Game
{
    /**
     * @var ArrayCollection
     */
    private $frames;

    private function nextFrame()
    {
        $newFrame = new Frame();
        $this->getCurrentFrame()->setNextFrame($newFrame);

        $this->getFrames()->add($newFrame);
    }

    public function strike()
    {
        $this->roll(new Strike());
    }

    public function gutter()
    {
        $this->roll(new Gutter());
    }

    /**
     * @param int $numberOfPins
     */
    public function pinsDown($numberOfPins)
    {
        $this->roll(new StandardRoll($numberOfPins));
    }

    /**
     * @param Roll $roll
     */
    private function roll(Roll $roll)
    {
        $currentFrame = $this->getCurrentFrame();
        $currentFrame->addRoll($roll);

        if( $currentFrame->isCompleted() ) {
            $this->nextFrame();
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getFrames()
    {
        if( null === $this->frames ) {
            $this->frames = new ArrayCollection();
        }

        return $this->frames;
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
            $frames->add(new Frame());
        }

        return $frames->last();
    }
}