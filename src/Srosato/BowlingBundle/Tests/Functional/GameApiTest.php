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
    public function postShouldReturnThatAGameWasCreatedAndReturnARedirectionResponseToGameView()
    {
        $client = $this->getClient();
        $client->followRedirects(false);

        $client->request('POST', '/game');
        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_FOUND, $response->getStatusCode());
        $this->assertEquals('/game', $response->headers->get('location'), "Response is not redirecting to proper location");
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
    public function getGameAsJsonShouldReturnAnEmptyGameIfAGameWasPreviouslyCreated()
    {
        $client = $this->getClient();
        $client->request('POST', '/game.json');
        $client->request('GET', '/game.json');

        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(array(), json_decode($response->getContent(), true), "Game data should be empty");
    }

    /**
     * @test
     */
    public function postRollShouldReturnNotFoundIfNoGameWasCreated()
    {
        $this->getClient()->request('POST', '/game/roll.json');
        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function aiaxPostRollShouldReturnCreatedWhenAGameIsActive()
    {
        $client = $this->getClient();

        $client->request('POST', '/game.json');
        $client->request('POST', '/game/roll.json', array(), array(), array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'));

        $response = $this->getResponse();

        $this->assertEquals(HttpCodes::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function getGameScoreShouldReturnNotFoundOnNoActiveGame()
    {
        $client = $this->getClient();
        $client->request('GET', '/game/score.json');

        $response = $this->getResponse();
        $this->assertEquals(HttpCodes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function postRollWithGivenPinsShouldReturnARedirectionResponseToGameView()
    {
        $client = $this->getClient();
        $client->followRedirects(false);

        $client->request('POST', '/game.json');
        $client->request('POST', '/game/roll', array(
            'pins' => 3
        ));

        $response = $this->getResponse();
        $this->assertEquals(HttpCodes::HTTP_FOUND, $response->getStatusCode());
        $this->assertEquals('/game', $response->headers->get('location'), "Response is not redirecting to proper location");
    }

    /**
     * @test
     */
    public function ajaxPostRollWithGivenPinsAndGetGameShouldReturnProperGameScore()
    {
        $client = $this->getClient();

        $client->request('POST', '/game.json');
        $client->request('POST', '/game/roll.json', array(
            'pins' => 3
        ));
        $client->request('GET', '/game/score.json', array(), array(), array('HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'));

        $response = $this->getResponse();

        $this->assertEquals(3, json_decode($response->getContent()), "Game score is wrong");
    }
}
