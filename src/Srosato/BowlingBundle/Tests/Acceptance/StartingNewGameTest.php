<?php

namespace Srosato\BowlingBundle\Tests\Acceptance;

use Majisti\UtilsBundle\Test\MinkTestCase;

class StartingNewGameTest extends MinkTestCase
{
    public function testStartNewGame()
    {
        $this->markTestIncomplete();

        $session = $this->getSession();
        $session->visit('/game/new');

        $this->assertPageContainsText($session, "New bowling game", $session->getPage()->getContent());
    }
}
