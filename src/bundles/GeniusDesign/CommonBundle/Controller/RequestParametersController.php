<?php

namespace GeniusDesign\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller used for update optional parameters in routing / request
 */
class RequestParametersController extends Controller {

    /**
     * Updates required parameters
     * @return Response
     */
    public function updateParametersAction() {
        $commonHelper = $this->get('genius_design_common.helper');
       
        $routeName = $commonHelper->getCurrentRouteName();
        $parameters = array_merge($commonHelper->getParametersFromRequest(), $commonHelper->getRequiredParameters($routeName));

        $url = $this->generateUrl($routeName, $parameters);
        return $this->redirect($url);
    }

}