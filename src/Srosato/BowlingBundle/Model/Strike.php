<?php

namespace Srosato\BowlingBundle\Model;

use Srosato\BowlingBundle\Model\Frame;

class Strike implements BallThrow
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
     * @return int
     */
    public function getPinsCount()
    {
        $score = 10;
        $frame = $this->getFrame();

        if( $frame->hasNextFrame() ) {
            $nextFrame = $frame->getNextFrame();

            $score += $nextFrame->getScore();

            if( $nextFrame->hasNextFrame() ) {
                $score += $nextFrame->getScore();
            }
        }

        return $score;
    }
}
