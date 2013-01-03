<?php

namespace GeniusDesign\BackendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use GeniusDesign\Components\ContentBundle\Form\ContentType;

/**
 * Content mangament
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class ContentController extends MainController {

    /**
     * Display content list
     * @return Response
     */
    public function listAction() {
        $languageLcid = $this->getLanguageLcid();
        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsContentBundle:Content')
                ->setLanguageLcid($languageLcid);

        $contents = $repository->getContents();

        /*
         * Displaying the template
         */
        $parameters = array(
            'contents' => $contents,
            'languageCode' => $this->getLanguageCode()
        );

        return $this->render('GeniusDesignBackendBundle:Content:list.html.twig', $parameters);
    }

    /**
     * Display content list
     * @return Response
     */
    public function editAction($contentSlug) {
        $languageLcid = $this->getLanguageLcid();
        $request = $this->getRequest();
        
        $entityManager = $this->getDoctrine()->getEntityManager();
        $repository = $entityManager->getRepository('GeniusDesignComponentsContentBundle:Content')
                ->setLanguageLcid($languageLcid);

        $content = $repository->getContentBySlug($contentSlug);

        if ($content === null) {
            return $this->redirectTo();
        }

        $form = $this->createForm(new ContentType(), $content);

        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $content->setTranslatableLocale($languageLcid);
                
                $entityManager->persist($content);
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
            'content' => $content,
            'languageCode' => $this->getLanguageCode()
        );
        return $this->render('GeniusDesignBackendBundle:Content:edit.html.twig', $parameters);
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
            $route = 'genius_content_list';
        }

        $parameters = array_merge($parameters, array('languageCode' => $this->getLanguageCode()));
        return parent::redirectTo($route, $parameters);
    }

}
