<?php

namespace GeniusDesign\Components\LanguageBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use GeniusDesign\CommonBundle\Functions\Strings;

/**
 * Twig extension for the languages
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GeniusDesignLanguageExtension extends \Twig_Extension {

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
            'genius_design_languages' => new \Twig_Function_Method($this, 'getLanguages'),
            'genius_design_show_languages' => new \Twig_Function_Method($this, 'showLanguages', array('is_safe' => array('html'))),
            'genius_design_languages_defined' => new \Twig_Function_Method($this, 'areLanguagesDefined')
        );
    }

    /**
     * Returns the name of the extension
     * @return string
     */
    public function getName() {
        return 'genius_design_language';
    }

    /**
     * Returns the languages
     * @return array
     */
    public function getLanguages() {
        return $this->getContainer()
                        ->get('doctrine')
                        ->getRepository('GeniusDesignComponentsLanguageBundle:Language')
                        ->getRows();
    }
    
    /**
     * Shows the languages
     * 
     * @param [string $viewName = ''] The name of view which displays the languages as flags, tabs etc.  
     * @return string
     */
    
    /**
     * Shows the languages
     * 
     * @param [string $viewName = ''] The name of view which displays the languages as flags, tabs etc.  
     * @param [boolean $showNames = true] If set to true shows only languages names. Otherwise - only flags.
     * @param [boolean $showBoth = true] If set to true shows flags and names either. Otherwise - one of the two depending on the $showNames.
     * @return type 
     */
    public function showLanguages($viewName = '', $showNames = true, $showBoth = true) {
        if (empty($viewName)) {
            $viewName = 'languages-buttons';
        }

        if (!Strings::contains($viewName, ':')) {
            $template = 'GeniusDesignComponentsLanguageBundle:Language:%s.html.twig';
            $viewName = sprintf($template, $viewName);
        }

        $languageParameterName = $this->getContainer()
                ->get('genius_design_common.helper')
                ->getLanguageRequestParameterName();
        
        $currentLanguageCode = $this->getContainer()
                ->get('request')
                ->get($languageParameterName);

        $routeName = $this->getContainer()
                ->get('genius_design_common.helper')
                ->getCurrentRouteName();

        $parametersFromRequest = $this->getContainer()
                ->get('genius_design_common.helper')
                ->getParametersFromRequest();

        $parameters = array(
            'routeName' => $routeName,
            'languages' => $this->getLanguages(),
            'parametersFromRequest' => $parametersFromRequest,
            'currentLanguageCode' => $currentLanguageCode,
            'languageParameterName' => $languageParameterName,
            'showNames' => $showNames,
            'showBoth' => $showBoth
        );

        return $this->getContainer()
                        ->get('templating')
                        ->render($viewName, $parameters);
    }
    
    /**
     * Returns information if languages are defined
     * @return boolean
     */
    public function areLanguagesDefined() {
        return $this->getContainer()
                        ->get('genius_design_language.helper')
                        ->areLanguagesDefined();
    }

}