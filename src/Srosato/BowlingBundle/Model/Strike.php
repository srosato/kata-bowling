<?php

namespace Srosato\BowlingBundle\Model;

use Srosato\BowlingBundle\Model\Frame;

class Strike implements Roll
{
    /**
     * @var Frame
     */
    private $frame;

    /**
     * @return Frame
     */
    public function getFrame()
    {
        return $this->frame;
    }

    /**
     * @param Frame $frame
     */
    public function setFrame($frame)
    {
        $this->frame = $frame;
    }

    /**
     * {@inheritdoc}
     */
    public function getScore()
    {
        $score = $this->getValue();

        $frame = $this->getFrame();

        if( $frame->hasNextFrame() ) {
            $nextFrame = $frame->getNextFrame();

            $rolls = $nextFrame->getRolls();

            if( $rolls->offsetExists(0) ) {
                $score += $rolls->get(0)->getValue();
            }

            if( $rolls->offsetExists(1) ) {
                $score += $rolls->get(1)->getValue();
            }
        }

        return $score;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return 10;
    }
}
