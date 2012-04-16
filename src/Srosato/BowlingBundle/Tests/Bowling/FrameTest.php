<?php

namespace Srosato\BowlingBundle\Tests;

use Srosato\BowlingBundle\Model\Frame;
use Srosato\BowlingBundle\Model\StandardThrow;
use Srosato\BowlingBundle\Model\Strike;

use Srosato\BowlingBundle\Model\Bowling;

class FrameTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingThrowsToTheFrameWillCalculateScoreCorrectly()
    {
        $frame = new Frame();
        $frame->addThrow(new StandardThrow(6));
        $frame->addThrow(new StandardThrow(3));

        $this->assertEquals(9, $frame->getScore());
    }

    public function testAddingStrikeWillCorrectlyAddBonusFromTheNextTwoFrames()
    {
        $frame = new Frame();
        $frame->addStrike(new Strike());

        $frame2 = new Frame();
        $frame2->addThrow(new StandardThrow(5));
        $frame2->addThrow(new StandardThrow(2));

        $frame3 = new Frame();
        $frame3->addThrow(new StandardThrow(5));
        $frame3->addThrow(new StandardThrow(2));

        $frame->setNextFrame($frame2);
        $frame2->setNextFrame($frame3);

        $this->assertEquals(10 + 2 * (5 + 2), $frame->getScore());
    }
}
