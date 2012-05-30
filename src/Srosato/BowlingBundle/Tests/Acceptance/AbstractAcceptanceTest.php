<?php

namespace Srosato\BowlingBundle\Tests\Acceptance;

use Majisti\UtilsBundle\Test\MinkTestCase;

abstract class AbstractAcceptanceTest extends MinkTestCase
{
    /**
     * @var Helper\GameHelper
     */
    protected $gameHelper;

    /**
     * @var Helper\NavigationHelper
     */
    protected $navigationHelper;

    /**
     * @param \Exception $e
     * @throws \Exception
     */
    protected function onNotSuccessfulTest(\Exception $e)
    {
        $session = $this->getSession();

        if( null !== $session ) {
            /* @var $driver \Behat\MinkBundle\Driver\SymfonyDriver */
            $driver = $session->getDriver();

            if( null !== $driver && $driver instanceof \Behat\MinkBundle\Driver\SymfonyDriver ) {
                $client = $driver->getClient();

                if( null !== $client ) {
                    $response = $client->getResponse();

                    if( null !== $response ) {
                        print $response->getContent();
                    }
                }
            }
        }

        throw $e;
    }

    /**
     * @param $locator
     *
     * @return \Behat\Mink\Element\NodeElement|null
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

    /**
     * @return Helper\GameHelper
     */
    public function getGameHelper()
    {
        if( null === $this->gameHelper ) {
            $this->gameHelper = new Helper\GameHelper($this);
        }

        return $this->gameHelper;
    }

    /**
     * @return Helper\NavigationHelper
     */
    public function getNavigationHelper()
    {
        if( null === $this->navigationHelper ) {
            $this->navigationHelper = new Helper\NavigationHelper($this);
        }

        return $this->navigationHelper;
    }
}
