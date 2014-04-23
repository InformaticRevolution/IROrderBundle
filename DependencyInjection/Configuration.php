<?php

/*
 * This file is part of the IROrderBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ir_order');

        $supportedDrivers = array('orm');
        
        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()  
                ->scalarNode('order_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('order_item_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('order_manager')->defaultValue('ir_order.manager.order.default')->end()
            ->end();        
        
        $this->addOrderSection($rootNode);
        $this->addOrderItemSection($rootNode);
        $this->addTemplateSection($rootNode);
        
        return $treeBuilder;
    } 

    private function addOrderSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('order')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_order')->end()
                                ->scalarNode('name')->defaultValue('ir_order_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Order', 'Default'))
                                ->end()                
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
    
    private function addOrderItemSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('order_item')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_order_item')->end()
                                ->scalarNode('name')->defaultValue('ir_order_item_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Order', 'Default'))
                                ->end()                
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }    

    private function addTemplateSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('engine')->defaultValue('twig')->end()
                    ->end()
                ->end()
            ->end();
    }      
}
