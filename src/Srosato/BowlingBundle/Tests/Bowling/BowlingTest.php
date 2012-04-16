<?php

namespace Srosato\BowlingBundle\Tests;

use Srosato\BowlingBundle\Model\Bowling;

class BowlingTest extends \PHPUnit_Framework_TestCase
{
    public function testGetScoreBeforeStartingGameCalculateAScoreOfZero()
    {
        $bowling = new Bowling();

        $this->assertNotNull($bowling->getScore());
        $this->assertEquals(0, $bowling->getScore());
    }

    public function testPinsDownOnFirstThrowWillCorrectlyCalculateScore()
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

    public function testStrikeWillCorrectlyCalculateScore()
    {
        $bowling = new Bowling();

        $bowling->strike();

        $bowling->pinsDown(5);
        $bowling->pinsDown(2);

        $bowling->pinsDown(5);
        $bowling->pinsDown(2);

        $bowling->pinsDown(4);

        $this->assertEquals(10 + 2 * (5 + 2) + 2 * (5 + 2) + 4, $bowling->getScore());
    }

    public function testTwoConsecutiveStrikesWillCorrectlyCalculateScore()
    {
        $bowling = new Bowling();

        $bowling->strike();
        $bowling->strike();

        $bowling->pinsDown(5);
        $bowling->pinsDown(2);

        $bowling->pinsDown(5);
        $bowling->pinsDown(2);

        $this->assertEquals( (10 + 10 + 5 + 2) + (10 + 5 + 2 + 5 + 2) + (5 + 2) + (5 + 2), $bowling->getScore());
    }
}
