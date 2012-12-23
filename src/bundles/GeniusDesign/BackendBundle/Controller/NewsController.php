<?php

namespace GeniusDesign\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
class NewsController extends Controller {

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
    public function editAction() {
        return $this->render('GeniusDesignBackendBundle:Security:login.html.twig');
    }
}
