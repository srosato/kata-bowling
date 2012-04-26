<?php

namespace Srosato\BowlingBundle\Tests\Acceptance;

class StartingNewGameTest extends AbstractAcceptanceTest
{
    /**
     * @test
     */
    public function visitTheGamePageShouldReturnNoGameAndSuggestToStartANewOne()
    {
        $helper = $this->getGameHelper();

        $session = $this->getSession();
        $session->visit('/game');

        $helper->assertTitle("Click 'start game' to start a new bowling game");

        $newGameButton = $helper->getNewGameButton();
        $this->assertNotNull($newGameButton, "New game button should be there");
        $this->assertEquals("Start game", $newGameButton->getHtml(), "New game button text is wrong");
    }

    /**
     * @test
     */
    public function startingANewGameShouldDisplayANewGameWithTheScoreAndTheRollButton()
    {
        $helper = $this->getGameHelper();

        $helper->startNewGame();
        $helper->assertTitle("Game started");

        $wrapper = $this->findCss('.bowling .score-wrapper');
        $scoreTitle = $wrapper->find('css', '.title');
        $score = $wrapper->find('css', '.score');

        $this->assertNotNull($wrapper, "Score wrapper should be there");

        $this->assertNotNull($scoreTitle, "Score title should be there");
        $this->assertEquals("Score:", $scoreTitle->getText(), "Score title is wrong");

        $this->assertNotNull($score, "Score should be there");
        $this->assertEquals(0, $score->getText(), "Score should be 0");

        $rollButton = $helper->getRollButton();
        $this->assertNotNull($rollButton, "Roll button should be there");
        $this->assertEquals("Roll", $rollButton->getHtml(), "Roll button has wrong html");
    }
}
