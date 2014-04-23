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

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Order Extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IROrderExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        $loader->load(sprintf('driver/%s/order.xml', $config['db_driver']));
        $loader->load('listener.xml');
                
        $container->setParameter('ir_order.db_driver', $config['db_driver']);
        $container->setParameter('ir_order.model.order.class', $config['order_class']);
        $container->setParameter('ir_order.model.order_item.class', $config['order_item_class']);
        $container->setParameter('ir_order.template.engine', $config['template']['engine']);
        $container->setParameter('ir_order.backend_type_' . $config['db_driver'], true);
        
        $container->setAlias('ir_order.manager.order', $config['order_manager']);

        if (!empty($config['order'])) {
            $this->loadOrder($config['order'], $container, $loader);
        }   
        
        if (!empty($config['order_item'])) {
            $this->loadOrderItem($config['order_item'], $container, $loader);
        }           
    }    

    private function loadOrder(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('order.xml');
        
        $container->setParameter('ir_order.form.name.order', $config['form']['name']);
        $container->setParameter('ir_order.form.type.order', $config['form']['type']);
        $container->setParameter('ir_order.form.validation_groups.order', $config['form']['validation_groups']);
    }   
    
    private function loadOrderItem(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('order_item.xml');
        
        $container->setParameter('ir_order.form.name.order_item', $config['form']['name']);
        $container->setParameter('ir_order.form.type.order_item', $config['form']['type']);
        $container->setParameter('ir_order.form.validation_groups.order_item', $config['form']['validation_groups']);
    }       
}
