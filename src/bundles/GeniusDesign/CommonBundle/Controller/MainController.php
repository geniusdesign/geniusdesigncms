<?php

namespace GeniusDesign\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class MainController extends Controller {
    
    /**
     * Redirects to the route
     * 
     * @param string $route The name of the route
     * @param [array $parameters = array()] An array of parameters
     * @return Reponse
     */
    public function redirectTo($route, $parameters = array()) {
        $url = $this->generateUrl($route, $parameters);
        return $this->redirect($url);
    }
    
}
