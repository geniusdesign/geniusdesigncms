<?php

namespace GeniusDesign\BackendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use GeniusDesign\Components\NewsBundle\Form\NewsType;
use GeniusDesign\Components\NewsBundle\Entity\News;

/**
 * News mangament
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsController extends MainController {

    /**
     * Displays news list
     * @return Response
     */
    public function listAction() {
        $newsHelper = $this->get('genius_design_news.helper');
        $languageLcid = $this->getLanguageLcid();

        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsNewsBundle:News')
                ->setLanguageLcid($languageLcid);

        $news = $repository->getNews();

        $parameters = array(
            'news' => $news,
            'languageCode' => $this->getLanguageCode(),
            'dateFormat' => 'd.m.Y',
            'isImageVisible' => $newsHelper->isImageEnabled(),
            'isDateVisible' => $newsHelper->isDateEnabled()
        );

        return $this->render('GeniusDesignBackendBundle:News:list.html.twig', $parameters);
    }

    /**
     * Displays one news
     * @return Response
     */
    public function editAction($newsSlug) {
        return $this->commonForAddAndEdit($newsSlug);
    }

    /**
     * Adds news
     * @return Response
     */
    public function addAction() {
        $newsSlug = 0;
        return $this->commonForAddAndEdit($newsSlug);
    }

    /**
     * 
     * @param int $newsSlug
     * @return type 
     */
    private function commonForAddAndEdit($newsSlug) {
        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getEntityManager();
        $newsHelper = $this->get('genius_design_news.helper');
        $news = null;
        $isAddsNews = false;

        $languageLcid = $this->getLanguageLcid();

        if (empty($newsSlug)) {
            $newsSlug = 0;
        }

        if ($newsSlug === 0) {
            $news = new News();
            $isAddsNews = true;
        } else {
            $repository = $entityManager->getRepository('GeniusDesignComponentsNewsBundle:News')
                    ->setLanguageLcid($languageLcid);
            $news = $repository->getNewsBySlug($newsSlug);
        }

        if ($news === null) {
            return $this->redirectTo();
        }

        $dateVisible = $newsHelper->isDateEnabled();
        $imageVisible = $newsHelper->isImageEnabled();
        $autorVisible = $newsHelper->isAutorEnabled();
        $formatDate = 'dd.MM.yyyy';
        $date = $news->getDisplayedDate();

        if (empty($date)) {
            $news->setDisplayedDate(new \DateTime());
        }

        $form = $this->createForm(new NewsType($autorVisible, $dateVisible, $imageVisible, $formatDate), $news);

        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $uploadHelper = $this->get('genius_design_upload.helper');
                $news->setUploadHelper($uploadHelper)
                        ->setTranslatableLocale($languageLcid);

                $entityManager->persist($news);
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
            'news' => $news,
            'languageCode' => $this->getLanguageCode(),
            'isImageVisible' => $imageVisible,
            'isAddsNews' => $isAddsNews
        );
        return $this->render('GeniusDesignBackendBundle:News:add-and-edit.html.twig', $parameters);
    }

    /**
     * Deletes news by given slug
     * @return Response
     */
    public function deleteAction($newsSlug) {
        $type = 'error';
        $message = 'Nie usunąłem';

        if (!empty($newsSlug)) {
            $repository = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('GeniusDesignComponentsNewsBundle:News');

            $news = $repository->getNewsBySlug($newsSlug);

            if (!empty($news)) {
                $deleted = true;
                $imageFileName = $news->getImageFileName();

                if (!empty($imageFileName)) {
                    $entityConfigName = 'genius_design_components_news';
                    $deleted = $this->get('genius_design_upload.helper')->removeFile($entityConfigName, $imageFileName, true, false);
                }

                if ($deleted) {
                    $repository->deleteNewsById($news->getId());
                    $type = 'notice';
                    $message = 'Usunąłem';
                }
            }
        }

        $this->addFlashMessage($type, $message);
        return $this->redirectTo();
    }

    /**
     * Toogle published parameter for news by given news slug
     * @return Response
     */
    public function togglePublishedAction($newsSlug) {
        $type = 'error';
        $message = 'Nie zmieniłem';

        if (!empty($newsSlug)) {
            $repository = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('GeniusDesignComponentsNewsBundle:News');

            $result = $repository->tooglePublishedBySlug($newsSlug);

            if ($result) {
                $type = 'notice';
                $message = 'Zmieniłem';
            }
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
            $route = 'genius_news_list';
        }

        $parameters = array_merge($parameters, array('languageCode' => $this->getLanguageCode()));
        return parent::redirectTo($route, $parameters);
    }

}
