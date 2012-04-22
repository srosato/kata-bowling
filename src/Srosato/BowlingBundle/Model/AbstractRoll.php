<?php

namespace Srosato\BowlingBundle\Model;

abstract class AbstractRoll implements Roll
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
    public function setFrame(Frame $frame)
    {
        $this->frame = $frame;
    }
}
