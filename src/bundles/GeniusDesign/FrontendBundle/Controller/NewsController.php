<?php

namespace GeniusDesign\FrontendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;

class NewsController extends MainController {

    /**
     * Displays news list
     * @return Response 
     */
    public function listAction() {
        
        var_dump($this->isSimpleUserGranted('ROLE_ADMIN', true));
        
        $newsHelper = $this->get('genius_design_news.helper');
        $languageLcid = $this->getLanguageLcid();

        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsNewsBundle:News')
                ->setLanguageLcid($languageLcid);

        $news = $repository->getNews(0, 0, true);

        $parameters = array(
            'news' => $news,
            'languageCode' => $this->getLanguageCode(),
            'dateFormat' => 'd.m.Y',
            'isImageVisible' => $newsHelper->isImageEnabled(),
            'isDateVisible' => $newsHelper->isDateEnabled()
        );

        return $this->render('GeniusDesignFrontendBundle:News:list.html.twig', $parameters);
    }

    /**
     * Displays single news
     * @return Response 
     */
    public function singleAction($newsSlug) {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $newsHelper = $this->get('genius_design_news.helper');
        $languageLcid = $this->getLanguageLcid();

        $repository = $entityManager->getRepository('GeniusDesignComponentsNewsBundle:News')
                ->setLanguageLcid($languageLcid);
        
        $news = $repository->getNewsBySlug($newsSlug);

        if ($news === null) {
            return $this->redirectTo();
        }

        $parameters = array(
            'news' => $news,
            'languageCode' => $this->getLanguageCode(),
            'dateFormat' => 'd.m.Y',
            'isImageVisible' => $newsHelper->isImageEnabled(),
            'isDateVisible' => $newsHelper->isDateEnabled()
        );

        return $this->render('GeniusDesignFrontendBundle:News:single.html.twig', $parameters);
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
            $route = 'genius_frontend_news_list';
        }

        $parameters = array_merge($parameters, array('languageCode' => $this->getLanguageCode()));
        return parent::redirectTo($route, $parameters);
    }

}
