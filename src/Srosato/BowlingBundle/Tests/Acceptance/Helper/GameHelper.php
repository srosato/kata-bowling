<?php

namespace Srosato\BowlingBundle\Tests\Acceptance\Helper;

use Majisti\UtilsBundle\Test\MinkTestCase;

use Srosato\BowlingBundle\Tests\Acceptance\AbstractAcceptanceTest;

class GameHelper
{
    /**
     * @var AbstractAcceptanceTest
     */
    private $test;

    /**
     * @param AbstractAcceptanceTest $test
     */
    public function __construct(AbstractAcceptanceTest $test)
    {
        $this->test = $test;
    }

    /**
     * @return AbstractAcceptanceTest
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param string $expectedTitle
     */
    public function assertTitle($expectedTitle)
    {
        $test = $this->getTest();
        $title = $test->findCss('.bowling .title');

        $test->assertNotNull($title, "Game title should be there");
        $test->assertEquals($expectedTitle, $title->getText(), "Game title is wrong");
    }

    public function assertScoreBetween($min, $max)
    {
        $test = $this->getTest();
        $score = $this->getScore();

        $test->assertGreaterThanOrEqual($min, $score, "Score should be greater than {$score}");
        $test->assertLessThanOrEqual($max, $score, "Score should be less than {$score}");
    }

    public function startNewGame()
    {
        $test = $this->getTest();

        $session = $test->getSession();
        $session->visit('/game');

        $this->getNewGameButton()->press();
    }

    /**
     * @return \Behat\Mink\Element\Behat\Mink\Element\NodeElement|null
     */
    public function getNewGameButton()
    {
        return $this->getTest()->getSession()->getPage()->findButton('new-game');
    }

    /**
     * @return \Behat\Mink\Element\Behat\Mink\Element\NodeElement|null
     */
    public function getRollButton()
    {
        return $this->getTest()->getSession()->getPage()->findButton('roll');
    }

    public function getScore()
    {
        return (int)$this->getTest()->findCss('.bowling .score-wrapper .score')->getHtml();
    }

    public function roll()
    {
        $this->getRollButton()->press();
    }
}
