<?php

namespace GeniusDesign\BackendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use GeniusDesign\Components\SimpleUserBundle\Form\SimpleUserType;
use GeniusDesign\Components\SimpleUserBundle\Entity\SimpleUser;

/**
 * SimpleUser mangament
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class SimpleUserController extends MainController {

    /**
     * Displays simpleUser list
     * @return Response
     */
    public function listAction() {
        $languageLcid = $this->getLanguageLcid();

        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsSimpleUserBundle:SimpleUser')
                ->setLanguageLcid($languageLcid);

        $users = $repository->getSimpleUsers();

        $parameters = array(
            'users' => $users,
            'languageCode' => $this->getLanguageCode(),
        );

        return $this->render('GeniusDesignBackendBundle:SimpleUser:list.html.twig', $parameters);
    }

    /**
     * Displays one simpleUser
     * @return Response
     */
    public function editAction($userId) {
        return $this->commonForAddAndEdit($userId);
    }

    /**
     * Adds user
     * @return Response
     */
    public function addAction() {
        $userId = 0;
        return $this->commonForAddAndEdit($userId);
    }

    /**
     * 
     * @param int $userId
     * @return type 
     */
    private function commonForAddAndEdit($userId) {
        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getEntityManager();
        $user = null;
        $isAddsSimpleUser = false;

        $languageLcid = $this->getLanguageLcid();

        $userId = (int) $userId;

        if ($userId === 0) {
            $user = new SimpleUser();
            $isAddsSimpleUser = true;
        } else {
            $repository = $entityManager->getRepository('GeniusDesignComponentsSimpleUserBundle:SimpleUser')
                    ->setLanguageLcid($languageLcid);
            $user = $repository->getRow($userId);
        }

        if ($user === null) {
            return $this->redirectTo();
        }

        $form = $this->createForm(new SimpleUserType($isAddsSimpleUser), $user);

        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                if ($isAddsSimpleUser) {
                    $salt = $user->getSalt();
                    $user->setPassword(md5(sprintf('%s(%s)', $user->getPassword(), $salt)));
                }

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlashMessage('notice', 'Zapisałem');
                return $this->redirectTo();
            }

            $this->addFlashMessage('error', 'Nie zapisałem');
        }

        /*
         * Displaying the template
         */
        $parameters = array(
            'form' => $form->createView(),
            'user' => $user,
            'languageCode' => $this->getLanguageCode(),
            'isAddsSimpleUser' => $isAddsSimpleUser
        );
        return $this->render('GeniusDesignBackendBundle:SimpleUser:add-and-edit.html.twig', $parameters);
    }

    /**
     * Deletes user by given slug
     * @return Response
     */
    public function deleteAction($userId) {
        $type = 'error';
        $message = 'Nie usunąłem';
        
        $userId = (int) $userId;

        if ($userId > 0) {
            $repository = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('GeniusDesignComponentsSimpleUserBundle:SimpleUser');

            $repository->deleteSimpleUserById($userId);
            $type = 'notice';
            $message = 'Usunąłem';
        }

        $this->addFlashMessage($type, $message);
        return $this->redirectTo();
    }

    /**
     * Redirects to the route
     * 
     * @param [string $route = ''] The name of the route
     * @param [array $parameters = array()] An array of parameters
     * @return Reponse
     */
    public function redirectTo($route = '', $parameters = array()) {
        if (empty($route)) {
            $route = 'genius_simple_user_list';
        }

        $parameters = array_merge($parameters, array('languageCode' => $this->getLanguageCode()));
        return parent::redirectTo($route, $parameters);
    }

}
