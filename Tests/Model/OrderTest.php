<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Tests\Model;

use IR\Bundle\OrderBundle\Model\OrderInterface;
use IR\Bundle\OrderBundle\Model\OrderItemInterface;

/**
 * Order Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $order = $this->getOrder();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $order->getItems());
    }
    
    public function testAddItem()
    {
        $order = $this->getOrder();
        $item = $this->getItem();
        
        $this->assertNotContains($item, $order->getItems());
        $this->assertNull($item->getOrder());
        
        $this->assertSame($order, $order->addItem($item));
        
        $this->assertContains($item, $order->getItems());
        $this->assertSame($order, $item->getOrder());
    }        

    public function testRemoveItem()
    {
        $order = $this->getOrder();
        $item = $this->getItem();
        $order->addItem($item);
        
        $this->assertContains($item, $order->getItems());
        $this->assertSame($order, $item->getOrder());
        
        $order->removeItem($item);
        
        $this->assertNotContains($item, $order->getItems());
        $this->assertNull($item->getOrder());
    }      
    
    public function testHasItem()
    {
        $order = $this->getOrder();
        $item = $this->getItem();
        
        $this->assertFalse($order->hasItem($item));
        $order->addItem($item);
        $this->assertTrue($order->hasItem($item));
    }    
    
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $order = $this->getOrder();
        
        $this->assertEquals($default, $order->$getter());
        $this->assertSame($order, $order->$setter($value));
        $this->assertEquals($value, $order->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('invoiceNumber', '2797418358', null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),
        );
    } 
    
    /**
     * @return OrderInterface
     */
    protected function getOrder()
    {
        return $this->getMockForAbstractClass('IR\Bundle\OrderBundle\Model\Order');
    }      
    
    /**
     * @return OrderItemInterface
     */
    protected function getItem()
    {
        return $this->getMockForAbstractClass('IR\Bundle\OrderBundle\Model\OrderItem');
    }    
}
