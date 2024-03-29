<?php

namespace GeniusDesign\CommonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('genius_design_common');

        $rootNode
            ->children()
                ->arrayNode('no_picture')
                    ->children()
                        ->scalarNode('template_path')
                            ->defaultValue('/upload/news/no-picture-%s.png')
                        ->end()
                        ->arrayNode('sizes')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('deleted_files_path')
                    ->defaultValue('%kernel.root_dir%/../web/deleted_files')
                ->end()
                ->arrayNode('date_format')
                    ->children()
                        ->scalarNode('form')
                            ->defaultValue('dd.MM.yyyy')
                        ->end()
                        ->scalarNode('datapicker')
                            ->defaultValue('dd.mm.yyyy')
                        ->end()
                        ->scalarNode('twig')
                            ->defaultValue('d.m.Y')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
