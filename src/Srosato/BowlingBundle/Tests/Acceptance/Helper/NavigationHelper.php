<?php

namespace Srosato\BowlingBundle\Tests\Acceptance\Helper;

use Majisti\UtilsBundle\Test\MinkTestCase;

use Srosato\BowlingBundle\Tests\Acceptance\AbstractAcceptanceTest;

class NavigationHelper
{
    const WAIT_TIMEOUT = 1500;

    /**
     * @var AbstractAcceptanceTest
     */
    private $test;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @param AbstractAcceptanceTest $test
     */
    public function __construct(AbstractAcceptanceTest $test)
    {
        $this->test = $test;
        $this->baseUrl = $test->getContainer()->getParameter('behat.mink.base_url');
    }

    /**
     * @return AbstractAcceptanceTest
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @return \Behat\Mink\Session
     */
    public function getSession()
    {
        return $this->getTest()->getSession();
    }

    public function visitGame()
    {
        $session = $this->getSession();

        $session->visit($this->baseUrl . '/game');
        $session->wait(self::WAIT_TIMEOUT, "$('.bowling').length > 0");
    }
}
