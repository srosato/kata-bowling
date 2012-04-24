<?php

namespace Srosato\BowlingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

use FOS\Rest\Util\Codes as HttpCodes;

class GameController extends Controller
{
    /**
     * @return \FOS\RestBundle\View\View
     */
    public function postGameAction()
    {
        $session = $this->getRequest()->getSession();
        $session->set('game', true);

        $view = View::create()
            ->setStatusCode(HttpCodes::HTTP_CREATED)
        ;

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
