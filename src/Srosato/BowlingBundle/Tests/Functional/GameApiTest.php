<?php

namespace Srosato\BowlingBundle\Tests\Functional;

use Majisti\UtilsBundle\Test\MinkTestCase;
use FOS\Rest\Util\Codes as HttpCodes;

class GameApiTest extends MinkTestCase
{
    /**
     * @return \Symfony\Component\BrowserKit\Client
     */
    private function getClient()
    {
        /* @var $driver \Behat\MinkBundle\Driver\SymfonyDriver */
        $driver = $this->getSession('symfony')->getDriver();

        return $driver->getClient();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getResponse()
    {
        return $this->getClient()->getResponse();
    }

    protected function onNotSuccessfulTest(\Exception $e)
    {
        print $this->getSession()->getPage()->getContent();

        throw $e;
    }

    private function requestNewGame()
    {
        $this->getClient()->request('POST', '/game.json');
    }

    private function requestGame()
    {
        $this->getClient()->request('GET', '/game.json');
    }

    /**
     * @test
     */
    public function postShouldReturnThatAGameWasCreated()
    {
        $this->requestNewGame();
        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getGameShouldReturnNotFoundIfNoGameWasCreated()
    {
        $this->requestGame();
        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getGameShouldReturnAGameIfAGameWasPreviouslyCreated()
    {
        $this->requestNewGame();
        $this->requestGame();
        $response = $this->getResponse();

        $expectedGame = array(
            'id' => 'foo'
        );

        $this->assertEquals(HttpCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedGame, json_decode($response->getContent(), true));
    }
}
