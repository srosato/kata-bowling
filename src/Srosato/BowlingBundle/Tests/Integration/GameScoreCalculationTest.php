<?php

namespace Srosato\BowlingBundle\Tests\Integration;

use Srosato\BowlingBundle\Model\Game;

class GameScoreCalculationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetScoreBeforeStartingGameCalculateAScoreOfZero()
    {
        $game = new Game();

        $this->assertNotNull($game->getScore());
        $this->assertEquals(0, $game->getScore());
        $this->assertFalse($game->getCurrentFrame()->isCompleted()); //FIXME: law of demeter
    }

    public function testPinsDownOnFirstRollWillCorrectlyCalculateScore()
    {
        $game = new Game();

        $game->pinsDown(5);

        $this->assertEquals(5, $game->getScore());
    }

    public function testPinsDownOnSecondRollWillCorrectlyCalculateScore()
    {
        $game = new Game();

        $game->pinsDown(5);
        $game->pinsDown(3);

        $this->assertEquals(8, $game->getScore());
    }

    public function testStrikeWillCorrectlyCalculateScore()
    {
        $game = new Game();

        $game->strike();

        $game->pinsDown(5);
        $game->pinsDown(2);

        $game->pinsDown(5);
        $game->pinsDown(2);

        $game->gutter();
        $game->pinsDown(4);

        $this->assertEquals(10 + (5 + 2) + 2 * (5 + 2) + 4, $game->getScore());
    }

    public function testTwoConsecutiveStrikesWillCorrectlyCalculateScore()
    {
        $game = new Game();

        $game->strike();
        $game->strike();

        $game->pinsDown(5);
        $game->pinsDown(2);

        $game->pinsDown(5);
        $game->pinsDown(2);

        $this->assertEquals( (10 + 10) + (10 + 5 + 2) + 2 * (5 + 2), $game->getScore());
    }
}
