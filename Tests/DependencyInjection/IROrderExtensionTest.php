<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IR\Bundle\OrderBundle\DependencyInjection\IROrderExtension;

/**
 * Order Extension Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IROrderExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** 
     * @var ContainerBuilder
     */
    protected $configuration;
    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testOrderLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }  

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testOrderLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }        
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testOrderLoadThrowsExceptionUnlessOrderModelClassSet()
    {
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        unset($config['order_class']);
        $loader->load(array($config), new ContainerBuilder());
    }  
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testOrderLoadThrowsExceptionUnlessOrderItemModelClassSet()
    {
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        unset($config['order_item_class']);
        $loader->load(array($config), new ContainerBuilder());
    }      

    public function testDisableOrder()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        $config['order'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_order.form.order');
    }
    
    public function testDisableOrderItem()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        $config['order_item'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_order.form.order_item');
    }    
    
    public function testOrderLoadModelClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Acme\OrderBundle\Entity\Order', 'ir_order.model.order.class');
        $this->assertParameter('Acme\OrderBundle\Entity\OrderItem', 'ir_order.model.order_item.class');
    }         
    
    public function testOrderLoadModelClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('Acme\OrderBundle\Entity\Order', 'ir_order.model.order.class');
        $this->assertParameter('Acme\OrderBundle\Entity\OrderItem', 'ir_order.model.order_item.class');
    }   
    
    public function testOrderLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('orm', 'ir_order.db_driver');
        $this->assertAlias('ir_order.manager.order.default', 'ir_order.manager.order');
    }      
    
    public function testOrderLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'ir_order.db_driver');
        $this->assertAlias('acme_order.manager.order', 'ir_order.manager.order');
    }    
    
    public function testOrderLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_order', 'ir_order.form.type.order');
        $this->assertParameter('ir_order_item', 'ir_order.form.type.order_item');
    }      

    public function testOrderLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_order', 'ir_order.form.type.order');
        $this->assertParameter('acme_order_item', 'ir_order.form.type.order_item');
    }      
    
    public function testOrderLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_order_form', 'ir_order.form.name.order');
        $this->assertParameter('ir_order_item_form', 'ir_order.form.name.order_item');
    }    

    public function testOrderLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_order_form', 'ir_order.form.name.order');
        $this->assertParameter('acme_order_item_form', 'ir_order.form.name.order_item');
    }    

    public function testOrderLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('ir_order.form.order');
    }    
    
    public function testOrderLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('ir_order.form.order'); 
    }    
    
    public function testOrderLoadTemplateConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('twig', 'ir_order.template.engine');
    }      
    
    public function testOrderLoadTemplateConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('php', 'ir_order.template.engine');
    }     
    
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IROrderExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }    
    
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IROrderExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }     
    
    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $parser = new Parser();
        
        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/minimal_config.yml'));
    }    
    
    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $parser = new Parser();

        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/full_config.yml'));
    }    
    
    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }    
    
    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is incorrect', $key));
    }    
    
    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }     
    
    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }    
    
    protected function tearDown()
    {
        unset($this->configuration);
    }     
}
