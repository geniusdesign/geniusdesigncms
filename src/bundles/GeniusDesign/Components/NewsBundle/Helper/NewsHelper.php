<?php

namespace GeniusDesign\Components\NewsBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper for the news
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class NewsHelper {

    /**
     * The container
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Class constructor
     * 
     * @param ContainerInterface $container The container
     * @return void
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * Returns container
     * @return ContainerInterface
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     * Returns information whether to show the picture
     * @return boolean
     */
    public function isImageEnabled() {
        return $this->getContainer()
                        ->getParameter('genius_design_components_news.show_image');
    }

    /**
     * Returns information whether to show the autor
     * @return boolean
     */
    public function isAutorEnabled() {
        return $this->getContainer()
                        ->getParameter('genius_design_components_news.show_autor');
    }

    /**
     * Returns information whether to show the date
     * @return boolean
     */
    public function isDateEnabled() {
        return $this->getContainer()
                        ->getParameter('genius_design_components_news.show_date');
    }

}
