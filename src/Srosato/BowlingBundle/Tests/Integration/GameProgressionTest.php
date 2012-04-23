<?php

namespace Srosato\BowlingBundle\Tests\Integration;

use Srosato\BowlingBundle\Model\Game;
use Srosato\BowlingBundle\Model\GameFactory;

class GameProgressionTest extends \PHPUnit_Framework_TestCase
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
    public function gameShouldNotBeCompletedWhenScoringASpareOnLastFrame()
    {
        $game = $this->gameFactory->createGutterGameUpToLastFrame();

        $this->assertFalse($game->isCompleted());

        $game->pinsDown(5);
        $game->spare();

        $this->assertFalse($game->isCompleted());

        $game->pinsDown(5);

        $this->assertTrue($game->isCompleted());
    }

    /**
     * @test
     */
    public function gameShouldBeCompletedWhenScoringAStrikeOnTheLastRollOfTheLastFrame()
    {
        $game = $this->gameFactory->createGutterGameUpToLastFrame();

        $this->assertFalse($game->isCompleted());

        $game->strike();
        $this->assertFalse($game->isCompleted());

        $game->strike();
        $this->assertFalse($game->isCompleted());

        $game->strike();
        $this->assertTrue($game->isCompleted());
    }

    /**
     * @test
     */
    public function fullGamesShouldHaveTenFramesAndBeCompleted()
    {
        $gameFactory = $this->gameFactory;

        $game = $gameFactory->createGutterGame();
        $this->assertCount(10, $game->getFrames());
        $this->assertTrue($game->isCompleted());

        $game = $gameFactory->createPerfectGame();
        $this->assertCount(10, $game->getFrames());
        $this->assertTrue($game->isCompleted());

        $game = $gameFactory->createSpareGame();
        $this->assertCount(10, $game->getFrames());
        $this->assertTrue($game->isCompleted());
    }
}
