<?php

namespace Srosato\BowlingBundle\Tests\Functional;

use Majisti\UtilsBundle\Test\MinkTestCase;

class StartingNewGameTest extends MinkTestCase
{
    public function testStartNewGame()
    {
        $session = $this->getSession();
        $session->visit('/game/new');

        $title = $this->findCss('.bowling .title');

        $this->assertNotNull($title);
        $this->assertEquals("New bowling game", $title->getText());
    }

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
    public function findCss($locator)
    {
        return $this->getSession()->getPage()->find('css', $locator);
    }

    /**
     * @param $locator
     *
     * @return bool
     */
    public function hasCss($locator)
    {
        return $this->getSession()->getPage()->has('css', $locator);

    }
}
