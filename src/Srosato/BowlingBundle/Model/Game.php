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

    private function addNextFrame()
    {
        $this->getFrames()->add(new Frame());
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

        if( $this->isCurrentFrameLastFrame() && $roll instanceof AbstractRollWithBonus ) {
            $roll->setIsBonusApplicable(false);
        }

        $currentFrame->addRoll($roll);

        if( !$this->isCurrentFrameLastFrame() && $currentFrame->isCompleted() ) {
            $this->addNextFrame();
        }
    }

    /**
     * @return boolean
     */
    public function isCurrentFrameLastFrame()
    {
        return 10 === $this->getFrames()->count();
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->isCurrentFrameLastFrame() && $this->getCurrentFrame()->isCompleted();
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
        $rolls = new ArrayCollection();

        /* @var $frame Frame */
        foreach( $this->getFrames() as $frame ) {
            foreach( $frame->getRolls() as $roll ) {
                $rolls->add($roll);
            }
        }

        return $rolls;
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