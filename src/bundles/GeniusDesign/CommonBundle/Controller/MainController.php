<?php

namespace GeniusDesign\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class MainController extends Controller {

    /**
     * Returns Session
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    protected function getSession() {
        return $this->get('session');
    }

    /**
     * Gets the flashbag interface.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
     */
    public function getFlashBag() {
        return $this->getSession()->getFlashBag();
    }

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

    /**
     * Clears flashes, if required.
     * 
     * Flashes are cleared when current url is served by different controller
     * than referer url, so it's different / another module.
     * 
     * @return boolean
     */
    private function clearFlashes() {
        $request = $this->getRequest();

        //$refererUrl = $this->getRefererUrl(false);
        //$requestUrl = $request->getRequestUri();
        //if (!$this->get('xxx.request.helper')->isTheSameControllerUsed($refererUrl, $requestUrl)) {
        $request->getSession()->clearFlashes();
        return true;
        //}

        return false;
    }

    /**
     * Adds / sets flash message
     * 
     * @param string $type The type
     * @param string | array $message The message(s)
     * @return \Stermedia\AppHelperBundle\Controller\ModelController
     */
    public function addFlashMessage($type, $message) {
        if (!empty($type) && !empty($message)) {
            $flashBag = $this->getFlashBag();
            $messages = $message;

            if (!is_array($message)) {
                $messages = array($message);
            }

            foreach ($messages as $message) {
                $flashBag->add($type, $message);
            }
        }

        return $this;
    }

}
