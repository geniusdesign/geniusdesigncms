<?php

namespace GeniusDesign\Components\SimpleUserBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use GeniusDesign\Components\SimpleUserBundle\Form\SimpleUserLoginType;
use GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser;
use Symfony\Component\HttpFoundation\Session;

class SimpleUserController extends MainController {

    /**
     * logout
     * @return Response 
     */
    public function logoutAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($session->has('simple_user')) {
            $session->set('simple_user', null);
        }

        $this->addFlashMessage('notice', 'Wylogowałem');
        return $this->redirectToReferer();
    }

    /**
     * login
     * @return Response 
     */
    public function loginAction() {
        $logged = false;
        $user = null;
        
        $request = $this->getRequest();
        $session = $request->getSession();
        $helperSimpleUser = $this->get('genius_design_simple_user.helper');
        $form = $this->createForm(new SimpleUserLoginType());

        if ($session->get('simple_user') instanceof SimpleUser) {
            $logged = true;
        }

        if (strtolower($request->getMethod()) == 'post' && !$logged) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $formData = $form->getData();

                if (isset($formData['email']) && isset($formData['password'])) {
                    $email = $formData['email'];
                    $password = $formData['password'];

                    $manager = $this->getDoctrine()
                            ->getEntityManager();

                    $user = $manager->getRepository('GeniusDesignComponentsSimpleUserBundle:SimpleUser')
                            ->getUserByEmail($email);

                    if (empty($user)) {
                        $this->addFlashMessage('error', 'Błędny login lub hasło');
                    } else {
                        $token = $user->getSalt();

                        if ($user instanceof SimpleUser && $helperSimpleUser->arePasswordsIdentical($password, $user->getPassword(), $token)) {
                            $session->set('simple_user', $user);

                            $this->addFlashMessage('notice', 'Zalogowałem');
                        } else {
                            $this->addFlashMessage('error', 'Błędny login lub hasło');
                        }
                    }
                } else {
                    $this->addFlashMessage('error', 'Błąd logowania');
                }
            }
        }
        
        return $this->redirectToReferer();
    }

}
