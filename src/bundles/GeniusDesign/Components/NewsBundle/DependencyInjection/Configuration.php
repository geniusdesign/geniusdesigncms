<?php

namespace GeniusDesign\Components\NewsBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('genius_design_components_news');
        
        $rootNode
            ->children()
                ->scalarNode('showImage')
                    ->defaultValue(true)
                ->end()
                ->scalarNode('showAutor')
                    ->defaultValue(true)
                ->end()
                ->scalarNode('showDate')
                    ->defaultValue(true)
                ->end()
                ->arrayNode('upload')
                    ->children()
                        ->arrayNode('paths')
                            ->children()
                                ->scalarNode('relative')
                                    ->defaultValue('/upload/news')
                                ->end()
                                ->scalarNode('absolute')
                                    ->defaultValue('%kernel.root_dir%/../web/upload/news')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('sizes')
                            ->children()
                                ->scalarNode('tiny')
                                    ->defaultValue('70x35')
                                ->end()
                                ->scalarNode('small')
                                    ->defaultValue('120x80')
                                ->end()
                                ->scalarNode('large')
                                    ->isRequired()
                                    ->defaultValue('800x600')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
