<?php

namespace Srosato\BowlingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;

use FOS\Rest\Util\Codes as HttpCodes;

class GameController extends Controller
{
    /**
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function postGameAction()
    {
        $session = $this->getRequest()->getSession();
        $session->set('game', true);

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
     * @return \FOS\RestBundle\View\View
     */
    public function getGameAction()
    {
        $session = $this->getRequest()->getSession();

        $view = View::create()
            ->setTemplate(new TemplateReference('SrosatoBowlingBundle', 'Game', 'view'))
        ;

        if( false !== $session->get('game', false) ) {
            $view->setData(array(
                     'id' => 'foo'
                 ))
            ;
        } else {
            $view->setStatusCode(HttpCodes::HTTP_NOT_FOUND);
        }

        return $view;
    }
}
