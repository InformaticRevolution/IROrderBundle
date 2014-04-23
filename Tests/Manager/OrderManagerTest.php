<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Tests\Manager;

use IR\Bundle\OrderBundle\Manager\OrderManagerInterface;

/**
 * Order Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderManagerTest extends \PHPUnit_Framework_TestCase
{
    const ORDER_CLASS = 'IR\Bundle\OrderBundle\Tests\TestOrder';
 
    /**
     * @var OrderManagerInterface
     */
    protected $orderManager;      
    
    
    public function setUp()
    {
        $this->orderManager = $this->getMockForAbstractClass('IR\Bundle\OrderBundle\Manager\OrderManager');
        
        $this->orderManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(self::ORDER_CLASS));        
    }
    
    public function testCreateOrder()
    {        
        $order = $this->orderManager->createOrder();
        
        $this->assertInstanceOf(self::ORDER_CLASS, $order);
    }    
}
