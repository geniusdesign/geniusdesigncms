<?php

namespace GeniusDesign\Components\LanguageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GeniusDesignComponentsLanguageExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /*
         * Name of request language parameter
         */
        if (isset($config['language_request_parameter_name'])) {
            $container->setParameter('genius_design_language.language_request_parameter_name', trim($config['language_request_parameter_name']));
        }
        
        /*
         * Default language code
         */
        if (isset($config['default_language_code'])) {
            $container->setParameter('genius_design_language.default_language_code', trim($config['default_language_code']));
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
