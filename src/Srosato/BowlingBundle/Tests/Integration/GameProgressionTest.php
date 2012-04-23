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
    public function fullGamesShouldHaveTenFrames()
    {
        $this->assertCount(10, $this->gameFactory->createGutterGame()->getFrames());
        $this->assertCount(10, $this->gameFactory->createPerfectGame()->getFrames());
        $this->assertCount(10, $this->gameFactory->createSpareGame()->getFrames());
    }

    /**
     * @test
     */
    public function gameShouldBeCompletedWhenScoringASpareOnLastFrame()
    {
        $game = $this->gameFactory->createGutterGameUpToLastFrame();

        $this->assertFalse($game->isCompleted());

        $game->pinsDown(5);
        $game->spare();

        $this->assertTrue($game->isCompleted());
    }

    /**
     * @test
     */
    public function gameShouldOnlyBeCompletedWhenScoringAStrikeOnTheLastRollOfTheLastFrame()
    {
        $this->markTestSkipped();

        $game = $this->gameFactory->createGutterGameUpToLastFrame();

        $this->assertFalse($game->isCompleted());

        $game->strike();
        $this->assertFalse($game->isCompleted());

        $game->strike();
        $this->assertFalse($game->isCompleted());

        $game->strike();
        $this->assertTrue($game->isCompleted());
    }
}
