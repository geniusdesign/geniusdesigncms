<?php

namespace GeniusDesign\Components\LanguageBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper for the language
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class LanguageHelper {

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
     * Returns informations if languages are defined
     * @return boolean 
     */
    public function areLanguagesDefined() {
        $result = false;

        $languages = $this->getContainer()
                ->get('doctrine')
                ->getRepository('GeniusDesignComponentsLanguageBundle:Language')
                ->getRows();

        if (!empty($languages)) {
            $result = true;
        }

        return $result;
    }

}
