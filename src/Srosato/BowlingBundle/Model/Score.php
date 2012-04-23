<?php

namespace Srosato\BowlingBundle\Model;

/**
 * Calculates the score of a given game
 */
class Score
{
    /**
     * @param \Srosato\BowlingBundle\Model\Game $game
     *
     * @return int
     */
    public function calculate(Game $game)
    {
        $score = 0;
        $rollIterator = $game->getRolls()->getIterator();

        while( $rollIterator->valid() ) {

            /* @var $roll Roll */
            $roll = $rollIterator->current();
            $score += $roll->getValue();

            if( $roll->isBonusApplicable() ) {
                $score += $this->getBonusFromNextRolls($roll->getBonusRollCount(),
                    $game->getRolls()->getIterator(), $rollIterator->key() + 1);
            }

            $rollIterator->next();
        }

        return $score;
    }

    /**
     * @param int $numberOfNextRolls
     * @param \ArrayIterator $rollIterator
     * @param int $rollIndex
     *
     * @return int
     */
    private function getBonusFromNextRolls($numberOfNextRolls, \ArrayIterator $rollIterator, $rollIndex)
    {
        $bonus = 0;

        try {
            $rollIterator->seek($rollIndex);
        } catch( \OutOfBoundsException $e ) {
            return $bonus;
        }

        $rollCounter = 0;
        while( $rollIterator->valid() && $rollCounter < $numberOfNextRolls ) {
            /* @var $roll Roll */
            $roll = $rollIterator->current();

            $bonus += $roll->getValue();

            $rollIterator->next();
            $rollCounter++;
        }

        return $bonus;
    }
}