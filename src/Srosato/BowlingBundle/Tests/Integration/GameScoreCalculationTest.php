<?php

namespace Srosato\BowlingBundle\Tests\Integration;

use Srosato\BowlingBundle\Model\Game;
use Srosato\BowlingBundle\Model\GameFactory;

class GameScoreCalculationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GameFactory
     */
    private $gameFactory;

    public function setUp()
    {
        $this->gameFactory = new GameFactory();
    }

    /**
     * @test
     */
    public function getScoreBeforeStartingGameWillCalculateAScoreOfZero()
    {
        $game = new Game();

        $this->assertNotNull($game->getScore());
        $this->assertEquals(0, $game->getScore());
    }

    /**
     * @test
     */
    public function pinsDownOnFirstRollShouldCorrectlyCalculateScore()
    {
        $game = new Game();

        $game->pinsDown(5);

        $this->assertEquals(5, $game->getScore());
    }

    /**
     * @test
     */
    public function pinsDownOnSecondRollShouldAlsoCorrectlyCalculateScore()
    {
        $game = new Game();

        $game->pinsDown(5);
        $game->pinsDown(3);

        $this->assertEquals(8, $game->getScore());
    }

    /**
     * @test
     */
    public function rollingAStrikeShouldCalculateBonusOnNextTwoRolls()
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

    /**
     * @test
     */
    public function rollingTwoConsecutiveStrikesShouldAlsoCorrectlyCalculateBonuses()
    {
        $game = new Game();

        $game->strike();
        $game->strike();

        $game->pinsDown(5);
        $game->pinsDown(2);

        $game->pinsDown(5);
        $game->pinsDown(2);

        $this->assertEquals( (10 + 10 + 5) + (10 + 5 + 2) + 2 * (5 + 2), $game->getScore());
    }

    /**
     * @test
     */
    public function spareAfterARollShouldGiveAScoreOfTen()
    {
        $game = new Game();

        $game->pinsDown(5);
        $game->spare();

        $this->assertEquals(10, $game->getScore());
    }

    /**
     * @test
     */
    public function spareShouldCalculateBonusOnNextRoll()
    {
        $game = new Game();

        $game->pinsDown(4);
        $game->spare();
        $game->pinsDown(3);

        $this->assertEquals( (10 + 3) + 3, $game->getScore());
    }

    /**
     * @test
     */
    public function strikeAndSpareShouldCorrectlyCalculateBonuses()
    {
        $game = new Game();

        $game->strike();

        $game->pinsDown(4);
        $game->spare();

        $game->pinsDown(8);

        $this->assertEquals( (10 + 4 + 6) + (4 + 6 + 8) + 8, $game->getScore());
    }

    /**
     * @test
     */
    public function gutterGameShouldCalculateAScoreOfZero()
    {
        $game = $this->gameFactory->createGutterGame();
        $this->assertEquals(0, $game->getScore());
    }

    /**
     * @test
     */
    public function perfectGameShouldCalculateAScoreOfThreeHundred()
    {
        $game = $this->gameFactory->createPerfectGame();
        $this->assertEquals(300, $game->getScore());
    }

    /**
     * @test
     */
    public function rollingASpareOnLastFrameShouldGiveOneMoreRollForThatSameFrameAndNotCountBonus()
    {
        $game = $this->gameFactory->createGutterGameUpToLastFrame();

        $game->pinsDown(3);
        $game->spare();
        $game->strike();

        $this->assertEquals(3 + 7 + 10, $game->getScore());
    }

    /**
     * @test
     */
    public function rollingAStrikeOnLastFrameShouldGiveTwoMoreRollsForThatSameFrameAndNotCountAsBonuses()
    {
        $game = $this->gameFactory->createGutterGameUpToLastFrame();

        $game->strike();
        $game->pinsDown(3);
        $game->spare();

        $this->assertEquals(10 + 3 + 7, $game->getScore());
    }

    /**
     * @test
     */
    public function rollingAStrikeOnBeforeLastFrameShouldAlsoReceiveBonusOnNextTwoRolls()
    {
        $game = new Game();

        for( $i = 0; $i < 16; $i++ ) {
            $game->gutter();
        }

        $game->strike();
        $game->pinsDown(3);
        $game->spare();
        $game->strike();

        $this->assertEquals( (10 + 3 + 7) + (3 + 7 + 10), $game->getScore());
    }

}
