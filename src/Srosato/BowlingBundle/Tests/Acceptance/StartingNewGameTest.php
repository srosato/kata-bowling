<?php

namespace Srosato\BowlingBundle\Tests\Acceptance;

use Majisti\UtilsBundle\Test\MinkTestCase;

class StartingNewGameTest extends MinkTestCase
{
    /**
     * @param \Exception $e
     * @throws \Exception
     */
    protected function onNotSuccessfulTest(\Exception $e)
    {
        print $this->getSession()->getPage()->getContent();

        throw $e;
    }

    /**
     * @param $locator
     *
     * @return  \Behat\Mink\Element\NodeElement|null
     */
    private function findCss($locator)
    {
        return $this->getSession()->getPage()->find('css', $locator);
    }

    /**
     * @param $locator
     *
     * @return bool
     */
    private function hasCss($locator)
    {
        return $this->getSession()->getPage()->has('css', $locator);

    }

    /**
     * @test
     */
    public function visitTheGamePageShouldReturnNoGameAndSuggestToStartANewOne()
    {
        $session = $this->getSession();
        $session->visit('/game');

        $title = $this->findCss('.bowling .title');
        $this->assertNotNull($title);
        $this->assertEquals("You have not started a bowling game yet", $title->getText());

        $newGameButton = $this->getSession()->getPage()->findButton('new-game');
        $this->assertNotNull($newGameButton);
        $this->assertEquals("Start game", $newGameButton->getHtml());
    }

    /**
     * @test
     */
    public function startNewGame()
    {
        $session = $this->getSession();
        $session->visit('/game');

        /* @var $newGameButton \Behat\Mink\Element\NodeElement */
        $newGameButton = $this->getSession()->getPage()->findButton('new-game');
        $newGameButton->press();

        $title = $this->findCss('.bowling .title');
        $this->assertNotNull($title);
        $this->assertEquals("You have not started a bowling game yet", $title->getText());
    }
}
