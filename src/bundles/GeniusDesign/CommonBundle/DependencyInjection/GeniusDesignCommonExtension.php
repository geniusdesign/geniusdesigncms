<?php

namespace GeniusDesign\CommonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GeniusDesignCommonExtension extends Extension {

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        /*
         * Directory to deleted files
         */
        if (isset($config['language_request_parameter_name'])) {
            $container->setParameter('genius_design_common.language_request_parameter_name', trim($config['language_request_parameter_name']));
        }
        
        /*
         * Directory to deleted files
         */
        if (isset($config['deleted_files_path'])) {
            $container->setParameter('genius_design_common.deleted_files_path', trim($config['deleted_files_path']));
        }

        /*
         * Date formats
         */
        if (isset($config['date_format'])) {
            $formats = $config['date_format'];

            if (isset($formats['form'])) {
                $container->setParameter('genius_design_common.date_format.form', trim($formats['form']));
            }

            if (isset($formats['datapicker'])) {
                $container->setParameter('genius_design_common.date_format.datapicker', trim($formats['datapicker']));
            }

            if (isset($formats['twig'])) {
                $container->setParameter('genius_design_common.date_format.twig', trim($formats['twig']));
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
