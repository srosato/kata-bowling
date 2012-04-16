<?php

namespace Srosato\BowlingBundle\Tests;

use Srosato\BowlingBundle\Model\Bowling;

class BowlingTest extends \PHPUnit_Framework_TestCase
{
    public function testGetScoreBeforeStartingGameWillReturnZero()
    {
        $bowling = new Bowling();

        $this->assertNotNull($bowling->getScore());
        $this->assertEquals(0, $bowling->getScore());
    }

    public function testPinsDownOnFirstThrowWillReturnCorrectScore()
    {
        $bowling = new Bowling();

        $bowling->pinsDown(5);

        $this->assertEquals(5, $bowling->getScore());
    }

    public function testPinsDownOnSecondThrowWillCorrectlyReturnScore()
    {
        $bowling = new Bowling();

        $bowling->pinsDown(5);
        $bowling->pinsDown(3);

        $this->assertEquals(8, $bowling->getScore());
    }

    public function testStrikeWillCorrectlyApplyBonusFromTheNextTwoFrames()
    {
        $bowling = new Bowling();

        $bowling->strike();
        $bowling->pinsDown(5);
        $bowling->pinsDown(2);
        $bowling->pinsDown(5);
        $bowling->pinsDown(2);

        $this->assertEquals(10 + 2 * (5 + 2) + 2 * (5 + 2), $bowling->getScore());
    }
}
