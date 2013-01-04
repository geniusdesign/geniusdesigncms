<?php

namespace GeniusDesign\Components\MenuBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig extension for the menu bundle
 */
class GeniusDesignComponentsMenuExtension extends \Twig_Extension {

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
            'display_simple_menu' => new \Twig_Function_Method($this, 'displayMenu', array('is_safe' => array('html')))
        );
    }

    /**
     * Returns the name of the extension
     * @return string
     */
    public function getName() {
        return 'genius_design_menu';
    }

    /**
     * Returns path for the file
     * 
     * @return string
     */
    public function displayMenu(array $menuItems, $displayAsUl = true, $templateMenu = '', $separator = '', $classCss = '', $displayTitles = true) {
        if (empty($templateMenu)) {
            $templateMenu = 'simple-menu';
        }

        $parameters = array(
            'menuItems' => $menuItems,
            'separator' => $separator,
            'classCss' => $classCss,
            'displayAsUl' => $displayAsUl,
            'displayTitles' => $displayTitles,
            'templateMenu' => $templateMenu
        );

        return $this->getContainer()
                        ->get('templating')
                        ->render(sprintf('GeniusDesignComponentsMenuBundle:Menu:%s.html.twig', $templateMenu), $parameters);
    }

}