<?php

namespace GeniusDesign\CommonBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Route;

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
     * Returns no picture template path
     * @return string
     */
    public function getNoPictureTemplatePath() {
        return $this->getContainer()->getParameter('genius_design_common.no_picture_template_path');
    }

    /**
     * Returns no picture sizes
     * @return string
     */
    public function getNoPictureSizes() {
        return $this->getContainer()->getParameter('genius_design_common.no_picture_sizes');
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
     * Returns the route object for given route's name
     * 
     * @param string $routeName Name of the route
     * @return \Symfony\Component\Routing\Route
     */
    public function getRoute($routeName) {
        return $this->getContainer()
                        ->get('router')
                        ->getRouteCollection()
                        ->get($routeName);
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

    /**
     * Returns parameters required by given route
     * 
     * @param [string $routeName = ''] Name of the route
     * @return array
     */
    public function getRequiredParameters($routeName = '') {
        $parameters = array();

        $languagesHelper = $this->getContainer()->get('genius_design_language.helper');
        $languageRequestParameter = $languagesHelper->getLanguageRequestParameterName();

        if ($languagesHelper->areLanguagesDefined() && !empty($languageRequestParameter)) {
            if ($this->isParameterUsedInRouting($languageRequestParameter, $routeName)) {
                $parameters[$languageRequestParameter] = $languagesHelper->getLanguageCode();
            }
        }

        return $parameters;
    }

    /**
     * Returns information if given parameter is used by given route.
     * If no route is passed, current route is used.
     * 
     * @param string $parameter Name of the parameter to check
     * @param [string $routeName = ''] Name of the route
     * @return boolean
     * 
     * @throws RouteNotFoundException 
     */
    public function isParameterUsedInRouting($parameter, $routeName = '') {
        $parameters = array();
        $route = null;

        if (empty($routeName)) {
            $routeName = $this->getContainer()
                    ->get('request')
                    ->attributes
                    ->get('_route');
        }

        if (is_string($routeName)) {
            $route = $this->getRoute($routeName);
        }

        if (!($route instanceof Route)) {
            throw new RouteNotFoundException(sprintf('The route \'%s\' doesn\'t exist!', $routeName));
        }

        $parameters = $route->getDefaults();

        return key_exists($parameter, $parameters);
    }

    /**
     * Returns information if there is required of parameters
     * For the rebuild if will be the other parameters
     * 
     * @param [string $routeName = ''] Name of the route
     * @return boolean 
     */
    public function isLanguageParameterMissing($routeName = '') {
        $needed = false;

        $languagesHelper = $this->getContainer()->get('genius_design_language.helper');

        $languageCode = $languagesHelper->getLanguageCode(false);
        $languageRequestParameter = $languagesHelper->getLanguageRequestParameterName();

        if ($languagesHelper->areLanguagesDefined() && empty($languageCode) && !empty($languageRequestParameter)) {
            if (!$needed && $this->isParameterUsedInRouting($languageRequestParameter, $routeName)) {
                $value = $languagesHelper->getLanguageCode(false);

                if (empty($value)) {
                    $needed = true;
                }
            }
        }

        return $needed;
    }

}
