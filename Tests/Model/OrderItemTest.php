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
 * Order Item Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $item = $this->getItem();
        
        $this->assertEquals($default, $item->$getter());
        $this->assertSame($item, $item->$setter($value));
        $this->assertEquals($value, $item->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('order', $this->getOrder(), null),
            array('quantity', 3, 1),
            array('unitPrice', 15.99, null),
        );
    } 
    
    /**
     * @return OrderItemInterface
     */
    protected function getItem()
    {
        return $this->getMockForAbstractClass('IR\Bundle\OrderBundle\Model\OrderItem');
    }
    
    /**
     * @return OrderInterface
     */
    protected function getOrder()
    {
        return $this->getMock('IR\Bundle\OrderBundle\Model\OrderInterface');
    }    
}
