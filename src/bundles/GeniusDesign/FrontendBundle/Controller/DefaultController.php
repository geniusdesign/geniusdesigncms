<?php

namespace GeniusDesign\FrontendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;

class DefaultController extends MainController {
    public function indexAction($name)
    {
        return $this->render('GeniusDesignFrontendBundle:Default:index.html.twig', array('name' => $name));
    }
}
