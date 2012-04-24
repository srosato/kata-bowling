<?php

namespace Srosato\BowlingBundle\Tests\Functional;

use Majisti\UtilsBundle\Test\MinkTestCase;

class GameApiTest extends MinkTestCase
{
    /**
     * @test
     */
    public function startNewGame()
    {
        $this->getSession()->visit('/game/new');
        $response = $this->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getResponse()
    {
        /* @var $driver \Behat\MinkBundle\Driver\SymfonyDriver */
        $driver = $this->getSession('symfony')->getDriver();
        $client = $driver->getClient();

        return $client->getResponse();
    }

    protected function onNotSuccessfulTest(\Exception $e)
    {
        print $this->getSession()->getPage()->getContent();

        throw $e;
    }
}
