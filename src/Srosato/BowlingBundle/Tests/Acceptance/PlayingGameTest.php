<?php

namespace Srosato\BowlingBundle\Tests\Acceptance;

class PlayingGameTest extends AbstractAcceptanceTest
{
    public function setUp()
    {
        $this->getGameHelper()->startNewGame();
    }

    /**
     * @test
     */
    public function viewingGameShouldDisplayTheCurrentScore()
    {
        $gameHelper = $this->getGameHelper();
        $gameHelper->roll();

        $this->getNavigationHelper()->visitGame();

        $gameHelper->assertScoreBetween(1, 10);
    }

    /**
     * @test
     */
    public function rollingABallShouldIncrementTheScore()
    {
        $helper = $this->getGameHelper();

        $helper->roll();

        $helper->assertScoreBetween(1, 10);
    }
}
