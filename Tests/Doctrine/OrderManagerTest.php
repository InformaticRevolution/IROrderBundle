<?php

/*
 * This file is part of the IROrderBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\OrderBundle\Tests\Doctrine;

use IR\Bundle\OrderBundle\Model\OrderInterface;
use IR\Bundle\OrderBundle\Doctrine\OrderManager;

/**
 * Order Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OrderManagerTest extends \PHPUnit_Framework_TestCase
{
    const ORDER_CLASS = 'IR\Bundle\OrderBundle\Tests\TestOrder';
 
    /**
     * @var OrderManager
     */
    protected $orderManager;      
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;    
    
    
    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }  
                
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
                
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(self::ORDER_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(self::ORDER_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(self::ORDER_CLASS));        
        
        $this->orderManager = new OrderManager($this->objectManager, self::ORDER_CLASS);
    } 
    
    public function testUpdateOrder()
    {
        $order = $this->getOrder();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($order));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->orderManager->updateOrder($order);
    } 
    
    public function testDeleteOrder()
    {
        $order = $this->getOrder();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($order));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->orderManager->deleteOrder($order);
    }   
    
    public function testFindOrderBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->orderManager->findOrderBy($criteria);
    } 
    
    public function testFindOrdersBy()
    {
        $criteria = array("foo" => "bar");
        $orderBy = array("foo" => "asc");
        $limit = 3;
        $offset = 0;
        
        $this->repository->expects($this->once())
            ->method('findBy')
            ->with(
                $this->equalTo($criteria), 
                $this->equalTo($orderBy), 
                $this->equalTo($limit), 
                $this->equalTo($offset)
            )
            ->will($this->returnValue(array()));

        $this->orderManager->findOrdersBy($criteria, $orderBy, $limit, $offset);
    }       
    
    public function testGetClass()
    {
        $this->assertEquals(self::ORDER_CLASS, $this->orderManager->getClass());
    }    
    
    /**
     * @return OrderInterface
     */
    protected function getOrder()
    {
        $class = self::ORDER_CLASS;

        return new $class();
    }      
}
