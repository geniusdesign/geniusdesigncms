<?php

namespace GeniusDesign\BackendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use GeniusDesign\Components\NewsBundle\Form\NewsType;

/**
 * News mangament
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsController extends MainController {

    /**
     * Display news list
     * @return Response
     */
    public function listAction() {
        /*
         * Retrieving the language code
         */
        $language = 'pl'; //$this->getLanguageCode();

        /*
         * The repository
         */
        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsNewsBundle:News');

        $news = $repository->getNews($language);

        /*
         * Displaying the template
         */
        $parameters = array(
            'news' => $news,
            'language' => $language,
            'dateFormat' => 'd.m.Y'
        );

        return $this->render('GeniusDesignBackendBundle:News:list.html.twig', $parameters);
    }

    /**
     * Display news list
     * @return Response
     */
    public function editAction($newsSlug) {
        $language = 'pl'; //$this->getLanguageCode();
        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getEntityManager();

        $repository = $entityManager->getRepository('GeniusDesignComponentsNewsBundle:News');
        $news = $repository->getNewsBySlug($newsSlug, $language);

        if ($news === null) {
            return $this->redirectTo();
        }

        $form = $this->createForm(new NewsType(), $news);
        
        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $entityManager->persist($news);
                $entityManager->flush();

                return $this->redirectTo();
            }
        }
        
        /*
         * Displaying the template
         */
        $parameters = array(
            'form' => $form->createView(),
            'news' => $news,
            'language' => $language
        );
        return $this->render('GeniusDesignBackendBundle:News:edit.html.twig', $parameters);
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
            $route = 'genius_news_list';
        }

        return parent::redirectTo($route, $parameters);
    }
    
}
