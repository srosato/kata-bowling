<?php

namespace Srosato\BowlingBundle\Model;

interface Roll
{
    /**
     * @abstract
     *
     * @return int
     */
    public function getValue();

    /**
     * @abstract
     *
     * @return int
     */
    public function getBonusRollCount();

    /**
     * @abstract
     *
     * @return Frame
     */
    public function getFrame();

    /**
     * @abstract
     *
     * @param Frame $frame
     *
     * @return mixed
     */
    public function setFrame(Frame $frame);
}
