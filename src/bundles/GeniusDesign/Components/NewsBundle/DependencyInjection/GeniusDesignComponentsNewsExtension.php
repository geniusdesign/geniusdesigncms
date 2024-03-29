<?php

namespace GeniusDesign\Components\NewsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GeniusDesignComponentsNewsExtension extends Extension {

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
                    $container->setParameter('genius_design_components_news.upload.paths.relative', trim($paths['relative']));
                }

                if (isset($paths['absolute'])) {
                    $container->setParameter('genius_design_components_news.upload.paths.absolute', trim($paths['absolute']));
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
                        $container->setParameter(sprintf('genius_design_components_news.upload.size.%s', $name), str_replace(' ', '', trim($size)));
                    }
                }

                $container->setParameter('genius_design_components_news.upload.sizes', $values);
            }
        }

        /*
         * Returns information whether to show the picture
         */
        if (isset($config['showImage'])) {
            $container->setParameter('genius_design_components_news.show_image', (boolean) $config['showImage']);
        }

        /*
         * Returns information whether to show the autor
         */
        if (isset($config['showAutor'])) {
            $container->setParameter('genius_design_components_news.show_autor', (boolean) $config['showAutor']);
        }

        /*
         * Returns information whether to show the date
         */
        if (isset($config['showDate'])) {
            $container->setParameter('genius_design_components_news.show_date', (boolean) $config['showDate']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
