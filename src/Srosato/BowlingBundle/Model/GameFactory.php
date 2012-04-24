<?php

namespace Srosato\BowlingBundle\Model;

class GameFactory
{
    /**
     * @return \Srosato\BowlingBundle\Model\Game
     */
    public function createNewGame()
    {
        return new Game();
    }

    /**
     * @return \Srosato\BowlingBundle\Model\Game
     */
    public function createGutterGame()
    {
        $game = $this->createNewGame();

        for( $i = 0; $i < 20; $i++ ) {
            $game->gutter();
        }

        return $game;
    }

    /**
     * @return \Srosato\BowlingBundle\Model\Game
     */
    public function createGutterGameUpToLastFrame()
    {
        $game = $this->createNewGame();

        for( $i = 0; $i < 18; $i++ ) {
            $game->gutter();
        }

        return $game;
    }

    /**
     * @return \Srosato\BowlingBundle\Model\Game
     */
    public function createPerfectGame()
    {
        $game = $this->createNewGame();

        for( $i = 0; $i < 12; $i++ ) {
            $game->strike();
        }

        return $game;
    }

    /**
     * @return \Srosato\BowlingBundle\Model\Game
     */
    public function createSpareGame()
    {
        $game = $this->createNewGame();

        for( $i = 0; $i < 10; $i++ ) {
            $game->pinsDown(9);
            $game->spare();
        }

        $game->gutter();

        return $game;
    }
}