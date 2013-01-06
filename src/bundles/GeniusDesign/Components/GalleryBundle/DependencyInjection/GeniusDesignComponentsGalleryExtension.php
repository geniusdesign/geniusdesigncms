<?php

namespace GeniusDesign\Components\GalleryBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GeniusDesignComponentsGalleryExtension extends Extension {

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /*
         * Parameters for uploading
         */
        if (isset($config['upload'])) {
            $uploadSettings = $config['upload'];

            /*
             * Paths: relative and absolute
             */
            if (isset($uploadSettings['paths'])) {
                $paths = $uploadSettings['paths'];

                if (isset($paths['relative'])) {
                    $container->setParameter('genius_design_components_gallery.upload.paths.relative', trim($paths['relative']));
                }

                if (isset($paths['absolute'])) {
                    $container->setParameter('genius_design_components_gallery.upload.paths.absolute', trim($paths['absolute']));
                }
            }

            /*
             * Thumbnails sizes
             */
            if (isset($uploadSettings['sizes'])) {
                $sizes = $uploadSettings['sizes'];
                $values = array();

                foreach ($sizes as $name => $size) {
                    if (!empty($size)) {
                        $values[$name] = $size;
                        $container->setParameter(sprintf('genius_design_components_gallery.upload.size.%s', $name), str_replace(' ', '', trim($size)));
                    }
                }

                $container->setParameter('genius_design_components_gallery.upload.sizes', $values);
            }


            /*
             * Returns information whether to show gallery in only images mode
             */
            if (isset($config['onlyImagesMode'])) {
                $container->setParameter('genius_design_components_gallery.show_only_images_mode', (boolean) $config['onlyImagesMode']);
            }

            /*
             * Returns information whether to show the gallery description
             */
            if (isset($config['showGalleryDescription'])) {
                $container->setParameter('genius_design_components_gallery.show_gallery_description', (boolean) $config['showGalleryDescription']);
            }

            /*
             * Returns information whether to show the image autor
             */
            if (isset($config['showImageAutor'])) {
                $container->setParameter('genius_design_components_gallery.show_image_autor', (boolean) $config['showImageAutor']);
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
