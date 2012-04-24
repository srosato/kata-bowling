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

        $newGameLink = $this->getSession()->getPage()->findLink('new-game');
        $this->assertNotNull($newGameLink);
        $this->assertEquals("Start game", $newGameLink->getHtml());
    }

    /**
     * @test
     */
    public function startNewGame()
    {
        $this->markTestSkipped("Implementation on a new game will require a javascript supported driver");

        $session = $this->getSession();
        $session->visit('/game');

        /* @var $newGameLink \Behat\Mink\Element\NodeElement */
        $newGameLink = $this->getSession()->getPage()->findLink('new-game');
        $newGameLink->click();

        $title = $this->findCss('.bowling .title');
        $this->assertNotNull($title);
        $this->assertEquals("This is your bowling game", $title->getText());
    }
}
