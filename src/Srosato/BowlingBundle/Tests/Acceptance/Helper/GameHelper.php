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

    /**
     * @return AbstractAcceptanceTest
     */
    public function getTest()
    {
        return $this->test;
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
        $score = $this->getTest()->findCss('.bowling .score-wrapper .score');

        if( null !== $score ) {
            return (int)$score->getHtml();
        }

        return null;
    }

    public function startNewGame()
    {
        $test = $this->getTest();

        $test->getNavigationHelper()->visitGame();

        $newGameButton = $this->getNewGameButton();

        if( null !== $newGameButton ){
            $newGameButton->press();
            $this->getTest()->getSession()->wait(500);
        }
    }

    public function roll()
    {
        $rollButton = $this->getRollButton();

        if( null !== $rollButton ) {
            $rollButton->press();
            $this->getTest()->getSession()->wait(500);
        }
    }
}
