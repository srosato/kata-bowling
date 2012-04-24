<?php

namespace Srosato\BowlingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/game")
 */
class GameController extends Controller
{
    /**
     * @Route("/new")
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newGameAction()
    {
        return array();
    }
}
