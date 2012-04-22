<?php

namespace Srosato\BowlingBundle\Model;

use Srosato\BowlingBundle\Model\Frame;
use Srosato\BowlingBundle\Model\Strike;
use Srosato\BowlingBundle\Model\Spare;
use Srosato\BowlingBundle\Model\Gutter;

use Doctrine\Common\Collections\ArrayCollection;

class Game
{
    /**
     * @var ArrayCollection
     */
    private $frames;

    /**
     * @var ArrayCollection
     */
    private $rolls;

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

    public function spare()
    {
        $this->roll(new Spare($this->getRolls()->last()));
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

        $this->getRolls()->add($roll);

        if( !$this->isCompleted() && $currentFrame->isCompleted() ) {
            $this->nextFrame();
        }
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return 10 === $this->getFrames()->count();
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
        $score = new Score();
        return $score->calculate($this);
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