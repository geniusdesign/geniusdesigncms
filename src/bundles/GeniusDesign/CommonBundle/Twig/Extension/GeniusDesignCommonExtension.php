<?php

namespace GeniusDesign\CommonBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig extension for the common bundle
  W */
class GeniusDesignCommonExtension extends \Twig_Extension {

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
            'genius_design_file_path' => new \Twig_Function_Method($this, 'getPathToFile'),
            'datapickerFormat' =>  new \Twig_Function_Method($this, 'getDatapickerFormat'),
        );
    }

    /**
     * Returns the name of the extension
     * @return string
     */
    public function getName() {
        return 'genius_design_common';
    }

    /**
     * Returns path for the file
     * 
     * @return string
     */
    public function getPathToFile($entityConfigName, $fileName, $size, $withPathBase = true, $relative = false) {
        $helper = $this->getContainer()->get('genius_design_upload.helper');
        return $helper->getFilePath($entityConfigName, $fileName, $size, $withPathBase, $relative);
    }
    
    /**
     * Returns datapicker format
     * @return string
     */
    public function getDatapickerFormat() {
        return $this->getContainer()->getParameter('genius_design_common.date_format.datapicker');
    }
}