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
                ->scalarNode('deleted_files_path')
                    ->defaultValue('%kernel.root_dir%/../web/deleted_files')
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
