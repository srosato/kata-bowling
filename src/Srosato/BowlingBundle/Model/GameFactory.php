<?php

namespace Srosato\BowlingBundle\Model;

class GameFactory
{
    /**
     * @return \Srosato\BowlingBundle\Model\Game
     */
    public function createGutterGame()
    {
        $game = new Game();

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
        $game = new Game();

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
        $game = new Game();

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
        $game = new Game();

        for( $i = 0; $i < 10; $i++ ) {
            $game->pinsDown(9);
            $game->spare();
        }

        return $game;
    }
}