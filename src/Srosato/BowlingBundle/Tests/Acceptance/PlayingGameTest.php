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
    public function rollingABallShouldIncrementTheScore()
    {
        $helper = $this->getGameHelper();

        $helper->roll();

        $helper->assertScoreBetween(1, 10);
    }
}
