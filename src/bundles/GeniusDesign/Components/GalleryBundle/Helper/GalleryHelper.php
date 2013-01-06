<?php

namespace GeniusDesign\Components\GalleryBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Helper for the gallery
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GalleryHelper {

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
    public function isOnlyImagesModeEnabled() {
        return $this->getContainer()
                        ->getParameter('genius_design_components_gallery.show_only_images_mode');
    }

    /**
     * Returns information whether to show the autor
     * @return boolean
     */
    public function isGalleryDescriptionEnabled() {
        return $this->getContainer()
                        ->getParameter('genius_design_components_gallery.show_gallery_description');
    }

    /**
     * Returns information whether to show the date
     * @return boolean
     */
    public function isImageAutorEnabled() {
        return $this->getContainer()
                        ->getParameter('genius_design_components_gallery.show_image_autor');
    }

}
