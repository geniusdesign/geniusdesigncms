<?php

namespace GeniusDesign\CommonBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper for the bundles
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class CommonHelper {

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
     * Returns name of the language parameter for request
     * @return string
     */
    public function getLanguageRequestParameterName() {
        return $this->getContainer()->getParameter('genius_design_common.language_request_parameter_name');
    }
    
    /**
     * Returns name of the current route
     * @return string
     */
    public function getCurrentRouteName() {
        return $this->getContainer()
                        ->get('request')
                        ->get('_route');
    }
    
    /**
     * Returns parameters from request
     * 
     * @param [boolean $skipSystemParametrs = true] If is set to true, system parameters are skipped, e.g. "_controller"
     * @return array
     */
    public function getParametersFromRequest($skipSystemParametrs = true) {
        $parameters = array();

        $attributes = $this->getContainer()
                ->get('request')
                ->attributes
                ->all();

        if (!empty($attributes)) {
            foreach ($attributes as $parameter => $value) {
                $firstChar = substr($parameter, 0, 1);
                
                if ($skipSystemParametrs && $firstChar == '_') {
                    continue;
                }

                $parameters[$parameter] = $value;
            }
        }

        return $parameters;
    }
    
}
