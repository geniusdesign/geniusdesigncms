<?php

namespace GeniusDesign\FrontendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;

class FrontendController extends MainController {

    /**
     * Default action for menu items from database
     * 
     * @return Response 
     */
    public function indexAction($slug) {
        $languageLcid = $this->getLanguageLcid();
        $template = 'GeniusDesignFrontendBundle:Pages:%s.html.twig';
        $viewname = 'default';
        $titleMenuItem = 'Brak tytułu';

        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignFrontendBundle:MenuItem')
                ->setLanguageLcid($languageLcid);

        $menuItem = $repository->getMenuItemBySlug($slug);

        if (empty($menuItem)) {
            $menuItem = $repository->getDefaultMenuItem($slug);
        }

        if (!empty($menuItem)) {
            $value = $menuItem->getViewname();

            if (!empty($value)) {
                $viewname = $menuItem->getViewname();
            }

            $value = $menuItem->getTitle();

            if (!empty($value)) {
                $titleMenuItem = $menuItem->getTitle();
            }
        }

        $parameters = array(
            'menuItem' => $menuItem,
            'titleMenuItem' => $titleMenuItem
        );

        return $this->render(sprintf($template, $viewname), $parameters);
    }

}
