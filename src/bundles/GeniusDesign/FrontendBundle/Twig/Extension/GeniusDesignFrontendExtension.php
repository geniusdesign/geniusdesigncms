<?php

namespace GeniusDesign\FrontendBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig extension for the frontend bundle
 */
class GeniusDesignFrontendExtension extends \Twig_Extension {

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
     * Returns a list of functions to add to the existing list
     * @return array
     */
    public function getFunctions() {
        return array(
            'genius_frontend_menu_items' => new \Twig_Function_Method($this, 'getFrontendMenuItems')
        );
    }

    /**
     * Returns the name of the extension
     * @return string
     */
    public function getName() {
        return 'genius_design_frontend_menu_items';
    }

    /**
     * Returns frontend menu items
     * 
     * @return array
     */
    public function getFrontendMenuItems() {
        $manager = $this->getContainer()
                ->get('doctrine')
                ->getEntityManager();

        return $manager->getRepository('GeniusDesignFrontendBundle:MenuItem')
                        ->getRows();
    }

}