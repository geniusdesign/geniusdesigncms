<?php

namespace GeniusDesign\Components\GalleryBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('genius_design_components_gallery');

        $rootNode
            ->children()
                ->scalarNode('onlyImagesMode')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('showGalleryDescription')
                    ->defaultValue(true)
                ->end()
                ->scalarNode('showImageAutor')
                    ->defaultValue(true)
                ->end()
                ->arrayNode('upload')
                    ->children()
                        ->arrayNode('paths')
                            ->children()
                                ->scalarNode('relative')
                                    ->defaultValue('/upload/gallery')
                                ->end()
                                ->scalarNode('absolute')
                                    ->defaultValue('%kernel.root_dir%/../web/upload/gallery')
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
