<?php

namespace GeniusDesign\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Manages Default of the web pages
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class DefaultController extends Controller {

    /**
     * 
     * @return Response
     */
    public function indexAction() {

        $parameters = array();
        return $this->render('GeniusDesignBackendBundle:Default:default.html.twig', $parameters);
    }

}
