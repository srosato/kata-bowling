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

        $client =  $driver->getClient();
        $this->insulateClient($client);

        return $client;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getResponse()
    {
        return $this->getClient()->getResponse();
    }

    /**
     * @param \Exception $e
     * @throws \Exception
     */
    protected function onNotSuccessfulTest(\Exception $e)
    {
        print $this->getSession()->getPage()->getContent();

        throw $e;
    }

    private function requestNewGame()
    {
        $this->getClient()->request('POST', '/game.json');
    }

    /**
     * Client insulation is broken https://github.com/symfony/symfony/issues/1726
     */
    private function requestGame()
    {
        $this->getClient()->request('GET', '/game.json');
    }

    private function insulateClient($client)
    {
        $client->setServerParameter('HTTP_X_REQUESTED_WITH', null);
    }

    /**
     * @test
     */
    public function ajaxPostShouldReturnThatAGameWasCreated()
    {
        $client = $this->getClient();
        $client->setServerParameter('HTTP_X_REQUESTED_WITH', 'XMLHttpRequest');
        $client->request('POST', '/game.json');

        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function postShouldReturnThatAGameWasCreatedAndSendRedirectionResponseToGameView()
    {
        $client = $this->getClient();
        $client->followRedirects(false);

        $client->request('POST', '/game');
        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_FOUND, $response->getStatusCode());
        $this->assertEquals('/game', $response->headers->get('location'));
    }

    /**
     * @test
     */
    public function jsonPostShouldNotBeAnAllowedMethod()
    {
        $client = $this->getClient();
        $client->request('POST', '/game.json');

        $response = $this->getResponse();
        $this->assertEquals(HttpCodes::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getGameShouldReturnNotFoundIfNoGameWasCreated()
    {
        $this->getClient()->request('GET', '/game.json');
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
