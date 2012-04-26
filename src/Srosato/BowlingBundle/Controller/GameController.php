<?php

namespace Srosato\BowlingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;

use Srosato\BowlingBundle\Model\Game;

use FOS\Rest\Util\Codes as HttpCodes;

/**
 * The game controller provides an API for game CRUD and playing.
 */
class GameController extends Controller
{
    /**
     * Creates a new game and persists it. Posting as ajax will return a created status while posting
     * as a form will redirect to the game view.
     *
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function postGameAction()
    {
        $session = $this->getRequest()->getSession();
        $session->set('game', new Game());

        $view = View::create();

        if( $this->getRequest()->isXmlHttpRequest() ) {
            $view->setStatusCode(HttpCodes::HTTP_CREATED);
            return $view;
        }

        /* @var $handler \FOS\RestBundle\View\ViewHandler */
        $handler = $this->get('fos_rest.view_handler');

        $format = $this->getRequest()->getRequestFormat();
        if( $handler->isFormatTemplating($format) ) {
            return $handler->createRedirectResponse($view, $this->generateUrl('get_game'), $format);
        }

        $view->setStatusCode(HttpCodes::HTTP_METHOD_NOT_ALLOWED);

        return $view;
    }

    /**
     * Viewing a game will return a marshalled game representation for ajax requests and a game view
     * for html requests.
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getGameAction()
    {
        $session = $this->getRequest()->getSession();

        $view = View::create()
            ->setTemplate(new TemplateReference('SrosatoBowlingBundle', 'Game', 'view'))
        ;

        if( false !== ($game = $session->get('game', false)) ) {
            /* @var $handler \FOS\RestBundle\View\ViewHandler */
            $handler = $this->get('fos_rest.view_handler');
            $format = $this->getRequest()->getRequestFormat();
            if( $handler->isFormatTemplating($format) ) {
                $data = array('game' => $game);
            } else {
                $data = $game;
            }

            $view->setData($data);
        } else {
            $view->setStatusCode(HttpCodes::HTTP_NOT_FOUND);
        }

        return $view;
    }

    /**
     * @param int pins [optional] The number of pins
     *
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function postGameRollAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        $pins = $this->getRequest()->get('pins', rand(1,10));
        $view = View::create();

        /* @var $game Game */
        if( false !== ($game = $session->get('game', false)) ) {
            $game->pinsDown($pins);

            if( $this->getRequest()->isXmlHttpRequest() ) {
                $view->setStatusCode(HttpCodes::HTTP_CREATED);
                return $view;
            }

            /* @var $handler \FOS\RestBundle\View\ViewHandler */
            $handler = $this->get('fos_rest.view_handler');

            $format = $this->getRequest()->getRequestFormat();
            if( $handler->isFormatTemplating($format) ) {
                return $handler->createRedirectResponse($view, $this->generateUrl('get_game'), $format);
            }
        } else {
            $view->setStatusCode(HttpCodes::HTTP_NOT_FOUND);
        }

        return $view;
    }

    public function getGameScoreAction()
    {
        $session = $this->getRequest()->getSession();
        $view = View::create();

        /* @var $game Game */
        if( false !== ($game = $session->get('game', false)) ) {
            $view->setData($game->getScore());
        } else {
            $view->setStatusCode(HttpCodes::HTTP_NOT_FOUND);
        }

        return $view;
    }
}
