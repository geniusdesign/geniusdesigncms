<?php

namespace GeniusDesign\BackendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use GeniusDesign\BackendBundle\Form\LoginType;

/**
 * Provides security logic
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class SecurityController extends MainController {

    /**
     * Used for authentication
     * @return void
     */
    public function loginAction() {
        $error = null;
        $errorMessage = '';

        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        if ($error !== null && $error instanceof \RuntimeException) {
            switch (strtolower($error->getMessage())) {
                case 'bad credentials':
                case 'the presented password is invalid.':
                    $errorMessage = 'Nieprawidłowe dane';
                    break;
            }
        }

        $form = $this->createForm(new LoginType());

        /*
         * Displaying the template
         */
        $parameters = array(
            'lastUsername' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $errorMessage,
            'form' => $form->createView()
        );

        return $this->render('GeniusDesignBackendBundle:Security:login.html.twig', $parameters);
    }

}
