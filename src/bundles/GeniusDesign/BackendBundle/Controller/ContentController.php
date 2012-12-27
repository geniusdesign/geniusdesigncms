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
        $language = 'pl'; //$this->getLanguageCode();
        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsContentBundle:Content');

        $contents = $repository->getContents($language);
       
        /*
         * Displaying the template
         */
        $parameters = array(
            'contents' => $contents,
            'language' => $language
        );
        
        return $this->render('GeniusDesignBackendBundle:Content:list.html.twig', $parameters);
    }
    
    /**
     * Display content list
     * @return Response
     */
    public function editAction($contentSlug) {
        $language = 'pl'; //$this->getLanguageCode();
        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getEntityManager();

        $repository = $entityManager->getRepository('GeniusDesignComponentsContentBundle:Content');

        $content = $repository->getContentBySlug($contentSlug, $language);

        if ($content === null) {
            return $this->redirectTo();
        }

        $form = $this->createForm(new ContentType(), $content);
        
        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $entityManager->persist($content);
                $entityManager->flush();

                return $this->redirectTo();
            }
        }
        
        /*
         * Displaying the template
         */
        $parameters = array(
            'form' => $form->createView(),
            'content' => $content,
            'language' => $language
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

        return parent::redirectTo($route, $parameters);
    }
    
}
